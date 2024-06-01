<?php

namespace App\Http\Controllers;

use App\Exports\RetribusiExport;
use App\Models\Pasar;
use App\Models\Retribusi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RetribusiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {

        if (Auth::user()->is_admin == true) {
            if (request('search')) {
                $retribusis = Retribusi::where(function ($query) use ($request) {
                    $query->where('nama_pedagang', 'like', '%' . $request->search . '%')
                        ->orWhere('alamat', 'like', '%' . $request->search . '%');})
                        ->oldest()->cursorPaginate(10)->withQueryString();
            } elseif (request('searchdate')) {
                $retribusis = Retribusi::where('created_at', 'like', '%' . request('searchdate') . '%')
                                    ->latest()->cursorPaginate(10)->withQueryString();
            } else {
                $retribusis = Retribusi::with('pasar')->latest()->cursorPaginate(10); 
            }
        }else {
            if (request('search')) {
                $retribusis = Retribusi::where(function ($query) {
                    $query->where(function ($subquery) {
                        $subquery->where('nama_pedagang', 'like', '%' . request('search') . '%')
                                 ->orWhere('alamat', 'like', '%' . request('search') . '%');
                    })->where(function ($subquery) {
                        $subquery->where('pasar_id', Auth::user()->pasar_id)
                                 ->orWhere('pasar_id', 'like', '%' . request('search') . '%');
                    });})->latest()->paginate(20);
    
            } elseif (request('searchdate')) {
                 $retribusis = Retribusi::where(function ($query) {
                    $query->where(function ($subquery) {
                        $subquery->where('created_at', 'like', '%' . request('searchdate') . '%');
                    })->where(function ($subquery) {
                        $subquery->where('pasar_id', Auth::user()->pasar_id);
                    });})->latest()->paginate(20);
            } else {
                $retribusis = Retribusi::where('pasar_id', Auth::user()->pasar_id)->latest()->cursorPaginate(10); 
            }
        }

       
        $pasars = Pasar::select('nama','id')->latest()->get();
        return view('dashboard.data.index',compact('retribusis','pasars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'pasar_id' => 'required|exists:pasars,id',
            'nama_pedagang' => 'required',
            'alamat' => 'required',
            'jenis_retribusi' => 'required|in:Parkir,Kebersihan,Izin Usaha,Pengelolaan Air,Penggunaan Jalan,Sampah,Keamanan,Perizinan Bangunan,Penggunaan Fasilitas Umum',
            'jumlah_pembayaran' => 'required|numeric',
            'metode_pembayaran' => 'required|in:Tunai,Transfer Bank,Kartu Kredit,Kartu Debit,E Wallet',
            'keterangan' => 'required|in:Lunas,Belum Lunas',
        ]);
        
         // Generate nomor pembayaran (INVtanggalbulantahunnourut)
        $no_pembayaran = 'INV' . date('Ymd') . Auth::user()->id . Retribusi::max('id');;

        // Simpan data retribusi ke dalam database
        $retribusi = new Retribusi($validatedData);
        $retribusi->no_pembayaran = $no_pembayaran;
        $retribusi->user_id = Auth::user()->id; // Petugas penerima retribusi diambil dari user yang login
        $retribusi->save();

        // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect('dashboard/retribusi')->with('success', 'Data retribusi berhasil disimpan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Retribusi $retribusi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Retribusi $retribusi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari request
        $validatedData = $request->validate([
            'pasar_id' => 'required|exists:pasars,id',
            'nama_pedagang' => 'required',
            'alamat' => 'required',
            'jenis_retribusi' => 'required|in:Parkir,Kebersihan,Izin Usaha,Pengelolaan Air,Penggunaan Jalan,Sampah,Keamanan,Perizinan Bangunan,Penggunaan Fasilitas Umum',
            'jumlah_pembayaran' => 'required|numeric',
            'metode_pembayaran' => 'required|in:Tunai,Transfer Bank,Kartu Kredit,Kartu Debit,E Wallet',
            'keterangan' => 'required|in:Lunas,Belum Lunas',
        ]);
    
        // Temukan data retribusi yang akan diupdate berdasarkan ID
        $retribusi = Retribusi::findOrFail($id);
    
        // Update data retribusi dengan data yang tervalidasi
        $retribusi->update($validatedData);
    
        // Update informasi petugas penerima jika diperlukan
        $retribusi->user_id = Auth::user()->id;
        
        // Simpan perubahan data retribusi ke dalam database
        $retribusi->save();
    
        // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect('dashboard/retribusi')->with('success', 'Data retribusi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $retribusi = Retribusi::find($id);

        
        $retribusi->delete();

        return redirect('dashboard/retribusi')->with('success', 'Data retribusi berhasil dihapus.');
    }

    public function export(Request $request, Retribusi $retribusi)
    {
        $date = $request->input('date');

        if (Auth::user()->is_admin) {
            $retribusi = Retribusi::whereDate('created_at', $date)->latest()->get();
            return Excel::download(new RetribusiExport($retribusi, $date), 'Retribusi_Pedagang-Admin.xlsx');
        } else {
            $retribusi = Retribusi::where('pasar', Auth::user()->operator)
                                ->whereDate('created_at', $date)
                                ->latest()->get();
            return Excel::download(new RetribusiExport($retribusi, $date), 'Retribusi_Pedagang-Operator.xlsx');
        }
    }
}

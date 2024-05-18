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

        if (request('search')) {
            $retribusis = Retribusi::where(function ($query) use ($request) {
                $query->where('nama_pedagang', 'like', '%' . $request->search . '%')
                      ->orWhere('alamat', 'like', '%' . $request->search . '%');})
                      ->oldest()->cursorPaginate(10)->withQueryString();
        } elseif (request('searchdate')) {
            $retribusis = Retribusi::where('created_at', 'like', '%' . request('searchdate') . '%')
                                   ->latest()->cursorPaginate(10)->withQueryString();
        } else {
            $retribusis = Retribusi::latest()->cursorPaginate(10); 
        }
        

       
        $pasars = Pasar::select('nama')->latest()->get();
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
            'pasar' => 'required|exists:pasars,nama',
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
        $retribusi->petugas_penerima = Auth::user()->name; // Petugas penerima retribusi diambil dari user yang login
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
    public function update(Request $request, Retribusi $retribusi)
    {
        //
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

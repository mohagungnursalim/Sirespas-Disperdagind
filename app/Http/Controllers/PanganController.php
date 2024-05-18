<?php

namespace App\Http\Controllers;

use App\Models\Pangan;
use App\Models\Komoditas;
use App\Models\User;
use App\Models\Pasar;
use App\Models\Satuan;
use App\Models\Barang;
use Illuminate\Http\Request;
use Alert;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Exports\TabelHargaExport;
use App\Models\Aduan;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class PanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $pasar = Pasar::select('nama')->latest()->get();
        $satuan = Satuan::select('nama')->oldest()->get();
        $barangs = Barang::select('nama','id')->oldest()->get();

        if (Auth::user()->is_admin == true) {
            // filter pasar berdasarka
                $selectedPasar = request('filter');
                if ($selectedPasar) {
                    // Ambil data komoditas dengan relasi barangs.pangans dan filter berdasarkan pasar yang difilter
                    $komoditas = Komoditas::with(['barangs.pangans' => function ($query) use ($selectedPasar) {
                        $query->where('pasar', $selectedPasar);
                    }])->oldest()->get();
                }else {
                     // data harga default yang ditampilkan adalah harga inpres manonda.
                    $komoditas = Komoditas::with(['barangs.pangans' => function ($query) {
                        $query->where('pasar', 'Pasar Inpres Manonda');
                    }])->oldest()->get();
                }
        }else {
                $komoditas = Komoditas::with(['barangs.pangans' => function ($query) {
                    $query->where('pasar', Auth::user()->operator);
                }])->oldest()->get(); 
        }


        return view('dashboard.data.index',[
            'pasars' => $pasar,
            'barangs' => $barangs,
            'komoditas' =>$komoditas,
            'satuans' => $satuan
        ]);
    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function create(Komoditas $komoditas)
    {
        return view('dashboard.data.create', [
            'title' => 'Input Data',
            'komoditas' => Komoditas::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Pangan $pangan)
    {

        // custom pesan error
        $messages = [
            'required' => ':attribute Wajib diisi!',
            'exists' => ':attribute Wajib diisi!'
        ];
       
        // validasi input
        $request->validate([
            'pasar' => 'required|exists:pasars,nama',
            'komoditas_id' => 'required|exists:komoditas,id',
            'satuan' => 'required|exists:satuans,nama',
            'barang_id' => 'required|exists:barangs,id',
            'harga' => 'required',
            'periode' => 'required'
        ],$messages);

        $komoditas_id = $request->input('komoditas_id');
        $pasar = $request->input('pasar');
        $user_id = $request['user_id'] = auth()->user()->id;
        $satuan = $request->input('satuan');
        $qty = $request->input('qty');
        $barang_id = $request->input('barang_id');
        $periode = $request->input('periode');
        $harga_sebelum = $request->input('harga_sebelum');
        $harga_terkini = $request->input('harga');
        
       // Mengecek apakah ada data dengan jenis barang yang sama
        $existingData = Pangan::where('barang_id', $barang_id)
        ->where('pasar', $pasar)
        ->exists();

        // Jika data sudah ada, tampilkan pesan error
        if ($existingData) {

            $request->session(Alert::error('Oops..', 'Hanya boleh sekali input pada barang yang sama'));
            return redirect()->back();
        }

        // Membandingkan harga sehingga menjadi keterangan
        if (isset($harga_sebelum)) {
            if ($harga_terkini > $harga_sebelum ) {
                $keterangan = '⬆️';
            } elseif ($harga_terkini < $harga_sebelum) {
                $keterangan = '⬇️';
            } elseif ($harga_terkini == $harga_sebelum) {
                $keterangan = '➖';
            } 
        } else {
        $keterangan = '➖' ;
         }

        // mencari selisih kenaikan/penurunan dari harga sebelumnya
        if (isset($harga_sebelum)) 
        {
            if ($harga_terkini > $harga_sebelum) 
            {
                $perubahan_rp = $harga_terkini - $harga_sebelum;
            }elseif ($harga_terkini < $harga_sebelum) 
            {
                $perubahan_rp = $harga_sebelum - $harga_terkini;
            }else{
                $perubahan_rp = 0;
            }
        }else {
            $perubahan_rp = 0;
        }
        
        if ($harga_sebelum) 
        {
            $perubahan = $harga_terkini - $harga_sebelum;
            $perubahan_persen = ($perubahan / $harga_sebelum) * 100;
        }else{
            $perubahan_persen = 0;
        }

        $data = new Pangan();
  
        $data->user_id  = $user_id;
        $data->komoditas_id = $komoditas_id;
        $data->pasar = $pasar;
        $data->satuan = $satuan;
        $data->qty = $qty;
        $data->barang_id = $barang_id;
        $data->periode = $periode;
        $data->harga_sebelum = $harga_sebelum;
        $data->harga = $harga_terkini;
        $data->perubahan_rp = $perubahan_rp;
        $data->perubahan_persen = $perubahan_persen;
        $data->keterangan = $keterangan;
        
        $data->save();

        $request->session(Alert::success('success', 'Data berhasil terinput!'));
        return redirect('/dashboard/harga-pangan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pangan $pangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pangan $pangan,Komoditas $komoditas)
    {
        return view('dashboard.data.edit', [
            'komoditas' => $komoditas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pangan $pangan, $id)
    {        
            $komoditas_id = $request->input('komoditas_id');
            $pasar = $request->input('pasar');
            $user_id = $request['user_id'] = auth()->user()->id;
            $satuan = $request->input('satuan');
            $qty = $request->input('qty');
            $barang_id = $request->input('barang_id');
            $periode = $request->input('periode');
            $harga_sebelum = $request->input('harga_sebelum');
            $harga_terkini = $request->input('harga');
        
            // Membandingkan harga sehingga menjadi keterangan
            if (isset($harga_sebelum)) {
                if ($harga_terkini > $harga_sebelum ) {
                    $keterangan = '⬆️';
                } elseif ($harga_terkini < $harga_sebelum) {
                    $keterangan = '⬇️';
                } elseif ($harga_terkini == $harga_sebelum) {
                    $keterangan = '➖';
                } 
            } else {
            $keterangan = '➖' ;
             }
    
            // mencari selisih kenaikan/penurunan dari harga sebelumnya
            if (isset($harga_sebelum)) 
            {
                if ($harga_terkini > $harga_sebelum) 
                {
                    $perubahan_rp = $harga_terkini - $harga_sebelum;
                }elseif ($harga_terkini < $harga_sebelum) 
                {
                    $perubahan_rp = $harga_sebelum - $harga_terkini;
                }else{
                    $perubahan_rp = 0;
                }
            }else {
                $perubahan_rp = 0;
            }
            
            if ($harga_sebelum) 
            {
                $perubahan = $harga_terkini - $harga_sebelum;
                $perubahan_persen = ($perubahan / $harga_sebelum) * 100;
            }else{
                $perubahan_persen = 0;
            }
    
           
    
            $data = Pangan::find($id);
    
            
            $data->user_id  = $user_id;
            $data->komoditas_id = $komoditas_id;
            $data->pasar = $pasar;
            $data->satuan = $satuan;
            $data->qty = $qty;
            $data->barang_id = $barang_id;
            $data->periode = $periode;
            $data->harga_sebelum = $harga_sebelum;
            $data->harga = $harga_terkini;
            $data->perubahan_rp = $perubahan_rp;
            $data->perubahan_persen = $perubahan_persen;
            $data->keterangan = $keterangan;
            
            // dd($data);
            $data->update();
        

            $request->session(Alert::success('success', 'Data berhasil diupdate!'));
            return redirect('/dashboard/harga-pangan');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Pangan $pangan,$id)
    {

        $pangan = Pangan::find($id);


        $pangan->delete();

        $request->session(Alert::success('success', 'Data berhasil dihapus!'));
            return redirect('/dashboard/harga-pangan');
    }




    public function dashboard(Pangan $pangan)
    {

        if (auth()->user()->is_admin == false) {
            $pangan = Pangan::where('user_id', auth()->user()->id)->count();
        } else {
            $pangan = Pangan::count(); // Menggunakan count() langsung
        }
        
        $komoditas = Komoditas::count();
        $user = User::count();
        $satuan = Satuan::count();
        $barang = Barang::count();
        $pasar = Pasar::count();
        $aduan = Aduan::count();
                
        return view('dashboard.dashboard',compact('pangan','komoditas','user','pasar','satuan','barang','aduan'));
    }

    public function export(Request $request)
    {
        $isAdmin = auth()->user()->is_admin;
        $filter = $request->input('filter');
    
        // Ekspor data harga ke dalam file Excel
        return Excel::download(new TabelHargaExport($isAdmin, $filter), 'Daftar-Harga.xlsx');
    }
   

}

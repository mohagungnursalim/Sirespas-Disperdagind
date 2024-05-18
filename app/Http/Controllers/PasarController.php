<?php

namespace App\Http\Controllers;

use App\Models\Pasar;
use Illuminate\Http\Request;
use Alert;

class PasarController extends Controller
{
    public function index()
    {

        
        
        $sertifikatada = Pasar::where('sertifikat', 'Ada')->count();
        $sertifikattidak = Pasar::where('sertifikat', 'Tidak')->count();
        $luas = Pasar::sum('luas_lahan');
        $jumlahpasar = Pasar::count('nama');

        $pedagang = Pasar::sum('pedagang');
        $kios_petak = Pasar::sum('kios_petak');
        $los_petak = Pasar::sum('los_petak');
        $lapak_pelataran = Pasar::sum('lapak_pelataran');
        $ruko = Pasar::sum('ruko');
        $baik = Pasar::sum('baik');
        $rusak = Pasar::sum('rusak');
        $terpakai = Pasar::sum('terpakai');
        $kepala_pasar = Pasar::sum('kepala_pasar');
        $kebersihan = Pasar::sum('kebersihan');
        $keamanan = Pasar::sum('keamanan');
        $retribusi = Pasar::sum('retribusi');

        $totalpetugas = $kebersihan + $keamanan + $retribusi;
        return view('dashboard.pasar.index',[
            'pasars' => Pasar::latest()->get(),
            'jumlahpasar' => $jumlahpasar,
            'sertifikatada' => $sertifikatada,
            'sertifikattidak' => $sertifikattidak,
            'luas' => $luas,
            'pedagang' => $pedagang,
            'kios_petak' => $kios_petak,
            'los_petak' => $los_petak,
            'lapak_pelataran' => $lapak_pelataran,
            'ruko' => $ruko,
            'baik' => $baik,
            'rusak' => $rusak,
            'terpakai' => $terpakai,
            'kepala_pasar' => $kepala_pasar,
            'kebersihan' => $kebersihan,
            'keamanan' => $keamanan,
            'retribusi' => $retribusi,
            'totalpetugas' => $totalpetugas
        ]);
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
            'nama' => 'required',
            'image' => 'nullable|max:4096', 
            'tahun_pembangunan' => 'required',
            'luas_lahan' => 'required',
            'sertifikat' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'status_pasar' => 'required',
            'pedagang' => 'required',
            'kios_petak' => 'required',
            'los_petak' => 'required',
            'lapak_pelataran' => 'required',
            'ruko' => 'required',
            'baik' => 'required',
            'rusak' => 'required',
            'terpakai' => 'required',
            'kepala_pasar' => 'required',
            'kebersihan' => 'required',
            'keamanan' => 'required',
            'retribusi' => 'required'     
        ]);

        if($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('pasar-image','public');
        }
    
        Pasar::create($validatedData);
        
        $request->session(Alert::success('success', 'Pasar berhasil ditambahkan!'));
        return redirect('/dashboard/pasar');
       
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pasar $pasar)
    {
        
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    $validatedData = $request->validate([
        'nama' => 'required',
        'image' => 'nullable|max:4096', 
        'tahun_pembangunan' => 'required',
        'luas_lahan' => 'required',
        'sertifikat' => 'required',
        'kecamatan' => 'required',
        'kelurahan' => 'required',
        'status_pasar' => 'required',
        'pedagang' => 'required',
        'kios_petak' => 'required',
        'los_petak' => 'required',
        'lapak_pelataran' => 'required',
        'ruko' => 'required',
        'baik' => 'required',
        'rusak' => 'required',
        'terpakai' => 'required',
        'kepala_pasar' => 'required',
        'kebersihan' => 'required',
        'keamanan' => 'required',
        'retribusi' => 'required'     
    ]);

    // Jika ada file gambar baru diupload, update gambar
    if ($request->file('image')) {
        $validatedData['image'] = $request->file('image')->store('pasar-image', 'public');
    }

    // Update data pasar berdasarkan ID
        $pasar = Pasar::findOrFail($id);
        $pasar->update($validatedData);

        $request->session(Alert::success('success', 'Pasar berhasil diupdate!'));
            return redirect('/dashboard/pasar');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {

        $pasar = Pasar::find($id);

        
        $pasar->delete();

        $request->session(Alert::success('success', 'Pasar berhasil dihapus!'));
            return redirect('/dashboard/pasar');
    }

   

    
}

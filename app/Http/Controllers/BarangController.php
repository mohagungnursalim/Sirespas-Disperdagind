<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Komoditas;

use Illuminate\Http\Request;
use Alert;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $barangs = Barang::with('komoditas')->oldest()->paginate(10);
        if (request('search')) {
            $barangs = Barang::with('komoditas')->where('nama', 'like', '%' . request('search') . '%')->oldest()->paginate(10)->WithQueryString();
        } 
        $selectkmd = Komoditas::select('nama','id')->oldest()->get();
        
        
        return view('dashboard.barang.index',compact('barangs','selectkmd'));
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
            'nama' => 'required|string|max:50',
            'komoditas_id' => 'required|exists:komoditas,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
    
        // Memastikan file gambar ada sebelum mencoba menyimpannya
        if($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('barang-image','public');
        }
    
        // Membuat record Barang dengan data yang divalidasi
        Barang::create($validatedData);
        $request->session(Alert::success('success', 'Barang berhasil ditambahkan!'));
        return redirect('/dashboard/barang');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */  
    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);
        $barang->nama = $request->input('nama');

        $validatedData = $request->validate([
            'nama' => 'required|string|max:50',
            'komoditas_id' => 'required|exists:komoditas,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Memperbaiki validasi untuk memungkinkan gambar tidak wajib diubah
        ]);

        // Memastikan file gambar ada sebelum mencoba menyimpannya
        if($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('komoditas-image','public');
        }

            // Mengupdate record Barang dengan data yang divalidasi
            $barang->update($validatedData);

            // Menyimpan pesan sukses ke sesi
            $request->session(Alert::success('success', 'Barang berhasil diupdate!'));
            return redirect('/dashboard/barang');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
       
        $barang = Barang::find($id);

        
        $barang->delete();

        $request->session(Alert::success('success', 'Barang berhasil dihapus!'));
            return redirect('/dashboard/barang');
    }
}

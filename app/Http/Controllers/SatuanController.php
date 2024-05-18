<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Alert;
class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $satuan = Satuan::latest()->paginate(7);

        if (request('search')) {
            $satuan = Satuan::where('nama', 'like', '%' . request('search') . '%')->latest()->paginate(5);
        } 
        
        return view('dashboard.satuan.index',[
            'satuans' => $satuan
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
        $request->validate([
            'nama' => 'required',       
        ]);

        Satuan::create($request->all());
        $request->session(Alert::success('success', 'Satuan berhasil ditambahkan!'));
        return redirect('/dashboard/satuan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Satuan $satuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Satuan $satuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $satuan = Satuan::find($id);
        $satuan->nama = $request->input('nama');

        $request->validate([
            'nama' => 'required',       
        ]);
       
        $satuan->update($request->all());
        

            $request->session(Alert::success('success', 'Satuan berhasil diupdate!'));
            return redirect('/dashboard/satuan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
       
        $satuan = Satuan::find($id);

        
        $satuan->delete();

        $request->session(Alert::success('success', 'Satuan berhasil dihapus!'));
            return redirect('/dashboard/satuan');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Alert;
use Illuminate\Support\Facades\Storage;
class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        return view('dashboard.setting.index',[

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
        // $data = Setting::create($request->all());

        // if ($request->hasFile('logo')) {
        //     $request->file('logo')->move('logoapp', $request->file('logo')->getClientOriginalName());
        //     $data->logo = $request->file('logo')->getClientOriginalName();

        //     $data->save();
        // }

        // $request->session(Alert::success('success', 'Nama aplikasi ditambahkan!'));
        // return redirect('/dashboard/setting-app');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting, $id)
    {
        // nama aplikasi
        $setting = Setting::find($id);
        $setting->nama = $request->input('nama');
        $setting->alamat = $request->input('alamat');
        $setting->email = $request->input('email');
        $setting->telepon = $request->input('telepon');

       

        $setting->update();
        

            $request->session(Alert::success('success', 'Berhasil diupdate!'));
            return redirect('/dashboard/setting-app');

           
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }

    

    public function updatetext(Request $request,$id)
    {

        $setting = Setting::find($id);
        $setting->text = $request->input('text');
       
        $setting->update();
        
        $request->session(Alert::success('success', 'Text berhasil diubah!'));
        return redirect('/dashboard/setting-app');
    }

    public function updatecopyright(Request $request,$id)
    {

        $setting = Setting::find($id);
        $setting->copyright = $request->input('copyright');
       
        $setting->update();
        
        $request->session(Alert::success('success', 'Copyright berhasil diubah!'));
        return redirect('/dashboard/setting-app');
    }
}

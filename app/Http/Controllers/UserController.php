<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pasar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Alert;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $loggedInUser = auth()->user();

        // menampilkan semua user,selain user yang login
        $user = User::where('id', '!=', $loggedInUser->id)->latest()->paginate(10);

        if (request('search')) {
            $user = User::where(function($query) {
                            $query->where('name', 'like', '%' . request('search') . '%')
                                  ->orWhere('email', 'like', '%' . request('search') . '%');
                        })
                        ->where('id', '!=', $loggedInUser->id)
                        ->latest()
                        ->paginate(5);
        }
        

        return view('dashboard.akun.index',[
            'pasars' => Pasar::all(),
            'users' => $user
            
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
            'email' => 'required|email', 
            'name'   => 'required',
            'operator' => 'required',
            'is_admin' => 'required|in:"0","1"'  
        ]);

        
        User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'operator' => $request->input('operator'),
            'is_admin' => $request->input('is_admin'),
            'password' => Hash::make('12345678')
            
        ]);

        $request->session(Alert::success('success', 'Akun baru telah ditambahkan!'));
        return redirect('/dashboard/buat-akun');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id,Request $request)
    {
        $user = User::find($id);

        
        $user->delete();

        $request->session(Alert::success('success', 'Akun berhasil dihapus!'));
            return redirect('/dashboard/buat-akun');
    }
}

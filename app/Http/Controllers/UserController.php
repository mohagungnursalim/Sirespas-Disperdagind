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
    
        // Menampilkan semua pengguna selain pengguna yang sedang login
        $usersQuery = User::where('id', '!=', $loggedInUser->id);
    
        // Jika ada pencarian
        if (request('search')) {
            $search = '%' . request('search') . '%';
            $usersQuery->where(function($query) use ($search) {
                $query->where('name', 'like', $search)
                      ->orWhere('email', 'like', $search);
            });
        }
    
        // Ambil data pengguna dengan relasi pasar, dan batasi 10 hasil per halaman
        $users = $usersQuery->with('pasar')->latest()->paginate(10);
    
        // Ambil daftar pasar
        $pasars = Pasar::select('id','nama')->latest()->get();
    
        return view('dashboard.akun.index', compact('users', 'pasars'));
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
            'pasar_id' => 'required|exists:pasars,id',
            'is_admin' => 'required|in:"0","1"'  
        ]);

        User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'pasar_id' => $request->input('pasar_id'),
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

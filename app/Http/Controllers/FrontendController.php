<?php

namespace App\Http\Controllers;

use App\Models\Komoditas;
use Illuminate\Http\Request;
use App\Models\Pangan;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\Pasar;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cacheKey = 'barangs_index';
        $page = $request->input('page', 1); // Ambil nomor halaman dari query string, defaultnya adalah 1
        $barangs = Cache::remember($cacheKey . '_page_' . $page, 60, function () {
            return Barang::with('pangans')
                ->oldest()
                ->paginate(12);
        });

        return view('index', compact('barangs'));
    }

    public function search(Request $request)
    {
        $query = $request->input('search_query');
        $page = $request->input('page', 1); // Ambil nomor halaman dari query string, defaultnya adalah 1

        if ($query) {
            $cacheKey = 'barangs_search_' . md5($query);
        } else {
            $cacheKey = 'barangs_index';
        }

        $barangs = Cache::remember($cacheKey . '_page_' . $page, 60, function () use ($query) {
            if ($query) {
                return Barang::with('pangans')
                    ->where('nama', 'LIKE', "%$query%")
                    ->oldest()
                    ->paginate(12);
            } else {
                return Barang::with('pangans')
                    ->oldest()
                    ->paginate(12);
            }
        });

        return view('index', compact('barangs'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $komoditas = Komoditas::find($id);

    //     return view('komoditas-show',compact($komoditas));
    // }

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
    public function destroy(string $id)
    {
        //
    }

    // public function allharga()
    // {
    //     $pangans = Pangan::latest()->get();
    //     return response()->json($pangans);
    // }

    public function komoditas()
    {
        // Ambil nomor halaman dari query string, defaultnya adalah 1
        $page = request()->input('page', 1);

        // Mengecek apakah hasil query sudah ada di cache
        $cacheKey = 'komoditas_' . md5(serialize(request()->all())) . '_page_' . $page;
        $komoditas = Cache::remember($cacheKey, 60, function () {
            $selectedPasar = request('filter');
            // Jika filter tidak diberikan, atau jika filter kosong
            if ($selectedPasar) {
                // Ambil data komoditas dengan relasi barangs.pangans dan filter berdasarkan pasar yang ditentukan
                return Komoditas::with(['barangs.pangans' => function ($query) use ($selectedPasar) {
                    $query->where('pasar', $selectedPasar);
                }])->oldest()->paginate(10);
            } else {
                return Komoditas::with(['barangs.pangans' => function ($query) {
                    $query->where('pasar', 'Pasar Inpres Manonda');
                }])->oldest()->paginate(10);
            }
        });

        // Tambahkan method withQueryString()
        $komoditas->withQueryString();

        $pasars = Cache::remember('pasars', 60, function () {
            return Pasar::select('nama')->oldest()->get();
        });

        return view('komoditas', compact('komoditas', 'pasars'));
    }


    


}

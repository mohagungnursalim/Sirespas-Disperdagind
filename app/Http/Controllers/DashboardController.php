<?php

namespace App\Http\Controllers;

use App\Models\Pasar;
use App\Models\Retribusi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        if (Auth::user()->is_admin == true) {
            $totalretribusi = Retribusi::count();
        }else {
            $totalretribusi = Retribusi::where('petugas_penerima',Auth::user()->name)->count();
        }

        $totaluser = User::count();
        $totalpasar = Pasar::count();

        $highestPayments = Retribusi::select('pasar', DB::raw('SUM(jumlah_pembayaran) as max_pembayaran'))
        ->groupBy('pasar')
        ->get();
    
        $chartData = [
            ['Pasar', 'Jumlah Pembayaran']
        ];

        foreach ($highestPayments as $payment) {
            $chartData[] = [$payment->pasar, (float)$payment->max_pembayaran];
        }

        return view('dashboard.dashboard',compact('chartData','totalretribusi','totaluser','totalpasar'));
    }

    
}

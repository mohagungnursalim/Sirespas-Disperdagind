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
        if (Auth::user()->is_admin) {
            $totalretribusi = Retribusi::count();
        } else {
            $totalretribusi = Retribusi::where('user_id', Auth::user()->id)->count();
        }

        $totaluser = User::count();
        $totalpasar = Pasar::count();

        $highestPayments = Retribusi::select('pasar_id', DB::raw('SUM(jumlah_pembayaran) as max_pembayaran'))
            ->groupBy('pasar_id')
            ->with('pasar') // Load pasar terkait
            ->get();

        $chartData = [
            ['Pasar', 'Jumlah Pembayaran']
        ];

        foreach ($highestPayments as $payment) {
            $chartData[] = [$payment->pasar->nama, (float)$payment->max_pembayaran];
        }

        return view('dashboard.dashboard', compact('chartData', 'totalretribusi', 'totaluser', 'totalpasar'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $month_now = date('m');
        $total_penjualan = collect(DB::SELECT("SELECT count(id) AS total from penjualan where month(tanggal)='$month_now'"))->first();
        $total_pembelian = collect(DB::SELECT("SELECT count(id) AS total from pembelian where month(tanggal)='$month_now'"))->first();
        $total_pesanan = collect(DB::SELECT("SELECT count(id) AS total from pesanan where status='0'"))->first();


        $label = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        for($bulan=1;$bulan < 13;$bulan++)
        {
            $chart = collect(DB::SELECT("SELECT count(id) AS total from penjualan where month(tanggal)='$bulan'"))->first();
            
            $jumlah[] = $chart->total;
        }

        return view('admin.dashboard.index', compact('jumlah', 'label', 'total_penjualan', 'total_pesanan', 'total_pembelian', 'total_penjualan'));
    }
}

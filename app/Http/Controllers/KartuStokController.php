<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\KartuStok;
use \App\Barang;

class KartuStokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $from = date('Y-m-d', strtotime($request->get('from')));
            $of = date('Y-m-d', strtotime($request->get('of')));
            $month = date('m');

            $query = DB::table('kartu_stok')
                    ->whereMonth('tanggal', $month);

            if($request->get('from')){
                $query->whereBetween('tanggal', 
                [
                    $from, 
                    $of
                ]);
            }

            $orders = $query->join('barang', 'kartu_stok.barang_id', '=', 'barang.id')
            ->select('kartu_stok.*', 'barang.nama_barang')->get(); 

            return \DataTables::of($orders)
                    ->editColumn('tanggal', function($row){
                        return date('d-m-Y', strtotime($row->tanggal));
                    })
                    ->rawColumns(['tanggal'])
                    ->toJson();
        }  

        return view('admin.kartu_stok.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\KartuStok  $kartuStok
     * @return \Illuminate\Http\Response
     */
    public function show(KartuStok $kartuStok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KartuStok  $kartuStok
     * @return \Illuminate\Http\Response
     */
    public function edit(KartuStok $kartuStok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KartuStok  $kartuStok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KartuStok $kartuStok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KartuStok  $kartuStok
     * @return \Illuminate\Http\Response
     */
    public function destroy(KartuStok $kartuStok)
    {
        //
    }
}

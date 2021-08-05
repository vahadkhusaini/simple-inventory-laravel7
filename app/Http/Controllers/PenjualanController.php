<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Barang;
use \App\Penjualan;
use \App\PenjualanDetail;
use \App\KartuStok;
use Cart;
use Response;
use PDF;

class PenjualanController extends Controller
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

            $pelanggan_id = $request->get('pelanggan_id');

            $query = DB::table('penjualan');

            if(!$request->get('from')){
                $query->whereMonth('tanggal', $month);
            }

            if($request->get('from')){
                $query->whereBetween('tanggal', 
                [
                    $from, 
                    $of
                ]);
            }

            if($request->get('pelanggan_id')){
                $query->where('penjualan.pelanggan_id', '=', $pelanggan_id);
            }

            $orders = $query->join('pelanggan', 'penjualan.pelanggan_id', '=', 'pelanggan.id')
            ->join('penjualan_detail', 'penjualan.id', '=', 'penjualan_detail.penjualan_id')
            ->select('penjualan.*', 'pelanggan.nama_pelanggan', 'penjualan_detail.*',
              DB::raw('SUM( harga_jual * satuan_jual ) as total')) 
            ->groupBy('penjualan_detail.penjualan_id')->get(); 

            return \DataTables::of($orders)
                    ->editColumn('tanggal', function($row){
                        return date('d-m-Y', strtotime($row->tanggal));
                    })
                    ->editColumn('total', function($row){
                        return number_format($row->total);
                    })
                    ->addColumn('action', function($row){

                        $btn = '
                        <button data-id="'.$row->penjualan_id.'" class="print btn btn-primary btn-sm"><i class="nav-icon fas fa-print"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'tanggal','total'])
                    ->toJson();
        }  

        return view('admin.transaksi.penjualan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.transaksi.penjualan.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $penjualan_id = 'TRX'.date('YmdHis');
        $tanggal = date('Y-m-d', strtotime($request->tanggal));
        $userId = auth()->user()->id; 

        DB::beginTransaction();

        try{
            Penjualan::Create([
                'id'  => $penjualan_id,
                'tanggal' => $tanggal,
                'pelanggan_id' => $request->pelanggan_id,
            ]);
    
            $carts = Cart::session($userId)->getContent();
    
            foreach($carts as $cart){
                $barang_id = $cart->associatedModel->id;
                $qty = $cart->quantity;

                $data = [
                    'penjualan_id' => $penjualan_id,
                    'barang_id' => $barang_id,
                    'harga_jual' => $cart->price,
                    'satuan_jual' => $qty,
                ];
                
                PenjualanDetail::insert($data);
                $barang = Barang::find($barang_id);
                $barang->harga_jual = $cart->price;
                $barang->save();
                $barang->decrement('stok', $qty);

                // insert to stok
                KartuStok::insert([
                    'tanggal' => $tanggal,
                    'barang_id' => $barang_id,
                    'masuk' => 0,
                    'keluar' => $qty,
                    'harga' => $cart->price,
                ]);
            }
    
            Cart::session($userId)->clear();

            DB::commit();

            return Response::json('Data Berhasil disimpan');

        }catch (\Exception $e)
        {
            DB::rollback();
            return Response::json(
                'Data Gagal Disimpan'
            , 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPelanggan(Request $request)
    {
        if(!$request->search){
            $data = DB::table('pelanggan')->select("id", "pelanggan_id", "nama_pelanggan")->latest('pelanggan_id')->get();

            return Response::json($data);
        }else{
            $cari = $request->search;
            $data = DB::table('pelanggan')
            ->select("pelanggan_id", "nama_pelanggan")
            ->where('pelanggan_id','LIKE',"%$cari%")
            ->Orwhere('nama_pelanggan','LIKE',"%$cari%")
            ->get();

            return Response::json($data);
            
        }
    }

    public function cetak_laporan_pdf(Request $request)
    {
        $from = date('Y-m-d', strtotime($request->segment(2)));
        $of = date('Y-m-d', strtotime($request->segment(3)));
        $month = date('m');

        $pelanggan_id = $request->segment(4);

        $query = DB::table('penjualan')
                ->whereMonth('tanggal', $month);

        if($from && $of){
            $query->whereBetween('tanggal', 
            [
                $from, 
                $of
            ]);
        }

        if($pelanggan_id != 'null'){
            $query->where('penjualan.pelanggan_id', '=', $pelanggan_id);
        }

        $orders = $query->join('pelanggan', 'penjualan.pelanggan_id', '=', 'pelanggan.id')
        ->join('penjualan_detail', 'penjualan.id', '=', 'penjualan_detail.penjualan_id')
        ->select('penjualan.*', 'pelanggan.nama_pelanggan', 'penjualan_detail.*',
          DB::raw('SUM( harga_jual * satuan_jual ) as total')) 
        ->groupBy('penjualan_detail.penjualan_id')->get(); 

        $pdf = PDF::loadView('admin.transaksi.penjualan.pdf.index', compact('orders', 'from', 'of'))->setPaper('A4', 'potrait');
   
        return $pdf->stream();
    }

    public function cetak_invoice_pdf(Request $request)
    {
        $penjualan_id = $request->segment(2);
        $orders = Penjualan::find($penjualan_id);

        $details = DB::table('penjualan_detail')
                ->where('penjualan_id', '=', $penjualan_id)
                ->join('barang', 'penjualan_detail.barang_id', '=', 'barang.id') 
                ->select('barang.nama_barang', 'penjualan_detail.*')->get();       

        $pdf = PDF::loadView('admin.transaksi.penjualan.pdf.inv', compact('orders', 'details'))->setPaper('A4', 'potrait');
        
        return $pdf->stream();
    }
}

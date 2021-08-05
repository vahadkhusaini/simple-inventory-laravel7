<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Pembelian;
use \App\Pesanan;
use \App\Barang;
use \App\PembelianDetail;
use \App\KartuStok;
use Cart;
use Response;
use PDF;

class PembelianController extends Controller
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

            $supplier_id = $request->get('supplier_id');

            $query = DB::table('pembelian');

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

            if($request->get('supplier_id')){
                $query->where('pembelian.supplier_id', '=', $supplier_id);
            }

            $orders = $query->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')
            ->join('pembelian_detail', 'pembelian.id', '=', 'pembelian_detail.pembelian_id')
            ->select('pembelian.*', 'supplier.nama_supplier', 'pembelian_detail.*',
              DB::raw('SUM( harga_beli * satuan_beli ) as total')) 
            ->groupBy('pembelian_detail.pembelian_id')->get(); 

            return \DataTables::of($orders)
                    ->editColumn('tanggal', function($row){
                        return date('d-m-Y', strtotime($row->tanggal));
                    })
                    ->editColumn('total', function($row){
                        return number_format($row->total);
                    })
                    ->addColumn('action', function($row){

                        $btn = '
                        <button data-id="'.$row->pembelian_id.'" class="print btn btn-primary btn-sm"><i class="nav-icon fas fa-print"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'tanggal','total'])
                    ->toJson();
        }  

        return view('admin.transaksi.pembelian.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.transaksi.pembelian.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pembelian_id = 'PB'.date('YmdHis');
        $tanggal = date('Y-m-d', strtotime($request->tanggal));
        $userId = auth()->user()->id; 

        DB::beginTransaction();

        try{
            // save data purchase to Pembelian Table

            Pembelian::Create([
                'id'  => $pembelian_id,
                'no_nota' => $request->no_nota,
                'tanggal' => $tanggal,
                'supplier_id' => $request->supplier_id,
                'tanggal_jatuh_tempo' => $request->tempo ?? '0000-00-00',
                'jenis_pembayaran' => $request->jenis_pembelian,
                'status' => '0',
            ]);

            //fetch cart session according to user id
    
            $carts = Cart::session($userId)->getContent();
                
            // looping cart for save to pembelian detail table
            foreach($carts as $cart){
                $barang_id = $cart->associatedModel->id;
                $qty = $cart->quantity;

                $data = [
                    'pembelian_id'  => $pembelian_id,
                    'barang_id' => $barang_id,
                    'harga_beli' => $cart->price,
                    'satuan_beli' => $qty,
                ];
                
                // save pembelian detail
                PembelianDetail::insert($data);

                $barang = Barang::find($barang_id);

                // update harga beli
                $barang->harga_beli = $cart->price;
                $barang->save();

                // update stok 
                $barang->increment('stok', $qty);

                // insert to stok
                KartuStok::insert([
                    'tanggal' => $tanggal,
                    'barang_id' => $barang_id,
                    'masuk' => $qty,
                    'keluar' => 0,
                    'harga' => $cart->price,
                ]);
            }
            
            // clear cart session for future cart
            Cart::session($userId)->clear();

            Pesanan::where('id', $request->pesanan_id)
            ->update(['status' => '1']);
            
            DB::commit();

            return Response::json(
                'Data Berhasil disimpan'
            );

        }catch (\Exception $e)
        {
            DB::rollback();
            return Response::json(
                'Data Gagal Disimpan '.$e
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

    public function getSupplier(Request $request)
    {
        if(!$request->search){
            $data = DB::table('supplier')->select("id", "supplier_id", "nama_supplier")->latest('supplier_id')->get();

            return Response::json($data);
        }else{
            $cari = $request->search;
            $data = DB::table('supplier')
            ->select("supplier_id", "nama_supplier")
            ->where('supplier_id','LIKE',"%$cari%")
            ->Orwhere('nama_supplier','LIKE',"%$cari%")
            ->get();

            return Response::json($data);
            
        }
    }

    public function getPemesanan(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('pesanan')
                    ->where('status', '0');

            $orders = $query->join('supplier', 'pesanan.supplier_id', '=', 'supplier.id')
            ->join('pesanan_detail', 'pesanan.id', '=', 'pesanan_detail.pesanan_id')
            ->select('pesanan.*', 'supplier.nama_supplier', 'pesanan_detail.*',
              DB::raw('SUM( harga_beli * satuan_beli ) as total')) 
            ->groupBy('pesanan_detail.pesanan_id')->get(); 

            return \DataTables::of($orders)
                    ->editColumn('tanggal', function($row){
                        return date('d-m-Y', strtotime($row->tanggal));
                    })
                    ->editColumn('total', function($row){
                        return number_format($row->total);
                    })
                    ->addColumn('action', function($row){

                        $btn = '
                        <button data-id="'.$row->pesanan_id.'" class="print btn btn-primary btn-sm"><i class="nav-icon fas fa-print"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'tanggal','total'])
                    ->toJson();
        }  
    }

    public function cetak_laporan_pdf(Request $request)
    {
        $from = date('Y-m-d', strtotime($request->segment(2)));
        $of = date('Y-m-d', strtotime($request->segment(3)));
        $month = date('m');

        $supplier_id = $request->segment(4);

        $query = DB::table('pembelian')
                ->whereMonth('tanggal', $month);

        if($from && $of){
            $query->whereBetween('tanggal', 
            [
                $from, 
                $of
            ]);
        }

        if($supplier_id != 'null'){
            $query->where('pembelian.supplier_id', '=', $supplier_id);
        }

        $orders = $query->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')
        ->join('pembelian_detail', 'pembelian.id', '=', 'pembelian_detail.pembelian_id')
        ->select('pembelian.*', 'supplier.nama_supplier', 'pembelian_detail.*',
          DB::raw('SUM( harga_beli * satuan_beli ) as total')) 
        ->groupBy('pembelian_detail.pembelian_id')->get(); 

        $pdf = PDF::loadView('admin.transaksi.pembelian.pdf.index', compact('orders', 'from', 'of'))->setPaper('A4', 'potrait');
   
        return $pdf->stream();
    }

    public function cetak_invoice_pdf(Request $request)
    {
        $pembelian_id = $request->segment(2);
        $orders = Pembelian::find($pembelian_id);

        $details = DB::table('pembelian_detail')
                ->where('pembelian_id', '=', $pembelian_id)
                ->join('barang', 'pembelian_detail.barang_id', '=', 'barang.id') 
                ->select('barang.nama_barang', 'pembelian_detail.*')->get();       

        $pdf = PDF::loadView('admin.transaksi.pembelian.pdf.inv', compact('orders', 'details'))->setPaper('A4', 'potrait');
   
        return $pdf->stream();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use \App\Pesanan;
use \App\Barang;
use \App\PesananDetail;
use Cart;
use Response;
use PDF;

class PesananController extends Controller
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

            $query = DB::table('pesanan')
                    ->whereMonth('tanggal', $month);

            if($request->get('from')){
                $query->whereBetween('tanggal', 
                [
                    $from, 
                    $of
                ]);
            }

            if($request->get('supplier_id')){
                $query->where('pesanan.supplier_id', '=', $supplier_id);
            }

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

        return view('admin.transaksi.pesanan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.transaksi.pesanan.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pesanan_id = auto_id_trx('pesanan','id','PO');
        $tanggal = date('Y-m-d', strtotime($request->tanggal));
        $userId = auth()->user()->id; 

        DB::beginTransaction();

        try{
            Pesanan::Create([
                'id'  => $pesanan_id,
                'tanggal' => $tanggal,
                'supplier_id' => $request->supplier_id,
                'status' => '0',
            ]);

            $carts = Cart::session($userId)->getContent();

            foreach($carts as $cart){
                $data = [
                    'pesanan_id'  => $pesanan_id,
                    'barang_id' => $cart->associatedModel->id,
                    'harga_beli' => $cart->price,
                    'satuan_beli' => $cart->quantity,
                ];
                
                PesananDetail::insert($data);
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

    public function getOrdersById(Request $request)
    {
        $header = Pesanan::find($request->id);
        $details = PesananDetail::where('pesanan_id', $request->id)->get();
        $user = auth()->user()->id;

        Cart::session($user)->clear();
        
        foreach($details as $detail){
            $id = Str::random(12);
            $barang = Barang::where('id', $detail->barang_id)->first();

            Cart::session($user)->add(
                [
                    'id' => $id,
                    'name' => $barang->nama_barang,
                    'price' => $detail->harga_beli,
                    'quantity' => $detail->satuan_beli,
                    'associatedModel' => $barang
                ]
            );
        }

        $data = [
            'cart' => Cart::getContent(),
            'header' => $header,
            'supplier' => $header->supplier
        ]; 

        return Response::json($data);
    }

    public function cetak_laporan_pdf(Request $request)
    {
        $from = date('Y-m-d', strtotime($request->segment(2)));
        $of = date('Y-m-d', strtotime($request->segment(3)));
        $month = date('m');

        $supplier_id = $request->segment(4);

        $query = DB::table('pesanan')
                ->whereMonth('tanggal', $month);

        if($from && $of){
            $query->whereBetween('tanggal', 
            [
                $from, 
                $of
            ]);
        }

        if($supplier_id != 'null'){
            $query->where('pesanan.supplier_id', '=', $supplier_id);
        }

        $orders = $query->join('supplier', 'pesanan.supplier_id', '=', 'supplier.id')
        ->join('pesanan_detail', 'pesanan.id', '=', 'pesanan_detail.pesanan_id')
        ->select('pesanan.*', 'supplier.nama_supplier', 'pesanan_detail.*',
          DB::raw('SUM( harga_beli * satuan_beli ) as total')) 
        ->groupBy('pesanan_detail.pesanan_id')->get(); 

        $pdf = PDF::loadView('admin.transaksi.pesanan.pdf.index', compact('orders', 'from', 'of'))->setPaper('A4', 'potrait');
   
        return $pdf->stream();
    }

    public function cetak_invoice_pdf(Request $request)
    {
        $pesanan_id = $request->segment(2);
        $orders = Pesanan::find($pesanan_id);

        $details = DB::table('pesanan_detail')
                ->where('pesanan_id', '=', $pesanan_id)
                ->join('barang', 'pesanan_detail.barang_id', '=', 'barang.id') 
                ->select('barang.nama_barang', 'pesanan_detail.*')->get();       

        $pdf = PDF::loadView('admin.transaksi.pesanan.pdf.inv', compact('orders', 'details'))->setPaper('A4', 'potrait');
   
        return $pdf->stream();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use\App\Pesanan;
use\App\PesananDetail;
use Cart;
use Response;

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

            $orders = DB::table('pesanan')
            ->join('supplier', 'pesanan.supplier_id', '=', 'supplier.id')
            ->join('pesanan_detail', 'pesanan.id', '=', 'pesanan_detail.pesanan_id')
            ->select('pesanan.*', 'supplier.nama_supplier', 'pesanan_detail.*',
              DB::raw('SUM(harga_beli * satuan_beli) as total')) 
            ->groupBy('pesanan_detail.pesanan_id')
            ->get(); 

            return \DataTables::of($orders)
                    ->editColumn('tanggal', function($row){
                        return date("d-m-Y", strtotime($row->tanggal));
                    })
                    ->editColumn('total', function($row){
                        return number_format($row->total);
                    })
                    ->addColumn('action', function($row){

                        $btn = '
                        <a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a> 
                        <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';

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


        $output = [
            'message' => 'Data Berhasil disimpan'
        ];

        return Response::json($output);
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
}

<?php

namespace App\Http\Controllers;

use\App\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Response;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $barang = Barang::select('barang.*')->latest('barang_id');
            return \DataTables::eloquent($barang)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '
                        <a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a> 
                        <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->toJson();
        }

        return view('admin.barang.index');
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
        $barang_id = auto_id('barang','barang_id','BRG');
            Barang::updateOrCreate(
                ['id' => $request->id],
                ['barang_id' => $request->barang_id ?? $barang_id,
                'barcode' => $request->barcode,
                'nama_barang' => $request->nama_barang,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'supplier_id' => $request->supplier_id
                ]
            );

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
        $barang = Barang::find($id);

        $data = [
            'barang' => $barang,
            'supplier' => $barang->supplier
        ];

        return Response::json($data);
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
        Barang::find($id)->delete();

        $output = [
            'message' => 'Data Barang Berhasil dihapus'
        ];

        return Response::json($output);
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

    public function getBarang(Request $request)
    {
        if(!$request->search){
            $data = DB::table('barang')->select("id", "barang_id", "nama_barang")->latest('barang_id')->get();

            return Response::json($data);
        }else{
            $cari = $request->search;
            $data = DB::table('barang')
            ->select("barang_id", "nama_barang")
            ->where('barang_id','LIKE',"%$cari%")
            ->Orwhere('nama_barang','LIKE',"%$cari%")
            ->get();

            return Response::json($data);
            
        }
    }

    public function getBarangById(Request $request)
    {
        $data = Barang::where('barang_id', $request->id)->first();

        return Response::json($data);
    }
}

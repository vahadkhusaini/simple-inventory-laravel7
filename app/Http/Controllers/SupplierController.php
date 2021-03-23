<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Response;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $supplier = Supplier::select('supplier.*')->latest('supplier_id');
            return \DataTables::eloquent($supplier)
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

        return view('admin.supplier.index');
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
        $supplier_id = auto_id('supplier','supplier_id','SP');
            Supplier::updateOrCreate(
                ['id' => $request->input('id')],
                ['supplier_id' => $request->supplier_id ?? $supplier_id,
                'nama_supplier' => $request->nama_supplier,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat]
            );

        $output = [
            'message' => 'Data Berhasil disimpan'
        ];
        return Response::json($output);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Supplier::find($id);

        return Response::json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Supplier::find($id)->delete();

        $output = [
            'message' => 'Data Supplier Berhasil dihapus'
        ];

        return Response::json($output);
    }
}

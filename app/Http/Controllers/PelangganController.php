<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Pelanggan;
Use Response;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pelanggan = Pelanggan::select('pelanggan.*')->latest('pelanggan_id');
            return \DataTables::eloquent($pelanggan)
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
        
        return view('admin.pelanggan.index');
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
        $pelanggan_id = auto_id('pelanggan','pelanggan_id','PL');
            Pelanggan::updateOrCreate(
                ['id' => $request->id],
                ['pelanggan_id' => $request->pelanggan_id ?? $pelanggan_id,
                'nama_pelanggan' => $request->nama_pelanggan,
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
        $data = Pelanggan::find($id);

        return Response::json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pelanggan::find($id)->delete();

        $output = [
            'message' => 'Data Pelanggan Berhasil dihapus'
        ];
        return Response::json($output);
    }
}

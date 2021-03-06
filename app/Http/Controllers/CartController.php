<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \App\Barang;
use Response;
use Cart;

class CartController extends Controller
{
    public function getData()
    {
        $data = Cart::getContent();

        return Response::json($data);
    }

    public function add(Request $request)
    {
        $barang = Barang::where('barang_id', $request->id)->first();

        if($request->trans == 'penjualan'){
            if($request->qty > $barang->stok)
            {
                return Response::json(
                    'Stok tidak mencukupi'
                , 404);
            }

            if($request->harga < $barang->harga_beli)
            {
                return Response::json(
                    'Harga jual kurang dari harga beli !'
                , 404);
            }

            return $this->store($request, $barang);

        }

        return $this->store($request, $barang);

    }


    public function store($request, $barang){

        $id = Str::random(12);
        $user = auth()->user()->id;

        Cart::session($user);
        
        Cart::session($user)->add(
            [
                'id' => $id,
                'name' => $barang->nama_barang,
                'price' => $request->harga,
                'quantity' => $request->qty,
                'associatedModel' => $barang
            ]
        );

        return $this->getData();
    }

    public function update(Request $request, $id)
    {
        Cart::session($user)->update($id,[
            'quantity' => $request->qty
        ]);
        
        return $this->getData();
    }

    public function remove(Request $request)
    {
        $user = auth()->user()->id;
        Cart::session($user)->remove($request->id);

        return $this->getData();
    }

    public function getOrder()
    {
        
    }
}

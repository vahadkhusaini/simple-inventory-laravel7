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
}

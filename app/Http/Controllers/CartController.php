<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function add(Request $request )
    {
        $id = Str::random(12);
        $user = auth()->user()->id;

        Cart::session($user)->add(
            [
                'id' => $id,
                'name' => '',
                'price' => '',
                'quantity' => '',
                'barcode' => ''
            ]
        );
    }
}

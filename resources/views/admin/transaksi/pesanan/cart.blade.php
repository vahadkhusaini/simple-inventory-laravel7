@foreach ($data as $items)
        <tr>
            <td>'.{{$loop->iteration}}.'</td>
            <td>'.{{$items->associatedModel->barcode}}.'</td>
            <td>'.{{$items->name}}.'</td>
            <td>'.{{$items->qty}}.'</td>   
            <td>'.{{number_format($items->price)}}.'</td> 
            <td>'.{{number_format($items->getPriceSum())}}.'</td>
            <td>
                <input type="button" class="update-cart btn btn-info btn-xs" value="Update">
                <input type="button" id="'.$items->id.'" class="delete-cart btn btn-danger btn-xs" value="Hapus">
            </td>
        </tr>
@endforeach

    <tr>
        <th colspan="5">Total</th>
        <th colspan="4">'.'Rp '.{{number_format(\Cart::getSubTotal())}}.'</th>
    </tr>
    <tr>
        <th colspan="7"><input type="button" class="destroy-cart btn btn-danger btn-xs" value="Kosongkan data barang"></th>
    </tr>
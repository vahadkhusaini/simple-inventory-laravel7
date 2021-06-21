<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Aloha!</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-medium;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-medium;
    }
    .gray {
        background-color: lightgray
    }
</style>

</head>
<body>

  <table width="100%">
    <tr>
        <td align="left">
            <h3>PURCHASING</h3>
              
            {{ $orders->supplier->nama_supplier }}
            <br>
            Alamat : {{ $orders->supplier->alamat }}
            <br>
            Phone : {{ $orders->supplier->telepon }}
           
        </td>
    </tr>

  </table>

  <br/>

  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th>#</th>
        <th>Item</th>
        <th>Quantity</th>
        <th>Unit Price (Rp)</th>
        <th>Sub Total (Rp)</th>
      </tr>
    </thead>
    <tbody>
      @php
        $total = 0;
      @endphp
      
      @foreach ($details as $detail)
      @php
        $subtotal = $detail->satuan_beli*$detail->harga_beli;
        $total += $subtotal;
      @endphp
      <tr>
        <th scope="row">{{ $loop->iteration }}</th>
        <td>{{ $detail->nama_barang }}</td>
        <td align="right">{{ $detail->satuan_beli }}</td>
        <td align="right">{{ number_format($detail->harga_beli) }}</td>
        <td align="right">{{ number_format($subtotal) }}</td>
      </tr>
      @endforeach

    </tbody>

    <tfoot>
        <tr>
            <td colspan="3"></td>
            <td align="right">Total (Rp)</td>
            <td align="right" class="gray">{{ number_format($total) }}</td>
        </tr>
    </tfoot>
  </table>

</body>
</html>
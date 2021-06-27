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
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
</style>

</head>
<body>

  <table width="100%">
    <tr>
        <td align="center">
            <h1>Laporan Pembelian</h1>
            <h3>Periode {{ date('d-m-Y',  strtotime($from)) }} s/d {{ date('d-m-Y',  strtotime($of)) }}</h3>
        </td>
    </tr>
  </table>

  <br/>

  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th width="10%">#</th>
        <th width="20%">Tanggal</th>
        <th>Nama Supplier</th>
        <th>Total (Rupiah)</th>
      </tr>
    </thead>
    <tbody>
    
      @foreach ($orders as $item)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td> {{ date('d-m-Y',  strtotime($item->tanggal)) }}</td>
            <td> {{ $item->nama_supplier }}</td>
            <td align="right">{{ number_format($item->total) }}</td>
          </tr>
      @endforeach
    </tbody>
  </table>

</body>
</html>
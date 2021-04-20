@extends('admin.main')
@section('Pesanan', 'active')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Pesanan</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <a href="/pesanan/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah</a>
                </div>
                <div class="card-body table-responsive">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>ID ORDER</th>
                                <th>Nama Supplier</th>
                                <th>Total (Rupiah)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </section>
</div>

@endsection

@push('child-js')
<script>
    var table;

$(function () {

    table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('pesanan.index') }}",
        columns: [
            {data: 'tanggal', name: 'tanggal'},
            {data: 'pesanan_id', name: 'pesanan_id'},
            {data: 'nama_supplier', name: 'nama_supplier'},
            {data: 'total', name: 'total'},
            {data: 'action', name: 'action'},
        ]
    });
});
</script>
@endpush
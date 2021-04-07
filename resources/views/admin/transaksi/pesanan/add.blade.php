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
                    <h1>Pemesanan</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Basic Card Example -->
            <div class="card card=default">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Form Pemesanan</h6>
                </div>
                <div class="card-body">
                    <form action="javascript:void(0)"
                        id="tambah-pemesanan"
                        method="post">
                        <div class="modal-body">
                            <div class="row pr-4">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="inputPassword"
                                            class="col-md-5 col-form-label">Tanggal
                                            Pemesanan</label>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text"
                                                    id="basicDate"
                                                    name="tanggal"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pl-5">
                                    <div class="form-group row">
                                        <label for="inputPassword"
                                            class="col-md-4 col-form-label">Supplier</label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <select class="form-control"
                                                    id="supplier"
                                                    name="supplier_id">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Form Element sizes -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Daftar Barang</h3>
                            </div>
                            <div class="card-body">
                                <div class="row pr-4">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword"
                                                class="col-md-5 col-form-label">
                                                Barang
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control"
                                                        name="barang"
                                                        readonly
                                                        placeholder="Barang">
                                                    <div class="input-group-append">
                                                        <button id="pilih-barang"
                                                            class="btn btn-outline-success"
                                                            type="button">Pilih</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pl-5">
                                        <div class="form-group row">
                                            <label for="inputPassword"
                                                class="col-md-5 col-form-label">
                                                Qty
                                            </label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="number"
                                                        name="jumlah"
                                                        id="jumlah"
                                                        class="form-control">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"
                                                            id="basic-addon1">PCS</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword"
                                                class="col-md-5 col-form-label">
                                                Harga
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"
                                                            id="basic-addon1">Rp.</span>
                                                    </div>
                                                    <input type="number"
                                                        id="harga_barang"
                                                        name="harga_barang"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pl-5">
                                        <div class="form-group row">
                                            <label for="inputPassword"
                                                class="col-md-5 col-form-label">
                                                Total
                                            </label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"
                                                            id="basic-addon1">Rp.</span>
                                                    </div>
                                                    <input type="number"
                                                        name="total"
                                                        id="total"
                                                        readonly
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Row -->
                                <div class="row">
                                    <div class="col-md-6 pl-4">
                                        <div class="form-group row pt-3">
                                            <input type="button"
                                                id="add_to_cart_order"
                                                class="btn btn-success mr-2"
                                                value="TAMBAH">
                                            <button class="btn btn-warning">RESET</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                        <tr class="info">
                                                            <th>No</th>
                                                            <th>Barcode</th>
                                                            <th>Nama Barang</th>
                                                            <th>Qty</th>
                                                            <th>Satuan</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="show_data_pemesanan">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="modal-footer">
                            <button class="btn btn-primary"
                                type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</div>

<div class="modal fade bd-example-modal-lg"
    id="modal-barang">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Daftar Barang</h4>
                <button type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered"
                        id="barang"
                        width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barcode</th>
                                <th>Nama Barang </th>
                                <th>Harga Barang</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

@push('child-js')
<script>
    let _token = $('meta[name="csrf-token"]').attr('content');

    $('#supplier').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Supplier',
        ajax: {
            url: "/barang/getSupplier",
            type: "POST",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    _token: _token,
                    search: params.term // search term
                };

            },
            processResults: function (data) {
                console.log("OK");
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama_supplier,
                            id: item.id
                        }
                    })
                };

            },

            cache: true
        },

    });

    $('#pilih-barang').on('click', function(){
        const url = $(this).data('url');
        $('#modal-barang').modal('show');

        var table = $('#barang').DataTable({
                processing: true,
                serverSide: true,
                bDestroy: true,
                ajax: "{{ route('barang.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: 'barcode', name: 'barcode'},
                    {data: 'nama_barang', name: 'nama_barang'},
                    {data: 'harga_beli', name: 'harga_beli'},
                ]
            });
    })

    // $('#barang').select2({
    //     theme: 'bootstrap4',
    //     placeholder: 'Pilih Barang',
    //     ajax: {
    //         url: "/barang/getBarang",
    //         type: "POST",
    //         dataType: 'json',
    //         delay: 250,
    //         data: function (params) {
    //             return {
    //                 _token: _token,
    //                 search: params.term // search term
    //             };

    //         },
    //         processResults: function (data) {

    //             return {
    //                 results: $.map(data, function (item) {
    //                     return {
    //                         text: item.nama_barang,
    //                         id: item.id
    //                     }
    //                 })
    //             };

    //         },

    //         cache: true
    //     },

    // });

</script>
@endpush

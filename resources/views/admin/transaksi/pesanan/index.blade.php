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
                    <a href="/pesanan/create"
                        class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah</a>
                </div>
                <div class="col-md-12 pt-3">
                    <div class="row">
                        <!-- Date range -->
                        <div class="col-md-3 pr-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text"
                                        class="form-control float-right"
                                        id="periode">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="table"
                        class="table table-bordered table-striped">
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

@push('child-css')
<link rel="stylesheet"
    href="{{ asset('admin/plugins/daterangepicker/daterangepicker.css') }}">
@endpush

@push('child-js')
<script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
     $(document).ready(function() {

    var table;
    table_pesanan();
    let startDate = moment().startOf('month')
    let endDate = moment().endOf('month')

    $(function() {
        $('#periode').daterangepicker({
                startDate: startDate,
                endDate: endDate,
                cancelClass: "btn-danger",
                opens: 'right',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                },
                locale: {
                    format: 'DD/MM/YYYY'
                }
            },
            function(start, end, label) {
                    startDate = start.format('YYYY-MM-DD');
                    endDate = end.format('YYYY-MM-DD');

                    table_pesanan(startDate, endDate);
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
    });

    $('#submit-periode').on('click', function(){
        console.log(startDate, endDate);
        table_pesanan(startDate, endDate);
    })

    function table_pesanan(startDate, endDate){
        console.log(startDate);

        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            bDestroy: true,
            ajax: {
                url: "{{ route('pesanan.index') }}",
                type: "GET",
                data: {
                    from: startDate,
                    of: endDate
                },
            },
            columns: [{
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'pesanan_id',
                    name: 'pesanan_id'
                },
                {
                    data: 'nama_supplier',
                    name: 'nama_supplier'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });
    };
});
</script>
@endpush
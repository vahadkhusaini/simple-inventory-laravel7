@extends('admin.main')
@section('Transaksi', 'menu-open')
@section('Penjualan', 'active')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Penjualan</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <a href="/penjualan/create"
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
                        <div class="col-md-3">
                            <select class="form-control"
                                id="pelanggan"
                                name="pelanggan_id">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button id="filter" class="btn btn-primary"><i class="nav-icon fas fa-filter"></i> Filter</button>
                            <button id="reset" class="btn btn-danger"><i class="nav-icon fas fa-redo"></i></button>
                            <button id="print" class="btn btn-info"><i class="nav-icon fas fa-print"></i></button>
                                
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
                                <th>Nama Pelanggan</th>
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
<link rel="stylesheet" href="{{ asset('admin/plugins/daterangepicker/daterangepicker.css') }}">
@endpush

@push('child-js')
<script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
    $(document).ready(function () {
        let _token = $('meta[name="csrf-token"]').attr('content');

        var table;
        table_penjualan();
        var startDate;
        var endDate;

        $(function () {
            $('#periode').daterangepicker({
                    cancelClass: "btn-danger",
                    opens: 'right',
                    ranges: {
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                    },
                    locale: {
                        format: 'DD/MM/YYYY',
                        applyLabel: 'Filter'
                    }
                },
                function (start, end, label) {
                    startDate = start.format('YYYY-MM-DD');
                    endDate = end.format('YYYY-MM-DD');

                    table_penjualan(startDate, endDate);
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') +
                        ' to ' + end.format('YYYY-MM-DD'));
                });
        });

        $('#filter').on('click', function () {
            
            const pelanggan_id = $('#pelanggan').val();
            const periode = $('#periode').val();

            console.log(startDate);

            if(startDate == undefined){
                Swal.fire({
                    position: 'center',
                    type: 'error',
                    title: 'Pilih Tanggal',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
            else if(pelanggan_id == undefined){
                Swal.fire({
                    position: 'center',
                    type: 'error',
                    title: 'Pilih Pelanggan',
                    showConfirmButton: false,
                    timer: 1500
                })
            }else{
                table_penjualan(startDate, endDate, pelanggan_id);
            }
        })

        $('#reset').on('click', function () {

            var data = {
                id: 0,
                text: "Pilih Pelanggan"
            }

            var newOption = new Option(false, false);
            $('#pelanggan').append(newOption).trigger('change');

            table_penjualan();
        })

        $('#print').on('click', function () {
            const pelanggan_id = $('#pelanggan').val();
            const periode = $('#periode').val();

            console.log(startDate);

            if(startDate == undefined){
                Swal.fire({
                    position: 'center',
                    type: 'error',
                    title: 'Pilih Tanggal',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
            else if(pelanggan_id == undefined){
                Swal.fire({
                    position: 'center',
                    type: 'error',
                    title: 'Pilih Pelanggan',
                    showConfirmButton: false,
                    timer: 1500
                })
            }else{
            Swal.fire({
                    title: 'Cetak Laporan Penjualan?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Cetak',
                    preConfirm: (yes) => {
                            window.location = "/cetak_pdf/"+startDate+"/"+endDate+"/"+pelanggan_id;
                            target = "_blank";
                        },
                    })
            }
        })

        $('#table').on('click', '.print',function (){
            const id = $(this).data('id');

            Swal.fire({
                    title: 'Cetak Penjualan?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Cetak',
                    preConfirm: (yes) => {
                            window.location = "/cetak_penjualan_pdf/"+id;
                            target = "_blank";
                        },
                    })
            
        })

        $('#pelanggan').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Pelanggan',
            ajax: {
                url: "/penjualan/getPelanggan",
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
                                id: item.id,
                                text: item.nama_pelanggan
                            }
                        })
                    };

                },

                cache: true
            },
        });

        function table_penjualan(startDate, endDate, pelanggan_id) {
            console.log(startDate);

            table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                bDestroy: true,
                ajax: {
                    url: "{{ route('penjualan.index') }}",
                    type: "GET",
                    data: {
                        from: startDate,
                        of: endDate,
                        pelanggan_id: pelanggan_id
                    },
                },
                columns: [{
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'penjualan_id',
                        name: 'penjualan_id'
                    },
                    {
                        data: 'nama_pelanggan',
                        name: 'nama_pelanggan'
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
@extends('admin.main')
@section('Pembelian', 'active')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pembelian</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary">Form Pembelian</h6>
                </div>
                <div class="card-body">
                    <form action="javascript:void(0)"
                        id="form-pembelian"
                        method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 pr-5">
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-md-5 col-form-label">No
                                            Pemesanan</label>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" required readonly id="no_pemesanan" class="form-control"
                                                    name="pesanan_id" placeholder="Pemesanan">
                                                <div class="input-group-append">
                                                    <button id="pilih-pesanan"
                                                        class="btn btn-outline-primary"
                                                        type="button">Pilih</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-md-5 col-form-label">No
                                            Nota</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="no_nota">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword"
                                            class="col-md-5 col-form-label">Supplier</label>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <select class="form-control"
                                                    id="supplier"
                                                    name="supplier_id">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword"
                                            class="col-md-5 col-form-label">Tanggal
                                            Pembelian</label>
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
                                    <fieldset>
                                        <legend>Metode pembayaran</legend>
                                    
                                        <div class="col-md-5 pt-2">
                                            <div class="input-group">
                                                <div class="form-check form-check-inline pr-3">
                                                    <input class="form-check-input" type="radio"
                                                        name="jenis_pembelian" id="tunai" value="T">
                                                    <label class="form-check-label" for="tunai">
                                                        Tunai
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="jenis_pembelian" id="kredit" value="K">
                                                    <label class="form-check-label" for="kredit">
                                                        Kredit
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                      </fieldset>
                                    <fieldset>
                                        <legend class="pt-4">Tempo</legend>
                                    
                                        <div class="col-md-8 pt-2">
                                            <div class="input-group">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                </span>
                                                            </div>
                                                            <input type="text"
                                                                class="form-control float-right"
                                                                id="tempo" name="tempo">
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                    <!-- /.form group -->
                                            </div>
                                        </div>
                                      </fieldset>
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
                                                <input type="hidden" name="id">
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control"
                                                        name="nama_barang"
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
                                                id="add-to-cart"
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
                                                <table id="cart-table" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Barcode</th>
                                                            <th>Nama Barang</th>
                                                            <th>Qty</th>
                                                            <th>Harga</th>
                                                            <th>Subtotal</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="cart-item">
                                                       
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
                                <th>Kode Barang</th>
                                <th>Barcode</th>
                                <th>Nama Barang </th>
                                <th>Sub Total</th>
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

<div class="modal fade bd-example-modal-lg"
    id="modal-pesanan">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Daftar Pemesanan</h4>
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
                        id="pesanan"
                        width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>ID ORDER</th>
                                <th>Nama Supplier</th>
                                <th>Total (Rupiah)</th>
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

@push('child-css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/flatpickr/package/dist/themes/airbnb.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/daterangepicker/daterangepicker.css') }}">
@endpush

@push('child-js')
<script src="{{ asset('admin/plugins/flatpickr/package/dist/flatpickr.js') }}"></script>
<script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
    $(document).ready(function() {

    let _token = $('meta[name="csrf-token"]').attr('content');

    // Form Header
			
    $("input[name='tanggal']").flatpickr({
          altInput: true,
          altFormat: "d/m/Y",
          dateFormat: "Y/m/d",
          defaultDate: "today"
    });

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
    
    function tempo(boolean){
        $("input[name='tempo']").flatpickr({
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y/m/d",
            defaultDate: "today",
            disable: [
                function(date){
                    return boolean;
                }
            ]
        });
    }

    tempo(true);

    $("input[type='radio']").click(function(){
            var radioValue = $("input[name='jenis_pembelian']:checked").val();
            if(radioValue === 'K'){
                tempo(false);
            }else{
                tempo(true);
            }
    });

    // End Form Header

    // Start Form Detail

    $('#pilih-barang').on('click', function(){
        const url = $(this).data('url');
        $('#modal-barang').modal('show');

        var table = $('#barang').DataTable({
                processing: true,
                serverSide: true,
                bDestroy: true,
                createdRow: function( row, data, dataIndex ) {
					 $( row )
					 .addClass('barang')
					 .attr('data-id', data.barang_id)
				},
                ajax: "{{ route('barang.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: 'barang_id', name: 'barang_id'},
                    {data: 'barcode', name: 'barcode'},
                    {data: 'nama_barang', name: 'nama_barang'},
                    {data: 'harga_beli', name: 'harga_beli'},
                ]
            });
    })

    $('#pilih-pesanan').on('click', function(){
        const url = $(this).data('url');
        $('#modal-pesanan').modal('show');

        var table = $('#pesanan').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                bDestroy: true,
                createdRow: function( row, data, dataIndex ) {
					 $( row )
					 .addClass('pesanan')
					 .attr('data-id', data.pesanan_id)
				},
                ajax: "{{ route('pesanan.index') }}",
                columns: [
                    {
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
                ]
            });
    })

    function cart_table(data)
    {
        let no = 1;
        let total = 0;
        let total_item = 0;
        let html = "";
        $.each(data, function (index, item) {
            console.log(item);
            let subtotal = item.price * item.quantity;
            total += subtotal;
            total_item += Number(item.quantity);

            html += `<tr>
                                    <td>${no++}</td>
                                    <td>${item.associatedModel.barcode}</td>
                                    <td>${item.name}</td>
                                    <td>${item.quantity}</td>
                                    <td>${item.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')}</td>
                                    <td>${subtotal.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')}</td>
                                    <td>
                                    <a href="javascript:void(null)" data-rowid="${item.id}"
                                        class="remove-cart btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i>
                                    </td>
                                </tr>`;

            console.log(html);
        });

        html += `<tr>
                                <th colspan="3"><center><strong>Total</strong></center></th>
                                <th colspan="2"><strong>${total_item}</strong></th>
                                <th colspan="2"><strong>${total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')}</strong></th>
                            </tr>`;

        $('#cart-item').html(html);
    }

    $('#add-to-cart').on('click', function(){
        const id = $("input[name='id']").val();
        const qty = $("input[name='jumlah']").val();
        const harga = $("input[name='harga_barang']").val();
        
        $.ajax({
                type: 'POST',
                url: "{{ route('cart.add') }}",
                data: {
                    _token: _token,
                    id: id,
                    qty: qty,
                    harga: harga
                },
                dataType: 'json',
                success: function (data) {
                    cart_table(data);
                   
                    $("input[name='id']").val("");
                    $("input[name='nama_barang']").val("");
                    $("input[name='jumlah']").val(null);
                    $("input[name='harga_barang']").val(null);
                    $("input[name='total']").val(null);
                   
                }
    	    });
    })

    function get_total() {
        const total = $("input[name='jumlah']").val() * $("input[name='harga_barang']").val();
        $('#total').val(total);
    }

    $("input[name='jumlah']").on('keyup', function () {
        get_total();
    });

    $("input[name='harga_barang']").on('keyup', function () {
        get_total();
    });

    $('#cart-table').on('click', '.remove-cart',function (){
        const id = $(this).data('rowid');
        console.log(id);
        
        $.ajax({
                type: 'POST',
                url: "{{ route('cart.remove') }}",
                data: {
                    _token: _token,
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                   cart_table(data);
                }
    	    });
    })

    $('#barang').on('click', '.barang',function (){
                const id =  $(this).attr('data-id');
                $("input[name='jumlah']").focus();

                $.ajax({
                    type: 'POST',
                    url: '/barang/getBarangById',
                    data: {
                        _token: _token,
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data.length);
                        $("input[name='id']").val(data.barang_id);
                        $("input[name='nama_barang']").val(data.nama_barang);
                        $("input[name='harga_barang']").val(data.harga_beli);

                        $('#modal-barang').modal('hide');
                    }
    	        });
                            
              });

        $('#pesanan').on('click', '.pesanan',function (){
                const id =  $(this).attr('data-id');
                console.log(id);

                $.ajax({
                    type: 'POST',
                    url: '/pesanan/getById',
                    data: {
                        _token: _token,
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        cart_table(data.cart);
                        $("input[name='pesanan_id']").val(data.header.id);

                        var data = {
                            id: data.supplier.id,
                            text: data.supplier.nama_supplier
                        };

                        var newOption = new Option(data.text, data.id, true, true);
                        $('#supplier').append(newOption).trigger('change');

                        $('#modal-pesanan').modal('hide');
                    }
    	        });
                            
        });
});

// End Form Detail

// Start Save Ajax

        $('#form-pembelian').validate({
                rules: {
                    supplier_id: {
                        required: true
                    },
                    no_nota: {
                        required: true
                    },
                    no_pemesanan: {
                        required: true
                    },
                    jenis_pembelian: {
                        required: true
                    },
                },
                messages: {
                    supplier_id: {
                        required: "Wajid di isi"
                    },
                    no_nota: {
                        required: "Wajid di isi"
                    },
                    no_pemesanan: {
                        required: "Wajid di isi"
                    },
                    jenis_pembelian: {
                        required: "Wajid di isi"
                    },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.col-md-8').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function (form) {
                    Swal.fire({
                    title: 'Simpan transaksi pembelian?',
                    text: "Pastikan semua data benar!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Simpan',
                    preConfirm: (yes) => {
                            // Start of AJAX
                            $.ajax({
                                type: 'POST',
                                url: '/pembelian',
                                data: $('#form-pembelian').serialize(),
                                dataType: 'json',
                                success: function (output) {
                                    Swal.fire({
                                        position: 'top',
                                        type: 'success',
                                        title: output.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    window.setTimeout(function () {
                                        location.reload();
                                    }, 1070);
                                }
                            });
                            // End of AJAX
                        },
                    })
                }
                // End of submitHandler
            })

        // End Save Ajax
</script>
@endpush

@extends('admin.main')
@section('Barang', 'active')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Barang</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <a href="javascript:void(0)" data-url="/barang" id="tambah" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah</a>
                </div>
                <div class="card-body table-responsive">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
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

<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Barang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="form-barang" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Barcode</label>
                            <div class="col-sm-8">
                                <input type="hidden" name="id" readonly class="form-control">
                                <input type="hidden" name="barang_id" readonly class="form-control">
                                <input type="text" name="barcode" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Nama Barang</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama_barang" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Harga</label>
                            <div class="col-sm-4">
                                <input type="number" placeholder="Harga Beli" class="form-control" name="harga_beli">
                            </div>
                            <div class="col-sm-4">
                                <input type="number" placeholder="Harga Jual" name="harga_jual" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Supplier</label>
                            <div class="col-md-8">
                                <select class="cari form-control" id="supplier" name="supplier_id">
                                </select>
                            </div>
                        </div>
                        <div class="form-group float-right pt-5">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary ml-2">Simpan</button>
                        </div>
                    </div>
                </form>
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

    var table;

    $(function () {
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('barang.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'barang_id', name: 'barang_id'},
                {data: 'nama_barang', name: 'nama_barang'},
                {data: 'harga_beli', name: 'harga_beli'},
                {data: 'harga_jual', name: 'harga_jual'},
                {data: 'action', name: 'action'},
            ]
        });
    });

    $('#tambah').on('click', function(){
        const url = $(this).data('url');
        $('#modal').modal('show');
        $('#form-barang')[0].reset();
    	$("input[name='id']").val(null);
    	$("input[name='barang_id']").val(null);
        $("#supplier").val(null).trigger('change');
        select_supplier();

        validate();
    })

    $('#table').on('click', '.edit', function () {
    	const id = $(this).data('id');
        console.log(id);
        let _url = '/barang/'+id+'/edit';

    	$.ajax({
    	type: 'GET',
    	url: _url,
    	data: {
    	    id: id
    	},
    	dataType: 'json',
    	success: function (pl) {
            console.log(pl.supplier.id);
            console.log(pl.supplier.nama_supplier);

    	    $("input[name='id']").val(pl.barang.id);
    	    $("input[name='barcode']").val(pl.barang.barcode);
    	    $("input[name='nama_barang']").val(pl.barang.nama_barang);
    	    $("input[name='harga_beli']").val(pl.barang.harga_beli);
    	    $("input[name='harga_jual']").val(pl.barang.harga_jual);

            var data = {
                id: pl.supplier.id,
                text: pl.supplier.nama_supplier
            };

            var newOption = new Option(data.text, data.id, true, true);
            $('#supplier').append(newOption).trigger('change');

    	    $('#modal').modal('show');

    	    validate();
    	}
    	});
    	})

        function validate(){
            $('#form-barang').validate({
                rules: {
                    nama_barang: {
                        required: true
                    },
                    barcode: {
                        required: true
                    },
                    supplier_id: {
                        required: true
                    },
                },
                messages: {
                    barcode: {
                        required: "Wajib di isi"
                    },
                    nama_barang: {
                        required: "Wajib di isi",
                    },
                    supplier_id: {
                        required: "Wajid di isi"
                    },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.col-sm-8').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function (form) {
                    $.ajax({
                        type: 'POST',
                        url: '/barang',
                        data: $('#form-barang').serialize(),
                        dataType: 'json',
                        success: function (output) {
                            $('#modal').modal('hide');
                            Swal.fire({
                                position: 'top',
                                type: 'success',
                                title: output.message,
                                showConfirmButton: false,
                                timer: 1500
                            })

                            $('#form-barang')[0].reset();
                            table.ajax.reload();
                        }
                    });
                }
            })
    }

    $('#table').on('click', '.delete', function () {
            const id = $(this).data('id');
            console.log(id);
            let _url = `/barang/${id}`;
            let _token = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
      		    type: 'warning',
      			title: 'Hapus Barang?',
      			text: 'Data akan dihapus',
      			showCancelButton: true,
      			confirmButtonColor: '#d33',
      			confirmButtonText: 'Hapus',
      			cancelButtonText: 'Batal',
      			preConfirm: (confirm) => {
      				console.log("OK");
                    $.ajax({
                        type: 'DELETE',
                        url: _url,
                        data: {
                            _token: _token
                        },
                        dataType: 'json',
                        success: function (output) {
                            Swal.fire({
                                position: 'top',
                                type: 'success',
                                title: output.message,
                                showConfirmButton: false,
                                timer: 1500
                            })

                            table.ajax.reload();
                            $('#form-barang')[0].reset();
                        }
                    });
      			},
      		})
        });

        let _token = $('meta[name="csrf-token"]').attr('content');

        function select_supplier(){

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
                        results:  $.map(data, function (item) {
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
        }

</script>
@endpush
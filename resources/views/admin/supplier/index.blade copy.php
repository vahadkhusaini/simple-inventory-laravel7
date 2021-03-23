@extends('admin.main')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Pelanggan</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <a href="javascript:void(0)" id="tambah" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah</a>
                </div>
                <div class="card-body table-responsive">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Pelanggan</th>
                                <th>Nama Pelanggan</th>
                                <th>No Telepon</th>
                                <th>Alamat</th>
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

<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="tambah-pelanggan" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama_pelanggan" class="form-control"
                                    placeholder="Nama Pelanggan">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">No Telepon</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="No Telepon" name="telepon">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <textarea type="text" name="alamat" class="form-control"
                                    placeholder="Alamat"></textarea>
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

<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="update-pelanggan" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">ID Pelanggan</label>
                            <div class="col-sm-8">
                                <input type="hidden" name="id" readonly class="form-control">
                                <input type="text" name="pelanggan_id" readonly class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama_pelanggan" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">No Telepon</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="telepon">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <textarea type="text" name="alamat" class="form-control"></textarea>
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
            ajax: "{{ route('pelanggan.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'pelanggan_id', name: 'pelanggan_id'},
                {data: 'nama_pelanggan', name: 'nama_pelanggan'},
                {data: 'telepon', name: 'telepon'},
                {data: 'alamat', name: 'alamat'},
                {data: 'action', name: 'action'},
            ]
        });
    });

    $('#tambah').on('click', function(){
        $('#modal-tambah').modal('show');
        $('#tambah-pelanggan')[0].reset();

        $('#tambah-pelanggan').validate({
            rules: {
                nama_pelanggan: {
                    required: true
                },
                telepon: {
                    required: true,
                    number: true
                },
                alamat: {
                    required: true
                },
            },
            messages: {
                nama_pelanggan: {
                    required: "Wajib di isi"
                },
                telepon: {
                    required: "Wajib di isi",
                    number: "Isi dengan angka"
                },
                alamat: {
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
                    url: '/pelanggan',
                    data: $('#tambah-pelanggan').serialize(),
                    dataType: 'json',
                    success: function (output) {
                        $('#modal-tambah').modal('hide');
                        $('#tambah-pelanggan')[0].reset();
                        Swal.fire({
                            position: 'top',
                            type: 'success',
                            title: output.message,
                            showConfirmButton: false,
                            timer: 1700
                        })

                        table.ajax.reload();
                        $("input[name='pelanggan_id']").val(output.auto_kode);
                    }
                });
            }
        });
    })

    $('#update-pelanggan').validate({
            rules: {
                nama_pelanggan: {
                    required: true
                },
                telepon: {
                    required: true,
                    number: true
                },
                alamat: {
                    required: true
                },
            },
            messages: {
                nama_pelanggan: {
                    required: "Wajib di isi"
                },
                telepon: {
                    required: "Wajib di isi",
                    number: "Isi dengan angka"
                },
                alamat: {
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
                    url: '/pelanggan/update',
                    data: $('#update-pelanggan').serialize(),
                    dataType: 'json',
                    success: function (output) {
                        $('#modal-edit').modal('hide');
                        $('#update-pelanggan')[0].reset();
                        Swal.fire({
                            position: 'top',
                            type: 'success',
                            title: output.message,
                            showConfirmButton: false,
                            timer: 1700
                        })

                        table.ajax.reload();
                    }
                });
            }
        });

    $('#table').on('click', '.edit', function () {
    	const id = $(this).data('id');
        console.log(id);
        let _url = '/pelanggan/'+id+'/edit';

    	    $.ajax({
    	        type: 'GET',
    	        url: _url,
    	        data: {
    	            id: id
    	        },
    	        dataType: 'json',
    	        success: function (pl) {
    	            $("input[name='id']").val(pl.id);
    	            $("input[name='pelanggan_id']").val(pl.pelanggan_id);
    	            $("input[name='nama_pelanggan']").val(pl.nama_pelanggan);
    	            $("input[name='telepon']").val(pl.telepon);
    	            $("textarea[name='alamat']").val(pl.alamat);
                    $('#modal-edit').modal('show');
    	        }
    	    });
    	})

    $('#table').on('click', '.delete', function () {
            const id = $(this).data('id');
            console.log(id);
            let _url = `/pelanggan/${id}`;
            let _token = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
      		    type: 'warning',
      			title: 'Hapus Pelanggan?',
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
                                timer: 1700
                            })

                            table.ajax.reload();
                        }
                    });
      			},
      		})
        });
</script>
@endpush
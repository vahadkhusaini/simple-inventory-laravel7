<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
       <!-- Notifications Dropdown Menu -->
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">
						<i class="far fa-user"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
						<a href="#" data-toggle="modal" data-target="#modal-edit-profile" class="dropdown-item">
							<i class="fas fa-user mr-2"></i> Ubah Profile
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal-changepass">
							<i class="fas fa-key mr-2"></i> Ubah Password 
						</a>
						<div class="dropdown-divider"></div>
						<a href="/logout" id="logout" class="dropdown-item">
							<i class="fas fa-sign-out-alt text-danger mr-2"></i><span class="text-danger">Keluar</span>
						</a>
					</div>
				</li>
    </ul>
</nav>
<!-- /.navbar -->

<div class="modal fade" id="modal-edit-profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      	aria-hidden="true">
      	<div class="modal-dialog" role="document">
      		<div class="modal-content">
      			<div class="modal-header">
      				<h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
      				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
      					<span aria-hidden="true">×</span>
      				</button>
      			</div>
      			<form method="POST" id="edit-profile" data-url="/editProfile" action="javascript:void(0)">
                @csrf
				  <div class="modal-body">
      					<div class="form-group row">
      						<label for="staticEmail" class="col-sm-4 col-form-label">Nama Pengguna</label>
      						<div class="col-sm-8">
      							<input type="text" value="{{ auth()->user()->name }}" class="form-control" value="" name="username">
      						</div>
      						
      					</div>
      				</div>
      				<div class="modal-footer">
      					<button class="btn btn-primary" type="submit">Simpan</button>
      				</div>
      			</form>
      		</div>
      	</div>
      </div>

	  <div class="modal fade" id="modal-changepass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      	aria-hidden="true">
      	<div class="modal-dialog" role="document">
      		<div class="modal-content">
      			<div class="modal-header">
      				<h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
      				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
      					<span aria-hidden="true">×</span>
      				</button>
      			</div>
      			<form method="POST" data-url="/changePassword"  id="change-password">
                  @csrf
				  <div class="modal-body">
      					<div class="form-group row">
      						<label for="staticEmail" class="col-sm-4 col-form-label">Password Lama</label>
      						<div class="col-sm-8">
      							<input type="password" class="form-control" name="oldpass">
      						</div>
      						
      					</div>
      					<div class="form-group row">
      						<label for="inputPassword" class="col-sm-4 col-form-label">Password Baru</label>
      						<div class="col-sm-8">
      							<input type="password" class="form-control" name="newpass">
      						</div>
      					</div>
      				</div>
      				<div class="modal-footer">
      					<button class="btn btn-primary" type="submit">Simpan</button>
      				</div>
      			</form>
      		</div>
      	</div>
      </div>

@push('child-js')
<script>
    $('#logout').on('click', function (e) {
        e.preventDefault();
        const url = $('#logout').attr('href');

        Swal.fire({
            type: 'warning',
            title: 'Keluar dari sistem?',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Keluar',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.value) {
                document.location.href = url;
            }
        })
    });

    $('#change-password').validate({
        rules: {
            oldpass: {
                required: true,
                minlength: 6
            },
            newpass: {
                required: true,
                minlength: 6
            },
        },
        messages: {
            oldpass: {
                required: "harus di isi",
                minlength: "Minimal password 6 karakter"
            },
            newpass: {
                required: "harus di isi",
                minlength: "Minimal password 6 karakter"
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
            console.log('success');
            const href = $('#change-password').data('url');
            $.ajax({
                type: 'POST',
                url: 'changePassword',
                data: $('#change-password').serialize(),
                dataType: 'json',
                success: function (data) {
                                    console.log(data);
                                    Swal.fire({
                                        position: 'top',
                                        type: 'success',
                                        title: data,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    
                                    document.location.href = '/logout';
                                },
                                error: function(data){
                                    Swal.fire({
                                        position: 'top',
                                        type: 'error',
                                        title: data.responseJSON,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                }
            });
        }
    });


    $('#edit-profile').validate({
        rules: {
            username: {
                required: true
            },
        },
        messages: {
            username: {
                required: "harus di isi"
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
            console.log('success');
            const href = $('#edit-profile').data('url');
            $.ajax({
                type: 'POST',
                url: href,
                data: $('#edit-profile').serialize(),
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
        }
    });
</script>
@endpush

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

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
						<a href="/logout" class="dropdown-item">
							<i class="fas fa-sign-out-alt text-danger mr-2"></i><span class="text-danger">Keluar</span>
						</a>
					</div>
				</li>
    </ul>
</nav>
<!-- /.navbar -->

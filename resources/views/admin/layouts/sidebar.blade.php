<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link @yield('Dashboard')">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview @yield('Master')">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-folder"></i>
						<p>
							Master Data
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/pelanggan" class="nav-link @yield('Pelanggan')">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Pelanggan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/supplier" class="nav-link @yield('Supplier')">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Supplier
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/barang" class="nav-link @yield('Barang')">
                                <i class="nav-icon fas fa-barcode"></i>
                                <p>
                                    Barang
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview @yield('Transaksi')">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-folder"></i>
						<p>
							Transaksi
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/pesanan" class="nav-link @yield('Pesanan')">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Pemesanan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/pembelian" class="nav-link @yield('Pembelian')">
                                <i class="nav-icon fas fa-cart-plus"></i>
                                <p>
                                    Pembelian
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/penjualan" class="nav-link @yield('Penjualan')">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Penjualan
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview @yield('Laporan')">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-folder"></i>
						<p>
							Laporan
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/stok" class="nav-link @yield('Stok')">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Stok
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

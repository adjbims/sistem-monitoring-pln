<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

		<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
				<div class="sidebar-brand-icon rotate-n-15">
						{{-- <i class="fas fa-laugh-wink"></i> --}}
				</div>
				<div class="sidebar-brand-text mx-2">SM-PLN MOBILE <sup></sup></div>
		</a>

		<hr class="sidebar-divider my-0">

		<!-- Nav Item - Dashboard -->
		<li class="nav-item {{ Nav::isRoute('home') }}">
				<a class="nav-link" href="{{ route('home') }}">
						<i class="fas fa-fw fa-tachometer-alt"></i>
						<span>{{ __('Dashboard') }}</span></a>
		</li>

		<hr class="sidebar-divider">

		<div class="sidebar-heading">
				{{ __('Settings') }}
		</div>

		<li class="nav-item {{ Nav::isRoute('profile') }}">
				<a class="nav-link" href="{{ route('profile') }}">
						<i class="fas fa-fw fa-user"></i>
						<span>{{ __('Profile') }}</span>
				</a>
		</li>

		<!-- Divider -->
		<hr class="sidebar-divider">

		<div class="sidebar-heading">
				MENU
		</div>

		@if (Auth::user()->role == 'admin')
				<li class="nav-item {{ Nav::isRoute('kelola-pegawai.index') }}">
						<a class="nav-link" href="{{ route('kelola-pegawai.index') }}">
								<i class="fas fa-fw fa-user"></i>
								<span>{{ __('Kelola Pegawai') }}</span>
						</a>
				</li>
				<li class="nav-item {{ Nav::isRoute('kelola-tad.index') }}">
						<a class="nav-link" href="{{ route('kelola-tad.index') }}">
								<i class="fas fa-fw fa-user"></i>
								<span>{{ __('Kelola TAD') }}</span>
						</a>
				</li>
				<li class="nav-item {{ Nav::isRoute('kelola-mitra.index') }}">
						<a class="nav-link" href="{{ route('kelola-mitra.index') }}">
								<i class="fas fa-fw fa-user"></i>
								<span>{{ __('Kelola Mitra') }}</span>
						</a>
				</li>

				<li class="nav-item {{ Nav::isRoute('data-transaksi.index') }}">
						<a class="nav-link" href="{{ route('data-transaksi.index') }}">
								<i class="fas fa-money-bill-wave"></i>
								<span>{{ __('Data Transaksi') }}</span>
						</a>
				</li>
		@endif

		@if (Auth::user()->role == 'pegawai')
				<li class="nav-item {{ Nav::isRoute('upload-transaksi.create') }}">
						<a class="nav-link" href="{{ route('upload-transaksi.create') }}">
								<i class="fas fa-money-bill-wave"></i>
								<span>{{ __('Upload Bukti Transaksi') }}</span>
						</a>
				</li>

				<li class="nav-item {{ Nav::isRoute('riwayat-transaksi.index') }}">
						<a class="nav-link" href="{{ route('riwayat-transaksi.index') }}">
								<i class="fas fa-money-bill-wave"></i>
								<span>{{ __('Riwayat Transaksi') }}</span>
						</a>
				</li>
		@endif

		<hr class="sidebar-divider d-none d-md-block">

		<div class="d-none d-md-inline text-center">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
		</div>

</ul>

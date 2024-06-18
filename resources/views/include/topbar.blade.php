<nav class="navbar navbar-expand navbar-light topbar static-top mb-4 bg-white shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>
  
    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline ml-md-3 my-md-0 mw-100 navbar-search my-2 mr-auto">
      {{-- <div class="input-group">
        <input type="text" class="form-control bg-light small border-0" placeholder="Search for..." aria-label="Search"
               aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search fa-sm"></i>
          </button>
        </div>
      </div> --}}
    </form>
  
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
  
      <!-- Nav Item - Search Dropdown (Visible Only XS) -->
      <li class="nav-item dropdown no-arrow d-sm-none">
        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-search fa-fw"></i>
        </a>
        <!-- Dropdown - Messages -->
        <div class="dropdown-menu dropdown-menu-right animated--grow-in p-3 shadow" aria-labelledby="searchDropdown">
          <form class="form-inline w-100 navbar-search mr-auto">
            <div class="input-group">
              <input type="text" class="form-control bg-light small border-0" placeholder="Search for..."
                     aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
  
      @if (auth()->user()->role != 'admin')
        @php
          $notifikasi = auth()->user()->notifikasi();
        @endphp
  
        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
             aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <!-- Counter - Alerts -->
            <span class="badge badge-danger badge-counter">{{ $notifikasi['count'] ?? 0 }}</span>
          </a>
          <!-- Dropdown - Alerts -->
          <div class="dropdown-list dropdown-menu dropdown-menu-right animated--grow-in shadow"
               aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">
              Alerts Center
            </h6>
            <a class="dropdown-item d-flex align-items-center" href="#">
              @if ($notifikasi > 0)
                <div class="mr-3">
                  <div class="icon-circle bg-warning">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                  </div>
                </div>
                <div>
                  <div class="small text-gray-500">{{ $notifikasi['date'] }}</div>
                  {{ $notifikasi['message'] }}
                </div>
              @else
                <p>tidak ada notifikasi</p>
              @endif
            </a>
            <a class="dropdown-item small text-center text-gray-500" href="#">Show All Alerts</a>
          </div>
        </li>
      @endif
  
      <div class="topbar-divider d-none d-sm-block"></div>
  
      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
          <span class="d-none d-lg-inline small mr-2 text-gray-600">{{ Auth::user()->name }}</span>
          @if (Auth::user()->profile_photo)
            <img src="{{ asset('storage/profile_photos/' . Auth::user()->profile_photo) }}" class="rounded-circle" style="width: 35px; height: 35px;">
          @else
            <figure class="img-profile rounded-circle avatar font-weight-bold" data-initial="{{ Auth::user()->name[0] }}"></figure>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right animated--grow-in shadow" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="{{ route('profile') }}">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            {{ __('Profile') }}
          </a>
          <a class="dropdown-item" href="javascript:void(0)">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            {{ __('Settings') }}
          </a>
          <a class="dropdown-item" href="javascript:void(0)">
            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
            {{ __('Activity Log') }}
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            {{ __('Logout') }}
          </a>
        </div>
      </li>          
  
    </ul>
    {{-- @dd($notifikasi) --}}
  
  </nav>
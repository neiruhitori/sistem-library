<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/dashboard" class="nav-link">Home</a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li> --}}
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" id="notificationDropdown">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge" id="notificationCount" style="display: none;">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow-lg border-0" id="notificationDropdownMenu" style="width: 350px; max-height: 500px; overflow-y: auto;">
                <!-- Header -->
                <div class="bg-primary text-white px-3 py-2 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 font-weight-bold">
                        <i class="fas fa-bell mr-2"></i>
                        <span id="notificationHeader">Notifikasi</span>
                    </h6>
                    <small id="notificationTime" class="text-light opacity-75"></small>
                </div>
                
                <!-- Loading indicator -->
                <div id="notificationLoading" class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="text-muted mt-2 mb-0 small">Memuat notifikasi...</p>
                </div>
                
                <!-- Notification items container -->
                <div id="notificationItems" class="notification-container"></div>
                
                <!-- Empty state -->
                <div id="notificationEmpty" class="text-center py-4" style="display: none;">
                    <div class="text-muted">
                        <i class="fas fa-inbox fa-2x mb-2 opacity-50"></i>
                        <p class="mb-0">Tidak ada notifikasi</p>
                        <small>Semua notifikasi akan muncul di sini</small>
                    </div>
                </div>
                
                <!-- Footer Actions -->
                <div class="bg-light px-3 py-2 border-top">
                    <div class="row no-gutters">
                        <div class="col-6 pr-1">
                            <button class="btn btn-outline-primary btn-sm btn-block" id="markAllReadBtn">
                                <i class="fas fa-check-double"></i> Tandai Dibaca
                            </button>
                        </div>
                        <div class="col-6 pl-1">
                            <button class="btn btn-outline-danger btn-sm btn-block" id="clearAllBtn">
                                <i class="fas fa-trash-alt"></i> Hapus Semua
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li> --}}
    </ul>
</nav>

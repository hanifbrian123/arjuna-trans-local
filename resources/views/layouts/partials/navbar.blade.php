<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ url('/') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ url('/') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard') }}">
                        <i class="mdi mdi-file-document"></i> <span>Dashboard</span>
                    </a>
                </li>

                <!-- Order Management -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarOrder" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarOrder">
                        <i class="mdi mdi-file-document"></i> <span>Order</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarOrder">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link">Order</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Kalender</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Driver -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="mdi mdi-file-document"></i> <span>Driver</span>
                    </a>
                </li>

                <!-- Armada -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('vehicles.index') }}">
                        <i class="mdi mdi-file-document"></i> <span>Armada</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>

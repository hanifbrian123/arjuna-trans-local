<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ url('/') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/favicon_arjuna/android-chrome-512x512.png') }}" alt="" height="50">
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
                        <i class="mdi mdi-view-dashboard-outline"></i> <span>Dashboard</span>
                    </a>
                </li>

                <!-- Order Management -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarOrder" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarOrder">
                        <i class="mdi mdi-cart-outline"></i> <span>Orders</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarOrder">
                        <ul class="nav nav-sm flex-column">
                            @role('admin')
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.index') }}" class="nav-link">Data Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.calendar') }}" class="nav-link">Calender Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.payments.index') }}" class="nav-link">Laporan Payment</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.omset') }}" class="nav-link">Laporan Omset</a>
                                </li>
                            @endrole

                            @role('driver')
                                <li class="nav-item">
                                    <a href="{{ route('driver.orders.index') }}" class="nav-link">Daftar Order</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('driver.orders.calendar') }}" class="nav-link">Jadwal Saya</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('driver.orders.create') }}" class="nav-link">Buat Order</a>
                                </li>
                            @endrole
                        </ul>
                    </div>
                </li>

                @role('admin')
                    <!-- Driver Management -->
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('admin.drivers.index') }}">
                            <i class="mdi mdi-account-group"></i> <span>Driver</span>
                        </a>
                    </li>

                    <!-- Armada Management -->
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('admin.vehicles.index') }}">
                            <i class="mdi mdi-car-multiple"></i> <span>Armada</span>
                        </a>
                    </li>

                    <!-- Expense Management -->
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('admin.expenses.index') }}">
                            <i class="mdi mdi-wallet"></i> <span>Pengeluaran</span>
                        </a>
                    </li>
                    
                    <!-- Financial Report -->
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('admin.finance.index') }}">
                            <i class="mdi mdi-cash-100"></i> <span>Laporan Kas</span>
                        </a>
                    </li>
                @endrole




            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>

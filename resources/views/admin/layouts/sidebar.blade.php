<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{asset('admin-assets/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">PHQMM</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.list') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>User Management</p>
                    </a>
                </li>

               
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.purchase') }}" >
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>Local Purchase <span class="caret"></span></p>
                    </a>
                    <!-- <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="{{ route('purchases.create') }}">
                                <i class="nav-icon fas fa-plus" style="color: #0B60B0;"></i>
                                <p style="color: #0B60B0; font-weight: 600;">Add Purchase</p>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('purchases.index') }}">
                                <i class="nav-icon fas fa-shopping-cart"  style="color: #0B60B0;"></i>
                                <p style="color: #0B60B0; font-weight: 600;">Purchase List</p>
                            </a>
                        </li>
                    </ul>
                </li> -->

                <li class="nav-item">
                    <a href="{{ route('bookings.breakfast-list') }}" class="nav-link">
                        <i class="nav-icon fas fa-coffee"></i>
                        <p>Breakfast</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('bookings.lunch-list') }}" class="nav-link">
                        <i class="nav-icon fas fa-utensils"></i>
                        <p>Lunch</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('bookings.dinner-list') }}" class="nav-link">
                        <i class="nav-icon fas fa-hamburger"></i>
                        <p>Dinner</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.masterdata') }}" class="nav-link">
                        <i class="nav-icon fas fa-sitemap"></i>
                        <p>Master Data</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reports') }}" class="nav-link">
                        <i class="nav-icon fas fa-coffee"></i>
                        <p>Report</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
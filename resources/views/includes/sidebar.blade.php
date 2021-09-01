   @if (is_object(Auth::user()))  
 <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <x-jet-application-mark class="block h-9 w-auto" />
                <div class="sidebar-brand-text mx-2">Order <sup>System</sup> </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ (request()->is('dashboard')) ? 'active' : ''}}">
                <a class="nav-link " href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Master
            </div>

            <!-- Nav Item - Customer Collapse Menu -->
            <li class="nav-item  {{ (request()->is('customer*')) ? 'active' : ''}}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomer"
                    aria-expanded="true" aria-controls="collapseCustomer">
                    <i class="fas fa-fw fa-building"></i>
                    <span>Customer</span>
                </a>
                <div id="collapseCustomer" class="collapse  {{ (request()->is('customer*')) ? 'show' : ''}}" 
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Customer:</h6>
                        <a class="collapse-item
                        {{ (request()->is('customer/branch')) ? 'active' : ''}}" 
                        href="{{ route('branch') }}">Cabang</a>
                        <a class="collapse-item  
                        {{ (request()->is('customer/user')) ? 'active' : ''}}" 
                        href="{{ route('user') }}">User</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Product Collapse Menu -->
            <li class="nav-item {{ (request()->is('product*')) ? 'active' : ''}}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct"
                    aria-expanded="true" aria-controls="collapseProduct">
                    <i class="fas fa-fw fa-archive"></i>
                    <span>Product</span>
                </a>
                <div id="collapseProduct" class="collapse {{ (request()->is('product*')) ? 'show' : ''}}" 
                    aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Product:</h6>
                        <a class="collapse-item
                        {{ (request()->is('product/category')) ? 'active' : ''}}" 
                        href="{{ route('category') }}">Category</a>
                        <a class="collapse-item
                        {{ (request()->is('product/detail')) ? 'active' : ''}}" 
                        href="{{ route('product') }}">Product</a>                      
                    </div>
                </div>
            </li>

       

            <!-- Nav Item - Charts -->
            <li class="nav-item {{ (request()->is('order*')) ? 'active' : ''}}">
                <a class="nav-link"  href="{{ route('list.order') }}">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Order</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Cabang
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="{{ asset('theme/#') }}" data-toggle="collapse" data-target="#collapseOrderCabang" aria-expanded="true"
                    aria-controls="collapseOrderCabang">
                    <i class="fas fa-fw fa-cart-plus"></i>
                    <span>Order</span>
                </a>
                <div id="collapseOrderCabang" class="collapse " aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Order:</h6>
                        <a class="collapse-item" href="{{ asset('theme/login.html') }}">Tambah Baru</a>
                        <a class="collapse-item" href="{{ asset('theme/register.html') }}">Daftar Order</a>
                      
                    </div>
                </div>
            </li>

             <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Distributor & Agen
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="{{ asset('theme/#') }}" data-toggle="collapse" data-target="#collapseOrderDisAgen" aria-expanded="true"
                    aria-controls="collapseOrderDisAgen">
                    <i class="fas fa-fw fa-cart-plus"></i>
                    <span>Order</span>
                </a>
                <div id="collapseOrderDisAgen" class="collapse " aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Order:</h6>
                        <a class="collapse-item" href="{{ asset('theme/login.html') }}">Tambah Baru</a>
                        <a class="collapse-item" href="{{ asset('theme/register.html') }}">Daftar Order</a>
                      
                    </div>
                </div>
            </li>


            

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->@endif     
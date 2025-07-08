<div id="sidebar_color" class="">
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.index') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">


        <!-- Nav Item - Pages Collapse Menu -->
        <li
            class="nav-item {{ request()->routeIs('admin.categories.index') || request()->routeIs('admin.categories.create') ? 'active' : '' }} ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoCategories"
                aria-expanded="true" aria-controls="collapseTwoCategories">
                <i class="fas fa-fw fa-tag"></i>
                <span>Categories</span>
            </a>
            <div id="collapseTwoCategories"
                class="collapse {{ request()->routeIs('admin.categories.index') || request()->routeIs('admin.categories.create') ? 'show' : '' }} "
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}"
                        href="{{ route('admin.categories.index') }}">All Category</a>
                    <a class="collapse-item {{ request()->routeIs('admin.categories.create') ? 'active' : '' }} "
                        href="{{ route('admin.categories.create') }}">Add New</a>
                </div>
            </div>
        </li>


        <li
            class="nav-item {{ request()->routeIs('admin.sub-categories.index') || request()->routeIs('admin.sub-categories.create') ? 'active' : '' }} ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoSubCategories"
                aria-expanded="true" aria-controls="collapseTwoSubCategories">
                <i class="fas fa-layer-group"></i>
                <span>Sub Categories</span>
            </a>
            <div id="collapseTwoSubCategories"
                class="collapse {{ request()->routeIs('admin.sub-categories.index') || request()->routeIs('admin.sub-categories.create') ? 'show' : '' }} "
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->routeIs('admin.sub-categories.index') ? 'active' : '' }}"
                        href="{{ route('admin.sub-categories.index') }}">All SubCategory</a>
                    <a class="collapse-item {{ request()->routeIs('admin.sub-categories.create') ? 'active' : '' }} "
                        href="{{ route('admin.sub-categories.create') }}">Add New</a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider">


        <li
            class="nav-item {{ request()->routeIs('admin.brands.index') || request()->routeIs('admin.brands.create') ? 'active' : '' }} ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoBrands"
                aria-expanded="true" aria-controls="collapseTwoBrands">
                <i class="fas fa-code-branch"></i>
                <span>Brands</span>
            </a>
            <div id="collapseTwoBrands"
                class="collapse {{ request()->routeIs('admin.brands.index') || request()->routeIs('admin.brands.create') ? 'show' : '' }} "
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->routeIs('admin.brands.index') ? 'active' : '' }}"
                        href="{{ route('admin.brands.index') }}">All Brand</a>
                    <a class="collapse-item {{ request()->routeIs('admin.brands.create') ? 'active' : '' }} "
                        href="{{ route('admin.brands.create') }}">Add New</a>
                </div>
            </div>
        </li>
        <hr class="sidebar-divider">
        <li
            class="nav-item {{ request()->routeIs('admin.products.index') || request()->routeIs('admin.products.create') ? 'active' : '' }} ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoProducts"
                aria-expanded="true" aria-controls="collapseTwoProducts">
                <i class="fas fa-fw fa-heart"></i>
                <span>Products</span>
            </a>
            <div id="collapseTwoProducts"
                class="collapse {{ request()->routeIs('admin.products.index') || request()->routeIs('admin.products.create') ? 'show' : '' }} "
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}"
                        href="{{ route('admin.products.index') }}">All Product</a>
                    <a class="collapse-item {{ request()->routeIs('admin.products.create') ? 'active' : '' }} "
                        href="{{ route('admin.products.create') }}">Add New</a>
                </div>
            </div>
        </li>


        <li
            class="nav-item {{ request()->routeIs('admin.shipping.index') || request()->routeIs('admin.shipping.create') ? 'active' : '' }} ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoShipping"
                aria-expanded="true" aria-controls="collapseTwoShipping">
                <i class="fas fa-shipping-fast"></i> <span>Shipping</span>
            </a>
            <div id="collapseTwoShipping"
                class="collapse {{ request()->routeIs('admin.shipping.index') || request()->routeIs('admin.shipping.create') ? 'show' : '' }} "
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->routeIs('admin.shipping.index') ? 'active' : '' }}"
                        href="{{ route('admin.shipping.index') }}">All Shipping</a>
                    <a class="collapse-item {{ request()->routeIs('admin.shipping.create') ? 'active' : '' }} "
                        href="{{ route('admin.shipping.create') }}">Add New</a>
                </div>
            </div>
        </li>

          <li
            class="nav-item {{ request()->routeIs('admin.coupons.index') || request()->routeIs('admin.coupons.create') ? 'active' : '' }} ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoCoupons"
                aria-expanded="true" aria-controls="collapseTwoCoupons">
                <i class="fas fa-percent"></i></i> <span>Coupons</span>
            </a>
            <div id="collapseTwoCoupons"
                class="collapse {{ request()->routeIs('admin.coupons.index') || request()->routeIs('admin.coupons.create') ? 'show' : '' }} "
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->routeIs('admin.coupons.index') ? 'active' : '' }}"
                        href="{{ route('admin.coupons.index') }}">All Coupons</a>
                    <a class="collapse-item {{ request()->routeIs('admin.coupons.create') ? 'active' : '' }} "
                        href="{{ route('admin.coupons.create') }}">Add New</a>
                </div>
            </div>
        </li>



        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>

</div>

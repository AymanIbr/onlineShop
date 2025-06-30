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



        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>

</div>

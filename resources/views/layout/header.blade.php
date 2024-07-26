<div class="sidebar main-sidebar sidebar-dark-primary elevation-4" id="sidebarhover">
    <div class="logo" style="text-align:center">
        <a href="" class="simple-text logo-normal">
            <img class="img-size" src="{{tracesciimg('maplejet-logo.png')}}" style="max-width:70%">
        </a>
    </div>
    <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">  
            <li class="nav-item {{ Route::is('dashboard_index.*') ? ' active' : '' }}" style="display: flex;">
                <a href="{{ url('/') }}">
                <i class="fas fa-tachometer-alt" style="color: #ffffff;"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item {{ Route::is('products.*') ? ' active' : '' }}">
                <a href="{{route('products.index')}}">
                    <i class="fas fa-shopping-bag"></i>
                    <p>Products</p>
                </a>
            </li>
            <li class="nav-item{{ Route::is('batches.*') ? ' active' : '' }}">
                <a href="{{ route('batches.index') }}">
                    <i class="fas fa-boxes"></i>
                    <p>Batches</p>
                </a>
            </li>
            <li class="nav-item has-treeview {{ Route::is('production-plants.*')  || Route::is('production-lines.*') ? ' menu-open' : '' }}" id="products-menu">
                <a class="has-subs" data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="false" onclick="toggleprod()">
                    <i class="now-ui-icons education_atom"></i>
                    <p>Production</p>
                </a>
                <ul id="collapse-1" class="nav-treeview" style="display: {{ Route::is('production-plants.*')  || Route::is('production-lines.*') ? ' block' : 'none' }}">
                    <li class="nav-item {{ Route::is('production-plants.*') ? ' active' : '' }}">
                        <a href="{{route('production-plants.index')}}" class="nav nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Producton Plant</p>
                        </a>
                    </li>
                    <li class="nav-item{{ Route::is('production-lines.*') ? ' active' : '' }}">
                        <a href="{{route('production-lines.index')}}" class="nav nav-link">
                            <i class="now-ui-icons education_atom"></i>
                            <p>Production Lines</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item{{ Route::is('jobs.*') ? ' active' : '' }}">
                <a href="{{route('jobs.index')}}">
                    <i class="fas fa-briefcase"></i>
                    <p>Jobs</p>
                </a>
            </li>
            <li class="nav-item{{ Route::is('print.*') ? ' active' : '' }}">
                <a href="{{route('print.index')}}" style="display:flex">
                    <i class="fas fa-print"></i>
                    <p>Print Module</p>
                </a>
            </li>
            <li class="nav-item {{ Route::is('qrcodes.*') ? ' active' : '' }}">
                <a href="{{route('qrcodes.index')}}" style="display:flex">
                    <i class="fas fa-qrcode"></i>
                    <p>Qrcodes</p>
                    <img src="{{tracesciimg('dropdown.svg')}}" style="max-width:16px; margin-left: 66px;">
                </a>
                <!-- <li class="nav-item has-treeview {{ Route::is('bulkuploads;.*')  || Route::is('.*') || Route::is('users.*') ? ' menu-open' : '' }}" id="products-menu">
                <a class="has-subs" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false" onclick="removedisplaynone()" style="display:flex;">
                    <i class="now-ui-icons text_caps-small"></i>
                    <p>User Management</p>
                    <img src="{{tracesciimg('dropdown.svg')}}" style="max-width:16px; margin-left: 66px;">
                </a>
                <ul  id="collapse-2" class="nav-treeview" style="display: {{ Route::is('permissions.*')  || Route::is('roles.*') || Route::is('users.*') ? 'block' : 'none' }}">
                    <li class="nav-item {{ Route::is('roles.*') ? ' active' : '' }}">
                        <a href="{{route('roles.index')}}" class="nav nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Roles</p>
                        </a>
                    </li>
            </li> -->
            <li class="nav-item {{ Route::is('bulkuploads.*') ? 'active' : '' }}">
                <a href="{{route('bulkuploads.index')}}">
                    <i class="fas fa-tasks"></i>
                    <p>Bulk Uploads</p>
                </a>
            </li>
            <li class="nav-item has-treeview {{ Route::is('permissions.*')  || Route::is('roles.*') || Route::is('users.*') ? ' menu-open' : '' }}" id="products-menu">
                <a class="has-subs" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false" onclick="removedisplaynone()" style="display:flex;">
                    <i class="now-ui-icons text_caps-small"></i>
                    <p>User Management</p>
                    <!-- <img src="{{tracesciimg('dropdown.svg')}}" style="max-width:16px; margin-left: 66px;"> -->
                </a>
                <ul id="collapse-2" class="nav-treeview" style="display: {{ Route::is('permissions.*')  || Route::is('roles.*') || Route::is('users.*') ? 'block' : 'none' }}">
                    <li class="nav-item {{ Route::is('users.*') ? ' active' : '' }}">
                        <a href="{{route('users.index')}}" class="nav nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('roles.*') ? ' active' : '' }}">
                        <a href="{{route('roles.index')}}" class="nav nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Roles</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('permissions.*') ? ' active' : '' }}">
                        <a href="{{route('permissions.index')}}" class="nav nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Permissions</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('scanhistories.*') ? ' active' : '' }}">
                        <a href="{{route('scanhistories.index')}}">
                        <i class="fal fa-scanner"></i>
                            <p>Scan Histories</p>
                        </a>
                    </li>

                </ul>

            </li>
            <li class="nav-item {{ Route::is('userlog.show') ? 'active' : '' }}">
                <a href="{{route('userlog.show')}}">
                <i class="fas fa-newspaper"></i>
                    <p>User Log</p>
                </a>
            </li>
            <li class="nav-item {{ Route::is('reportlog.show') ? 'active' : '' }}">
                <a href="{{route('reportlog.show')}}">
                <i><img style="margin-top: 3px;" class="img-size" src="{{tracesciimg('reportlog.png')}}" width="20px" height="20px"></i>
                    <p>Report Log</p>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a href="">
                    <i class="now-ui-icons location_map-big"></i>
                    <p>Maps</p>
                </a>
            </li> -->
            <!-- <li class="nav-item">
                <a href="">
                    <i class="now-ui-icons ui-1_bell-53"></i>
                    <p>Notifications</p>
                </a>
            </li> -->
            <!-- <li class="nav-item">
                <a href="">
                    <i class="now-ui-icons users_single-02"></i>
                    <p>User Profile</p>
                </a>
            </li>
            <li class="nav-item}">
                <a href="">
                    <i class="now-ui-icons design_bullet-list-67"></i>
                    <p>Table List</p>
                </a>
            </li> -->
            <!-- <li class="nav-item">
                <a href="{{route('users.index')}}">
                    <i class="now-ui-icons text_caps-small"></i>
                    <p>User Management1</p>
                </a>
            </li> -->

            <div class="logo" style="text-align:center">
                <a href="" class="simple-text logo-normal">
                    <img class="img-size" src="{{tracesciimg('tracescilogo.png')}}" style="max-width:70%; margin-top: 215px">
                </a>
            </div>

            <!-- <li class="active-pro">
                <a href="nav-item">
                    <i class="now-ui-icons arrows-1_cloud-download-93"></i>
                    <p>Upgrade to PRO</p>
                </a>
            </li> -->
    </div>
</div>
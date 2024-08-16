<header class="navbar navbar-header navbar-header-fixed">
  <a href="" id="sidebarMenuOpen" class="burger-menu"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
      <line x1="19" y1="12" x2="5" y2="12"></line>
      <polyline points="12 19 5 12 12 5"></polyline>
    </svg></a>
  <div class="navbar-brand">
    <a href="https://maplejet.com/in/" class="df-logo">maple<span style="color:#b70a9b;">jet</span></a>

  </div><!-- navbar-brand -->
  <div class="navbar-right">
    <div class="dropdown dropdown-profile">
      <button onclick="openProfile()" class="btn dropdown-link profile_icon" data-toggle="dropdown" data-display="static">
        <div class="avatar avatar-sm">
          <span class="avatar-initial rounded-circle"><img src="{{tracesciimg('user_icon.png')}}" alt=""></span>
        </div>
      </button><!-- dropdown-link -->
      <div class="dropdown-menu dropdown-menu-right tx-13 bg-gray-100 profile" id="open_profile" style="display: none;">
        <!-- Close button -->
        <div class="row justify-content-end">
          <button onclick="closeProfile()" class="btn float-right">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="avatar mg-b-15">
          <span class="avatar-initial rounded-circle"><img src="{{tracesciimg('user_icon.png')}}" alt=""></span>
        </div>
        <h6 class="tx-semibold mg-b-5">{{ Auth::user()->name ?? "" }}</h6>
        <p class="mg-b-25 tx-12 tx-color-03">Administrator</p>

        <a href="{{route('profile')}}" class="dropdown-item"><i data-feather="user"></i> View Profile</a>
        <a href="{{route('changepassword')}}" class="dropdown-item"><i data-feather="edit-3"></i>Change Password</a>

        <div class="dropdown-divider"></div>
      
      </div><!-- dropdown-menu -->
    </div><!-- dropdown -->




    <div class="navbar-right">

      <a href="{{route('logout1')}}" class="btn btn-buy"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
          <polyline points="16 17 21 12 16 7"></polyline>
          <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg> <span>Log out</span></a>

    </div><!-- az-header-right -->
  </div>
</header>
<div id="sidebarMenu" class="sidebar sidebar-fixed sidebar-components ps">
  <div class="sidebar-header">
    <a href="" id="mainMenuOpen"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
        <line x1="3" y1="12" x2="21" y2="12"></line>
        <line x1="3" y1="6" x2="21" y2="6"></line>
        <line x1="3" y1="18" x2="21" y2="18"></line>
      </svg></a>
    <h5>Components</h5>
    <a href="" id="sidebarMenuClose"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg></a>
  </div><!-- sidebar-header -->
  <div class="sidebar-body">
    <ul class="nav nav-aside">
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-label active"><a href="{{ route('dashboard')}}" class="nav-link {{ Route::is('dashboard') ? ' active' : ''}}"><i class="fa fa-home mr-3" aria-hidden="true"></i>Dashboard</a></li>
      @if (Auth::user()->can('view products'))
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-label active"><a href="{{route('products.index')}}" class="nav-link {{ Route::is('products.*') ? 'active' : '' }}"><i data-feather="shopping-bag"></i> <span>Products</span></a></li>
      @endif
      @if (Auth::user()->can('view batches'))
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-label"><a href="{{route('batches.index')}}" class="nav-link  {{ Route::is('batches.*') ? 'active' : '' }}"><i data-feather="box"></i> <span>Batches</span></a></li>
      @endif
      @if (Auth::user()->can('view qrcode'))
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item with-sub  {{ (Route::is('qrcodes.*')  || Route::is('bulkuploads.*') || Route::is('systemalerts*') ||  Route::is('reportlog.*') || Route::is('scanhistories.*')) ? 'show' : '' }}">
        <a onclick="toggleSubMenu(event, this)" style="font-family: IBM Plex Sans, sans-serif;" href="" class="nav-link nav-label {{ Route::is('Production') ? ' active' : ''}}"><i data-feather="archive"></i><span>Qr-Codes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><i class="fas fa-caret-down" style="margin:auto;font-size: small;"></i></a>
        <ul>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item  {{ Route::is('qrcodes.*') ? 'active' : '' }}"><a href="{{route('qrcodes.index')}}"><span>Qr-code</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{ Route::is('bulkuploads.*') ? 'active' : '' }}"><a href="{{route('bulkuploads.index')}}"> <span>Bulk Uploads</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{ Route::is('systemalerts*') ? 'active' : '' }}" ><a href="{{route('systemalerts')}}"> <span>System Alerts</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item  {{ Route::is('reportlog.*') ? 'active' : '' }}"><a href="{{route('reportlog.index')}}"> <span>Consumer Alerts</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item  {{ Route::is('scanhistories.*') ? 'active' : '' }}"><a href="{{route('scanhistories.index')}}"><span>Scan History</span></a></li>
        </ul>
      </li>
      @endif
      @if (Auth::user()->can('view production'))
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item with-sub {{ (Route::is('production-plants.*')  || Route::is('production-lines.*')) ? 'show' : '' }}">
        <a onclick="toggleSubMenu(event, this)" style="font-family: IBM Plex Sans, sans-serif;" href="" class="nav-link nav-label"><i data-feather="file-text"></i><span>Production &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><i class="fas fa-caret-down" style="margin:auto;font-size: small;"></i></a>
        <ul>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{Route::is('production-plants.*')?'active':''}}"><a href="{{route('production-plants.index')}}"> <span>Production-plants</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{Route::is('production-lines.*')?'active':''}}"><a href="{{route('production-lines.index')}}"> <span>Production-lines</span></a></li>
        </ul>
      </li>
      @endif
      @if (Auth::user()->can('view jobs'))
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-label active"><a href="{{route('jobs.index')}}" class="nav-link  {{ Route::is('jobs.*') ? 'active' : '' }}"><i data-feather="briefcase"></i>Jobs</a></li>
      @endif
      @if (Auth::user()->can('view printmodule'))
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-label active"><a href="{{route('print.index')}}" class="nav-link  {{ Route::is('print.*') ? 'active' : '' }}"><i data-feather="printer"></i>Print Module</a></li>
      @endif
      @if (Auth::user()->can('view aggregation'))
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item with-sub  {{ (Route::is('primary.*')  || Route::is('secondary.*') || Route::is('tertiary.*') || Route::is('pallete.*')) ? 'show' : '' }}">
        <a onclick="toggleSubMenu(event, this)" href="" class="nav-link nav-label"><i data-feather="database"></i><span>Aggregation &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><i class="fas fa-caret-down" style="margin:auto;font-size: small;"></i></a>
        <ul>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{ Route::is('primary.*') ? 'active' : '' }}"><a href="{{route('underdevelopment')}}"> <span>Primary</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{Route::is('secondary.*')?'active':''}}"><a href="{{route('underdevelopment')}}"> <span>Secondary</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{Route::is('tertiary.*')?'active':''}}"><a href="{{route('underdevelopment')}}"> <span>Tertiary</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{Route::is('pallete.*')?'active':''}}"><a href="{{route('underdevelopment')}}"> <span>Pallete</span></a></li>
        </ul>
      </li>
      @endif
      @if (Auth::user()->can('view supplychain'))
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item with-sub  {{ (Route::is('Roles.*')  || Route::is('User.*') || Route::is('Management.*') || Route::is('History.*')) ? 'show' : '' }}">
        <a onclick="toggleSubMenu(event, this)" style="font-family: IBM Plex Sans, sans-serif;" href="" class="nav-link nav-label"><i class="fas fa-warehouse mr-3"></i><span>Supply Chain &nbsp;</span><i class="fas fa-caret-down" style="margin:auto;font-size: small;"></i></a>
        <ul>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{ Route::is('Roles.*') ? 'active' : '' }}"><a href="{{route('underdevelopment')}}"> <span>Roles</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{Route::is('User.*')?'active':''}}"><a href="{{route('underdevelopment')}}"> <span>User</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{Route::is('Management.*')?'active':''}}"><a href="{{route('underdevelopment')}}"> <span>Management</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{Route::is('History.*')?'active':''}}"><a href="{{route('underdevelopment')}}"> <span>History</span></a></li>
        </ul>
      </li>
      @endif

      @if (Auth::user()->can('view user'))
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item with-sub {{ (Route::is('users.*')  || Route::is('roles.*') || Route::is('permissions.*') || Route::is('userlog.*')) ? 'show' : '' }}">
        <a onclick="toggleSubMenu(event, this)" style="font-family: IBM Plex Sans, sans-serif;" href="" class="nav-link nav-label {{ Route::is('Production') ? ' active' : ''}}"><i class="fas fa-user mr-2 ml-1"></i><span>&nbsp;&nbsp; Users &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><i class="fas fa-caret-down" style="margin:auto;font-size: small;"></i></a>
        <ul>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{ Route::is('users.*') ? 'active' : '' }}"><a href="{{route('users.index')}}"><span>User data</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item  {{ Route::is('roles.*') ? 'active' : '' }}"><a href="{{route('roles.index')}}"><span>Roles</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item  {{ Route::is('permissions.*') ? 'active' : '' }}"><a href="{{route('permissions.index')}}"> <span>Permissions</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{ Route::is('userlog.*') ? 'active' : '' }}"><a href="{{route('userlog.index')}}"><span>User Log</span></a></li>
        </ul>
      </li>
      @endif
    </ul>
  </div><!-- sidebar-body -->
  <div class="ps__rail-x" style="left: 0px; top: 0px;">
    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
  </div>
  <div class="ps__rail-y" style="top: 0px; right: 0px;">
    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
  </div>
</div>

<aside class="aside aside-fixed">
  <div class="">
    <img  src="{{tracesciimg('Maplejet-logo.jpg')}}" height="100px" width="100%" alt="Tracesci">
    <!-- <a href="" class="aside-menu-link">
      <i data-feather="menu"></i>
      <i data-feather="x"></i>
    </a> -->
  </div>
  <div class="aside-body">
    <div class="aside-loggedin">
      <div class="d-flex align-items-center justify-content-start">
        <a href="" class="avatar"><img src="{{tracesciimg('user_icon.png')}}" class="rounded-circle" alt="User"></a>
        <div class="aside-alert-link">
          <a href="" class="new" data-toggle="tooltip" title="You have 2 unread messages"><i data-feather="message-square"></i></a>
          <a href="" class="new" data-toggle="tooltip" title="You have 4 new notifications"><i data-feather="bell"></i></a>

            <a class="dropdown-item" href="{{route('logout1')}}"  data-toggle="tooltip" title="Sign out"><i data-feather="log-out"></i></a>
        </div>
      </div>
      <div class="aside-loggedin-user">
        <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
          <h6 class="tx-semibold mg-b-0">{{Auth::user()->name??""}}</h6>
          <i class="fas fa-user-doctor"></i>
        </a>
      </div>


      <!-- <li class="nav-item"><a href="{{route('logout')}}" class="nav-link"><i data-feather="log-out"></i> <span>Sign Out</span></a></li> -->


    </div><!-- aside-loggedin -->
    <ul class="nav nav-aside">
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-label active"><a href="{{ route('dashboard')}}" class="nav-link {{ Route::is('dashboard') ? ' active' : ''}}"><i class="fa fa-home mr-3" aria-hidden="true"></i>Dashboard</a></li>
      @if (Auth::user()->can('view products'))
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-label active"><a href="{{route('products.index')}}" class="nav-link {{ Route::is('products.*') ? 'active' : '' }}"><i data-feather="shopping-bag"></i> <span>Products</span></a></li>
      @endif
      @if (Auth::user()->can('view batches'))
      <li style="font-family: IBM Plex Sans, sans-serif;"class="nav-label"><a href="{{route('batches.index')}}" class="nav-link  {{ Route::is('batches.*') ? 'active' : '' }}"><i data-feather="box"></i> <span>Batches</span></a></li>
      @endif
      @if (Auth::user()->can('view qrcodes'))
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item with-sub  {{ (Route::is('qrcodes.*')  || Route::is('bulkuploads.*') || Route::is('reportlog.*') || Route::is('scanhistories.*')) ? 'show' : '' }}">
        <a style="font-family: IBM Plex Sans, sans-serif;" href="" class="nav-link nav-label {{ Route::is('Production') ? ' active' : ''}}"><i data-feather="archive"></i><span>Qr-Codes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;       </span><i class="fas fa-caret-down" style="margin:auto;font-size: small;"></i></a>
        <ul>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item  {{ Route::is('qrcodes.*') ? 'active' : '' }}"><a href="{{route('qrcodes.index')}}"><span>Qr-code</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{ Route::is('bulkuploads.*') ? 'active' : '' }}"><a href="{{route('bulkuploads.index')}}"> <span>Bulk Uploads</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item  {{ Route::is('reportlog.*') ? 'active' : '' }}"><a href="{{route('reportlog.index')}}"> <span>Consumer Feedback</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item  {{ Route::is('scanhistories.*') ? 'active' : '' }}"><a href="{{route('scanhistories.index')}}"><span>Scan Histories</span></a></li>
        </ul>
      </li>
      @endif
      @if (Auth::user()->can('view production'))
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item with-sub {{ (Route::is('production-plants.*')  || Route::is('production-lines.*')) ? 'show' : '' }}">
        <a style="font-family: IBM Plex Sans, sans-serif;" href="" class="nav-link nav-label"><i data-feather="file-text"></i><span>Production &nbsp;&nbsp;&nbsp;  </span><i class="fas fa-caret-down" style="margin:auto;font-size: small;"></i></a>
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
        <a  href="" class="nav-link nav-label"><i data-feather="database"></i><span>Aggregation</span><i class="fas fa-caret-down" style="margin:auto;font-size: small;"></i></a>
        <ul>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{ Route::is('primary.*') ? 'active' : '' }}"><a href="#"> <span>Primary</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{Route::is('secondary.*')?'active':''}}"><a href="#"> <span>Secondary</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{Route::is('tertiary.*')?'active':''}}"><a href="#"> <span>Tertiary</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{Route::is('pallete.*')?'active':''}}"><a href="#"> <span>Pallete</span></a></li>
        </ul>
      </li>
      @endif
      @if (Auth::user()->can('view supplychain'))
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item with-sub  {{ (Route::is('Roles.*')  || Route::is('User.*') || Route::is('Management.*') || Route::is('History.*')) ? 'show' : '' }}">
        <a style="font-family: IBM Plex Sans, sans-serif;" href="" class="nav-link nav-label"><i class="fas fa-warehouse mr-3"></i><span>Supply Chain</span><i class="fas fa-caret-down" style="margin:auto;font-size: small;"></i></a>
        <ul>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{ Route::is('Roles.*') ? 'active' : '' }}"><a href="#"> <span>Roles</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{Route::is('User.*')?'active':''}}"><a href="#"> <span>User</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{Route::is('Management.*')?'active':''}}"><a href="#"> <span>Management</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{Route::is('History.*')?'active':''}}"><a href="#"> <span>History</span></a></li>
        </ul>
      </li>
      @endif
     
      @if (Auth::user()->can('view user'))
      <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item with-sub {{ (Route::is('users.*')  || Route::is('roles.*') || Route::is('permissions.*') || Route::is('userlog.*')) ? 'show' : '' }}">
        <a style="font-family: IBM Plex Sans, sans-serif;"  href="" class="nav-link nav-label {{ Route::is('Production') ? ' active' : ''}}"><i class="fas fa-user mr-2 ml-1"></i><span>&nbsp;&nbsp; Users &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    </span><i class="fas fa-caret-down" style="margin:auto;font-size: small;"></i></a>
        <ul>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{ Route::is('users.*') ? 'active' : '' }}"><a href="{{route('users.index')}}"><span>User data</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item  {{ Route::is('roles.*') ? 'active' : '' }}"><a href="{{route('roles.index')}}"><span>Roles</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item  {{ Route::is('permissions.*') ? 'active' : '' }}"><a href="{{route('permissions.index')}}"> <span>Permissions</span></a></li>
          <li style="font-family: IBM Plex Sans, sans-serif;" class="nav-item {{ Route::is('userlog.*') ? 'active' : '' }}"><a href="{{route('userlog.index')}}"><span>User Log</span></a></li>
        </ul>
      </li>
      @endif
    </ul>
  </div>
</aside>
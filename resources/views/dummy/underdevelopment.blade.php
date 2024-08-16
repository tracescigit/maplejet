@extends('dummy.app_new')

@section('content')
<div class="content content-fixed content-auth-alt">
    <div class="container ht-100p tx-center">
        <div class="ht-100p d-flex flex-column align-items-center justify-content-center">
            <div class="wd-70p wd-sm-250 wd-lg-300 mg-b-15"><img src="{{tracesciimg('development.jpg')}}" class="img-fluid" alt=""></div>
            <h1 class="tx-color-01 tx-24 tx-sm-32 tx-lg-36 mg-xl-b-5">Page Under Development...</h1>
            <h5 class="tx-16 tx-sm-18 tx-lg-20 tx-normal mg-b-20"> The service is not accessible.</h5>
            <p class="tx-color-03 mg-b-30">You can access this page soon..</p>
        </div>
    </div><!-- container -->
</div>
@endsection
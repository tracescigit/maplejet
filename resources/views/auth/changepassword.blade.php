@extends('dummy.app_new')

@section('content')
<div class="content content-fixed content-auth-alt">
    <div class="container ht-100p tx-center">
        <div class="ht-100p d-flex flex-column align-items-center justify-content-center">
            <div class="wd-70p wd-sm-250 wd-lg-300 mg-b-15"><img src="{{tracesciimg('logout.jpg')}}" class="img-fluid" alt=""></div>
            <h1 class="tx-color-01 tx-24 tx-sm-32 tx-lg-36 mg-xl-b-5">New Pass </h1>
            <h5 class="tx-16 tx-sm-18 tx-lg-20 tx-normal mg-b-20">Thankyou for Visiting ..</h5>
            <p class="tx-color-03 mg-b-30">Click on the Button Below to <code>LOG IN</code>  .</p>
            <div class="mg-b-40"><a href="{{route('login')}}" class="btn btn-custom bd-2 pd-x-30">LOG IN</a></div>
        </div>
    </div><!-- container -->
</div>
@endsection
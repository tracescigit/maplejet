<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div id="form_wrapper">
        <div id="form_left">
            <img src="{{tracesciimg('login_picture.jpg')}}" alt="">
            <img class="logo-tracesci mx-auto" src="{{tracesciimg('logo.png')}}" alt="computer icon">
            <!-- <img src="{{tracesciimg('old_logo2.jpg')}}" alt="image"> -->
        </div>

        
        <header class="navbar navbar-header navbar-header-fixed">

<div class="navbar-brand">
  <a href="index.html" class="df-logo">maple<span>jet</span></a>
</div><!-- navbar-brand -->


</header><!-- navbar -->

<div class="content content-fixed content-auth">
<div class="container">
  <div class="media align-items-stretch justify-content-center ht-100p pos-relative">
    <div class="media-body align-items-center d-none d-lg-flex">
      <div class="mx-wd-700">
        <img src="https://maplejet.tracesci.in/assets/img/login_picture.jpg" class="img-fluid" alt="">
      </div>
     
    </div><!-- media-body -->
    <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
      <div class="wd-100p">
        <h3 class="tx-color-01 mg-b-5">Sign In</h3>
        <p class="tx-color-03 tx-16 mg-b-40">Welcome back! Please signin to continue.</p>

        <div class="form-group">
          <label>Email address</label>
          <input type="email" class="form-control" placeholder="yourname@yourmail.com">
        </div>
        <div class="form-group">
          <div class="d-flex justify-content-between mg-b-5">
            <label class="mg-b-0-f">Password</label>
            <a href="forgotpassword.html" class="tx-13">Forgot password?</a>
          </div>
          <input type="password" class="form-control" placeholder="Enter your password">
        </div>
        <button class="btn btn-brand-02 btn-block">Sign In</button>
        <div class="divider-text">--</div>
      
        <div class="tx-13 mg-t-20 tx-center">powered by <a href="https://tracesci.in">tracesci</a></div>
      </div>
    </div><!-- sign-wrapper -->
  </div><!-- media -->
</div><!-- container -->
</div><!-- content -->

    </div>

</x-guest-layout>
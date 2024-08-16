@extends('dummy.app_new')

@section('content')


<style>
  /* Basic reset */
  body,
  html {
    margin: 0;
    padding: 0;
    height: 100%;
  }

  /* Wrapper to handle full height and Flexbox layout */
  .wrapper {
    display: flex;
    flex-direction: column;
    min-height: 90vh;
    /* Full viewport height */
  }

  /* Main content area */
  .content {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
  }

  /* Styling for the footer */
  footer {
    background-color: #f8f9fa;
    padding: 10px;
    text-align: center;
    border-top: 1px solid #dee2e6;
  }
</style>

<!-- <div class="content content-fixed content-auth-alt">
      <div class="container d-flex justify-content-center">
        <div class="mx-wd-300 wd-sm-450  d-flex flex-column align-items-center justify-content-center">
          <div class="wd-80p wd-sm-300 mg-b-15"><img src="../../assets/img/img18.png" class="img-fluid" alt=""></div>
          <h4 class="tx-20 tx-sm-24">Reset your password</h4>
          <p class="tx-color-03 mg-b-30 tx-center">Enter your username or email address and we will send you a link to reset your password.</p>
          <div class="wd-100p d-flex flex-column flex-sm-row mg-b-40">
            <input type="text" class="form-control wd-sm-250 flex-fill" placeholder="Enter username or email address">
            <button class="btn btn-brand-02 mg-sm-l-10 mg-t-10 mg-sm-t-0">Reset Password</button>
          </div>

        </div>
      </div>
    </div> -->
<div class="wrapper">


  <main class="content">
    <div class="content content-fixed content-auth-alt">
      <div class="container d-flex justify-content-center">
        <div class="mx-wd-300 wd-sm-450  d-flex flex-column align-items-center justify-content-center">
          <div class="wd-80p wd-sm-300 mg-b-15"><img src="{{tracesciimg('forgotpasswordimg.png')}}" class="img-fluid" alt=""></div>
          @if(session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
          @endif
          @if($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          <h4 class="tx-20 tx-sm-24">Reset your password</h4>
          <p class="tx-color-03 mg-b-30 tx-center">Enter your username or email address and we will send you a link to reset your password.</p>
          <div class="wd-100p d-flex flex-column flex-sm-row mg-b-40 justify-content-center">
            <form method="POST" action="{{ route('password.send') }}">
              @csrf
              <div class="form-group d-flex align-items-center">
                <input type="text" class="form-control wd-sm-250 flex-fill" name="email" placeholder="Enter username or email" required>


              </div>
              <button type="submit" class="btn btn-brand-02 btn-custom mg-sm-l-10 mg-t-10 mg-sm-t-0">Reset Password</button>

              <a href="{{ route('login') }}" class="btn btn-secondary mg-sm-l-10 mg-t-10 mg-sm-t-0">
                Back
              </a>
            </form>
          </div>

        </div>
      </div>
    </div>
  </main>


</div>
@endsection
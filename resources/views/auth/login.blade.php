@extends('dummy.app_new')

@section('content')
<style>
.forgot-password-link {
        color: inherit; /* Use the current text color or specify a default color */
        text-decoration: none; /* Remove underline */
    }

    .forgot-password-link:hover {
        color: blue; /* Change color to blue on hover */
        text-decoration: underline; /* Optional: Add underline on hover */
    }
    </style>
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />



    <div class="content content-fixed content-auth">
        <div class="container">
            <div class="media align-items-stretch justify-content-center ht-100p pos-relative">
                <div class="media-body align-items-center d-none d-lg-flex">
                    <div class="mx-wd-600">
                        <img src="{{tracesciimg('loginimage.png')}}" class="img-fluid" alt="">
                        <img class="logo-tracesci" src="{{tracesciimg('logo.png')}}" style="margin-left:175px;">
                    </div>

                </div><!-- media-body -->
                <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60 " style="margin-top: 90px;">
                    <div class="wd-100p">
                        <h3 class="tx-color-01 mg-b-5">Sign In</h3>
                        <p class="tx-color-03 tx-16 mg-b-40">Welcome back! Please Sign In to continue.</p>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label>Email address</label>
                                <input type="email" class="form-control" placeholder="name@email.com" id="email" value="{{ old('email') }}" type="email" name="email" required="required" autocomplete="username">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between mg-b-5">
                                    <label class="mg-b-0-f">Password</label>
                                    @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-password-link tx-13"> {{ __('Forgot password?') }}</a>
                                    @endif
                                </div>
                                <input type="password" class="form-control" placeholder="Enter your password" id="password" value="{{ old('password') }}" type="password" name="password" required="required" autocomplete="current-password">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>

                            <button class="btn btn-brand-02 btn-block btn-custom">Sign In</button>

                            
                           
                        </form>
                    </div>

                </div><!-- sign-wrapper -->
            </div><!-- media -->
        </div><!-- container -->
    </div><!-- content -->

</x-guest-layout>
@endsection



<!-- <div id="form_wrapper">
        <div id="form_left">
            <img src="{{tracesciimg('login_picture.jpg')}}" alt="">
            <img class="logo-tracesci mx-auto" src="{{tracesciimg('logo.png')}}" alt="computer icon">
            <img src="{{tracesciimg('old_logo2.jpg')}}" alt="image"> 
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
           
            <div id="form_right">
                <div style="font-size: xx-large; font-weight:900;">SIGN IN</div>
                <div class="">
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="email">
                        <h3 style="margin-top:45px;">Email:</h3>

                    </label>
                    <input style="hover:#e3e3e3"  class="input_container border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm input_field" id="email" type="email" name="email" required="required" autocomplete="username">
                </div>
               
                <div class="">
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="password">
                        <h3 style="margin:10px;">Password:</h3>
                    </label>

        Password Input -->
        <!-- <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                <h3 style="margin: 10px;">Password:</h3>
            </label>
            <input 
                id="password" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password" 
                class="input_container border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm input_field"
                placeholder="Enter your password"
            >
            @error('password')
                <p class="text-red-500 text-sm mt-1" style="color:red">{{ $message }}</p>
            @enderror
        </div>

       
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center" style="margin-left: 10px;">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    name="remember" 
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                >
                <span class="text-sm text-gray-600 dark:text-gray-400" style="margin-left: 10px;">{{ __('Remember me') }}</span>
            </label>
        </div>

       
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a 
                    href="{{ route('password.request') }}" 
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    style="margin-left: 10px;"
                >
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

      
        <div class="mt-4">
            <x-primary-button id="input_submit">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </div>
</form>



    </div> --> 
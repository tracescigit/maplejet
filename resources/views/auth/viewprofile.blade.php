@extends('dummy.app_new')

@section('content')
<style>
    body {
        color: #69707a;
    }

    .img-account-profile {
        height: 10rem;
    }

    .rounded-circle {
        border-radius: 50% !important;
    }

    .card {
        box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
    }

    .card .card-header {
        font-weight: 500;
    }

    .card-header:first-child {
        border-radius: 0.35rem 0.35rem 0 0;
    }

    .card-header {
        padding: 1rem 1.35rem;
        margin-bottom: 0;
        background-color: rgba(33, 40, 50, 0.03);
        border-bottom: 1px solid rgba(33, 40, 50, 0.125);
    }

    .form-control,
    .dataTable-input {
        display: block;
        width: 100%;
        padding: 0.875rem 1.125rem;
        font-size: 0.875rem;
        font-weight: 400;
        line-height: 1;
        color: #69707a;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #c5ccd6;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0.35rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .nav-borders .nav-link.active {
        color: #0061f2;
        border-bottom-color: #0061f2;
    }

    .nav-borders .nav-link {
        color: #69707a;
        border-bottom-width: 0.125rem;
        border-bottom-style: solid;
        border-bottom-color: transparent;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        padding-left: 0;
        padding-right: 0;
        margin-left: 1rem;
        margin-right: 1rem;
    }
</style>
<div class="content content-components">
    <div class="container">
        <!-- Account page navigation-->

        <hr class="mt-0 mb-4">
        <div class="row">

            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <!-- Profile picture image-->
                        <img class="img-account-profile rounded-circle mb-2" src="{{tracesciimg('profile_pic.jpg')}}" height="30%" alt="">
                        <!-- Profile picture help block-->
                        <div class=" tx-30 font-italic mb-4">{{ Auth::user()->name ?? "" }}</div>


                    </div>
                    <div class="card-header">User Details</div>
                    <div class="card-body">
                        <form>
                            <!-- Form Group (username)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputUsername">Username</label>
                                <hr>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputFirstName">First name</label>
                                    <p>{{$user->name}}</p>
                                    <hr>
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputLastName">Last name</label>
                                    <p>--</p>
                                    <hr>
                                </div>
                            </div>
                            <!-- Form Row        -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (organization name)-->
                                <!-- <div class="col-md-6">
                                    <label class="small mb-1" for="inputOrgName">Organization name</label>
                                    <hr>
                                </div> -->
                                <!-- Form Group (location)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputLocation">Location</label>
                                    <hr>
                                </div>
                            </div>
                            <!-- Form Group (email address)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                <p>{{$user->email}}</p>
                                <hr>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPhone">Phone number</label>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPhone">Status</label>
                                    <p class="{{ $user->status == 'Active' ? 'text-success' : 'text-danger' }}">
                                        {{ $user->status }}
                                    </p>

                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPhone">Profile Created At</label>
                                    <p>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}
                                        </td>
                                    </p>

                                    <hr>

                                    <!-- Form Group (birthday)-->
                                    <!-- <div class="col-md-6">
                                    <label class="small mb-1" for="inputBirthday">Birthday</label>
                                    <hr>
                                </div> -->
                                </div>
                                <!-- Save changes button-->

                        </form>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary justify-content-center ">
                                Close
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
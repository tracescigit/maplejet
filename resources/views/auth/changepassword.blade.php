@extends('dummy.app_new')

@section('content')
<div class="content content-fixed content-auth-alt">
    <div class="container ht-100p tx-center">
        <div class="ht-100p d-flex flex-column align-items-center justify-content-center">
            <div class="wd-70p wd-sm-250 wd-lg-300 mg-b-15">
                <img src="{{tracesciimg('changepassword.jpg')}}" class="img-fluid" alt="">
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <h1 class="tx-color-01 tx-24 tx-sm-32 tx-lg-36 mg-xl-b-20">Change Password</h1>
            <form id="passwordForm" method="POST">
                @csrf
                <div>
                    New Password: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="password" id="newPassword" name="password" class="tx-normal" placeholder="Enter Password" required>
                    <small class="form-text  mg-b-20">Password should be at least 8 digits and must contain atleast one special characters and one alphabets</small>
                </div>
                <div>
                    Confirm Password: &nbsp;
                    <input type="password" id="confirmPassword" class="tx-normal mg-b-20" placeholder="Confirm Password" required>
                </div>
                <div id="error-message" class="mg-b-20" style="color: red; display: none;">Passwords does not match! </div>
                <div>
                    <button class="btn-custom mg-b-20">Submit</button>
                </div>
            </form>
        </div>
    </div><!-- container -->
</div>


<script>
    $(document).ready(function() {
        $('#passwordForm').submit(function(event) {
            var newPassword = document.getElementById('newPassword').value;
            var confirmPassword = document.getElementById('confirmPassword').value;
            var errorMessage = document.getElementById('error-message');

            event.preventDefault();
            if (newPassword !== confirmPassword) {
                // Prevent form submission

                // Show error message
                errorMessage.style.display = 'block';
            } else {
                // Hide error message if passwords match
                errorMessage.style.display = 'none';
                var formData = $(this).serialize();
                console.log(formdata);
                $.ajax({
                    type: 'POST',
                    url: "{{route('changepassword')}}",
                    data: formData,
                    success: function(response) {

                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            };
        });
    });
</script>
@endsection
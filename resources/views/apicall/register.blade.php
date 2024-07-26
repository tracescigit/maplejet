@extends('layout.apicall')
@section('content')
<div class="pcoded-main-container" style="margin-left: 0px;">
    <div class="pcoded-wrapper container" style="width:auto !important;">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div wire:id="D9UCbDO33jkKTWXcs6KA">
                            <div class="row">
                                <div class="col-md-5 mb-4">
                                    <h2>User Registration</h2>
                                    @if(isset($status))
                                    <div class="alert alert-danger">
                                        {{ $status }}
                                    </div>
                                    @endif
                                    @if(session('status'))
                                    <form id="phoneNumberForm" method="GET" class="mt-4" style="display:none;">
                                        @else
                                        <form id="phoneNumberForm" method="GET" class="mt-4">
                                            @endif
                                            <div class="form-group">
                                                <label for="phone_number">Phone Number:</label>
                                                <input type="text" id="phone_number" name="phone_number" class="form-control" required>
                                                <input type="hidden" name="qrcode_id" value="{{$product_id_ver->id}}" id="qrcode_id">
                                            </div>
                                            <button type="submit" id="" class="btn btn-primary">Send OTP</button>
                                        </form>

                                        @if(session('status'))
                                        <form id="otpVerificationForm" method="GET" action="{{ route('generate.qr', ['product_id' => $product_id, 'qrcode' => $qrcode]) }}" class="mt-4">
                                            @else
                                            <form id="otpVerificationForm" style="display:none;" method="GET" action="{{ route('generate.qr', ['product_id' => $product_id, 'qrcode' => $qrcode]) }}" class="mt-4">
                                                @endif
                                                <h2>Verify OTP</h2>
                                                <div class="form-group">
                                                    <label for="otp">OTP:</label>
                                                    <input type="text" id="otp" name="otp" class="form-control" pattern="[0-9]{6}" title="OTP must be of six digits" required>
                                                    <input type="hidden" id="phone_number_sub" name="phone_number">
                                                    @if(session('status'))
                                                    <div id="statusMessage" class="alert alert-success mt-2" style="background-color:#34eb86">{{session('status')}}</div>
                                                    @endif
                                                </div>
                                                <button type="submit" class="btn btn-primary">Verify OTP</button>
                                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var phoneNumber;
    $("#phoneNumberForm").submit(function(event) {
        event.preventDefault();
        phoneNumber = $("#phone_number").val();
        $('#phone_number_sub').val(phoneNumber);
        $('#phoneNumberForm').hide();
        $('#otpVerificationForm').show();
    });
    // $("#otpForm").submit(function(event) {
    //     event.preventDefault();
    //     alert()
    //     var otp = $("#otp").val();
    //     var route = '{{route("register.mob")}}';
    //     $.ajax({
    //         url: route,
    //         type: 'GET',
    //         contentType: 'application/json',
    //         dataType: 'json',
    //         data: {
    //             phone_number: phoneNumber,
    //             otp: otp,
    //             qrcode_id: qrcode_id
    //         },
    //         success: function(data) {},
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             console.error('Error:', errorThrown);
    //         }
    //     });
    // });
</script>
@endsection
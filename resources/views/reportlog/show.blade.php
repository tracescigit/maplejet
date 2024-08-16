@extends('dummy.app_new')

@section('content')
<style>
    .btn-custom {
        background: #b70a9b !important;
        color: white;
        border-radius: 5px;
        padding: 8px 16px;
        font-size: 14px;
        border: none;
        transition: background-color 0.3s ease;
    }

    .card {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }
    #map {
            height: 500px;
            width: 100%;
        }
</style>
<div class="content content-components">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="container">
                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10 font-weight-bolder">View Details</h4>
                        <p class="mg-b-30">Use this page to <code style="color:#e300be;">View</code> Report Details .</p>
                        <hr>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Product Name:</label>
                                <p> {{$reportlog->product}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Batch Name:</label>
                                <p>{{$reportlog->batch}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="company_name">City:</label>
                                <p>{{$reportlog->city}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="gtin">IP Address</label>
                                <p>{{$reportlog->ip}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="gtin">Latitude & Longitude :</label>
                                <p>{{$reportlog->lat.' and '.$reportlog->long}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="image_preview">Report Reason:</label>
                                <p>{{$reportlog->report_reason}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="label_image_preview">Mobile:</label>
                                <p>{{$reportlog->mobile}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-bold" for="description">Description:</label>
                                <p>{!!$reportlog->description!!}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-12">
                                
                                    
                                <div class="card-body mb-3">

                                    <div class="col-12">
                                        <div id="map"></div>
                                    </div>

                                </div>
                            </div><!-- row -->
                        </div><!-- container -->
                        <div class="col-md-12">
                        <a href="{{ route('reportlog.index') }}" class="btn btn-secondary float-left">
                        Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDADniYJASHh9Fbu-PagV7vFtjM9bJx9dU&callback=initMap">
</script>
<script>
        function initMap() {
             // Assuming these values are being rendered correctly
             var latitude = parseFloat('{{ $reportlog->lat }}');
            var longitude = parseFloat('{{ $reportlog->long }}');
            // Create a map centered on a specific location
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: { lat: latitude, lng: longitude } // Change this to your desired location
            });


           

            // Add markers
            var locations = [
                { lat: latitude, lng: longitude, title: "Location 1" },
            ];

            for (var i = 0; i < locations.length; i++) {
                var marker = new google.maps.Marker({
                    position: { lat: locations[i].lat, lng: locations[i].lng },
                    map: map,
                    title: locations[i].title
                });
            }
        }

        // Initialize the map when the page loads
        window.onload = initMap;
    </script>
    @endsection
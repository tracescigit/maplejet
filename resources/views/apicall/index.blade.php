@extends('layout.apicall')
@section('content')
<style>
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }

    #description {
        border: 2px solid #ccc;
        /* Border color */
        padding: 10px;
        /* Padding inside the text area */
        border-radius: 5px;
        /* Rounded corners */
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        resize: vertical;
        /* Allow vertical resize only */
    }

    .card-header {
        background: linear-gradient(45deg, #7008778a 0%, #ec0037a1 100%);
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<div class="card">
    <div class="card-header bg-primary text-white text-center">
        <h2 class="mb-4">{{$product_id_ver->brand}}</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{$media_base_url.$product_id_ver->image}}" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{$media_base_url.$product_id_ver->label}}" alt="Second slide">
                        </div>
                    </div>
                    <!-- Controls -->
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        @if(session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                        @endif
                        <h2 class="card-title"><i class="fas fa-check-circle text-success"></i> {{$product_id_ver->name}}</h2>
                        <ul class="nav nav-tabs" id="productTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Product Information</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="productTabsContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <p class="mb-2"><strong>{{$genuine}}</strong> <i class="feather icon-check-circle text-success"></i></p>
                                <p class="mb-2"><strong>Brand Name:</strong> {{$product_id_ver->brand ?? ""}}</p>
                                <p class="mb-2"><strong>Batch No.:</strong> {{$product_id_ver->code ?? ""}}</p>
                                <p class="mb-2"><strong>Date of Manufacturing:</strong> {{date('d-m-Y', strtotime($product_id_ver->mfg_date))}}</p>
                                <p class="mb-2"><strong>Date of Expiry:</strong> {{date('d-m-Y', strtotime($product_id_ver->exp_date))}}</p>
                                <strong>Description:</strong>
                                <p>{!! $product_id_ver->description !!}</p>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mt-3 float-right" data-toggle="modal" data-target="#reportModal">
                            Report Product Issue
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Modal -->
<!-- Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content shadow-lg border-0 rounded-lg">
            <div class="modal-header bg-info text-white rounded-top">
                <h5 class="modal-title" id="reportModalLabel">Report Product Issue</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="issueform" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="issue" class="font-weight-bold">Select Issue</label>
                        <select class="form-control border-info" id="issue" name="issue">
                            <option value="">Please select</option>
                            <option value="Damaged Product">Damaged Product</option>
                            <option value="Suspicious Product">Suspicious Product</option>
                            <option value="Change in Taste">Change in Taste</option>
                            <option value="Wrong Product">Wrong Product</option>
                            <option value="Retailer Issue">Retailer Issue</option>
                            <option value="Product Details Mismatch">Product Details Mismatch</option>
                            <option value="Label Altered">Label Altered</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description_form" class="font-weight-bold">Describe Your Issue</label>
                        <textarea class="form-control border-info" id="description_form" name="description" rows="4" placeholder="Provide a detailed description of the issue"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="images" class="font-weight-bold">Upload Image</label>
                        <input type="file" class="form-control-file border-info" id="images" name="images[]" accept="image/*">
                    </div>
                    <div class="form-group text-right">
                        <button type="button" id="submit-button" class="btn btn-info text-white">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function getGeolocation(callback) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    callback(position.coords.latitude, position.coords.longitude);
                },
                function(error) {
                    console.error(error);
                    callback(null, null);
                }
            );
        } else {
            console.error("Geolocation is not supported by this browser.");
            callback(null, null);
        }
    }
    $(document).ready(function() {
        $('#submit-button').on('click', function(event) {
            event.preventDefault();
            let lat, long;
            $('#lat').val('');
            $('#long').val('');
            getGeolocation(function(lat, long) {
                if (lat && long) {
                    $('#lat').val(lat);
                    $('#long').val(long);
                }
                var formData = new FormData();
                var images = document.querySelectorAll('input[type="file"][name="images[]"]');
                for (var i = 0; i < images.length; i++) {
                    if (images[i].files.length > 0) {
                        formData.append('images[]', images[i].files[0]);
                    }
                }
                let issue = $('#issue').val();
                let description = $('#description_form').val();
                let token = $('meta[name="csrf-token"]').attr('content');
                let ip = '{{$clientIp ??''}}';
                let url = '{{ request()->url() }}';
                let product = '{{ $product_id_ver->name }}';
                let batch = '{{ $product_id_ver->code }}';

                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                formData.append('issue', $('#issue').val());
                formData.append('description', $('#description_form').val());
                formData.append('lat', lat);
                formData.append('long', long);
                formData.append('long', long);
                formData.append('url', url);
                formData.append('product_name', product);
                formData.append('batch', batch);
                formData.append('ip', ip);
                $.ajax({
                    url: '{{ route("submitissue") }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('body').prepend('<div class="alert alert-success" id="flash-message">Issue submitted successfully!</div>');
                            setTimeout(function() {
                                $('#flash-message').fadeOut('slow', function() {
                                    $(this).remove();
                                });
                            }, 10000); // 10 seconds
                            $('#issueform')[0].reset(); // Reset the form
                            $('.close').click();
                        } else {
                            alert('Failed to submit the issue.');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        console.log('An error occurred. Please try again.');
                    }
                });
            });

        });
    });

    // Hide the flash message after 10 seconds
    setTimeout(function() {
        var flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.style.display = 'none';
        }
    }, 10000);
</script>
<script>
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();

        reader.onload = function() {
            var img = document.createElement('img');
            img.src = reader.result;
            img.style.marginRight = '10px'; // Adding some spacing between images
            img.style.maxWidth = '100px'; // Limiting max width for preview images
            img.style.maxHeight = '100px'; // Limiting max height for preview images

            var deleteButton = document.createElement('button');
            deleteButton.textContent = '-';
            deleteButton.onclick = function() {
                var container = input.parentNode;
                container.removeChild(input);
                container.removeChild(img);
                container.removeChild(deleteButton);
            };

            var container = document.getElementById('preview');
            container.appendChild(img);
            container.appendChild(deleteButton);
        };

        reader.readAsDataURL(input.files[0]);
    }

    function addImage() {
        var input = document.createElement('input');
        input.type = 'file';
        input.name = 'images[]';
        input.accept = 'image/*';
        input.onchange = previewImage;
        input.className = 'btn';
        input.style.backgroundColor = '#F8F8F8';
        input.style.display = 'inline-block'; // Ensuring the input is inline

        var plusButton = document.createElement('button');
        plusButton.type = 'button';
        plusButton.textContent = '+';
        plusButton.onclick = addImage;

        var minusButton = document.createElement('button');
        minusButton.type = 'button';
        minusButton.textContent = '-';
        minusButton.onclick = function() {
            var container = input.parentNode;
            container.removeChild(input);
            container.removeChild(plusButton);
            container.removeChild(minusButton);
        };

        var container = document.getElementById('image-container');
        container.appendChild(input);
        container.appendChild(plusButton);
        container.appendChild(minusButton);
    }

    function submitForm() {
        var images = document.getElementsByName('images[]');
        var formData = new FormData();
        console.log(images);
        for (var i = 0; i < images.length; i++) {
            formData.append('images[]', images[i].files[0]);
        }
    }
</script>
</script>
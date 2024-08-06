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

    .nav-link-active {
        color: #ff209f !important;
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
            <div style="height:50%;width:50%; margin:auto;" data-label="Product Images" class="df-example">
                <div id="carouselExample3" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleControls" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExample3" data-slide-to="1"></li>
                        <li data-target="#carouselExample3" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{$media_base_url.$product_id_ver->image}}" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="{{$media_base_url.$product_id_ver->label}}" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExample3" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"><i data-feather="chevron-left"></i></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExample3" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"><i data-feather="chevron-right"></i></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div><!-- df-example -->
            </br>


            <div data-label="Details" class="df-example">
                <div class="alert alert-solid alert-success d-flex justify-content-center mt-3 mx-auto" style="max-width: 30%;font-weight:bold;" role="alert">Genuine Product</div>
                <ul class="nav nav-tabs nav-justified" id="myTab3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="font-weight: bold;font-family:'Times New Roman', Times, serif;" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="font-weight: bold;font-family:'Times New Roman', Times, serif;" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="font-weight: bold;font-family:'Times New Roman', Times, serif;" id="contact-tab3" data-toggle="tab" href="#contact3" role="tab" aria-controls="contact" aria-selected="false">Journey</a>
                    </li>
                </ul>
                <div class="tab-content bd bd-gray-300 bd-t-0 pd-20" id="myTabContent3">
                    <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">


                        <div class="table-responsive mt-3">
                            <table class="table table-hover mg-b-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Generic Name of drug</th>
                                        <th scope="col">Cough Syrup</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <th scope="row">Brand</th>
                                        <td>New Syrup</td>

                                    </tr>
                                    <tr>
                                        <th scope="row">Unique Code</th>
                                        <td>GTIN72472547254754</td>

                                    </tr>
                                    <tr>
                                        <th scope="row">Batch No.</th>
                                        <td>2400001</td>

                                    </tr>

                                    <tr>
                                        <th scope="row">Mfg. date</th>
                                        <td>NOV.2024</td>

                                    </tr>
                                    <tr>
                                        <th scope="row">Exp. date</th>
                                        <td class="tx-danger">DEC.2026</td>

                                    </tr>
                                    <tr>
                                        <th scope="row">Price</th>
                                        <td>$112.00</td>

                                    </tr>

                                </tbody>
                            </table>
                        </div><!-- table-responsive -->
                    </div>
                    <div class="tab-pane fade mt-3 mx-auto" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                        <h6>Composition</h6>
                        <p class="mg-b-0">Paracetamol 500mg </br>Ibu Brufen 100mg.</p></br>
                        <h6>Manufacturer Name</h6>
                        <p class="mg-b-0">ABC Pharma Ltd., Delhi</p></br>

                        <h6>Mfg. License No.</h6>
                        <p class="mg-b-0">FYTR77465HG</p></br>

                        <h6>Storage Conditions</h6>
                        <p class="mg-b-0">Store at cool place.</p></br>


                    </div>
                    <div class="tab-pane fade mt-3" id="contact3" role="tabpanel" aria-labelledby="contact-tab3">
                        <div class="card">
                            <ul class="activity tx-13">
                                <li class="activity-item">
                                    <div class="activity-icon bg-primary-light tx-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                    </div>
                                    <div class="activity-body">
                                        <p class="mg-b-2"><strong>ABC Pharama Plant, Mumbai (Manufacturer)</strong></p>
                                        <small class="tx-indigo">Check Out: 2024-12-03 11:11:11</small>
                                    </div><!-- activity-body -->
                                </li><!-- activity-item -->
                                <li class="activity-item">
                                    <div class="activity-icon bg-success-light tx-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-paperclip mt-3">
                                            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                        </svg>
                                    </div>
                                    <div class="activity-body ">
                                        <p class="mg-b-2 "><strong>ABC Pharma, Delhi (Warehouse)</strong></p>
                                        <small class="tx-pink">Check In: 2024-12-04 12:11:11</br></small>
                                        <small class="tx-indigo">Check Out: 2024-12-06 14:11:11</small>
                                    </div><!-- activity-body -->
                                </li><!-- activity-item -->
                                <li class="activity-item">
                                    <div class="activity-icon bg-warning-light tx-orange">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share">
                                            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                            <polyline points="16 6 12 2 8 6"></polyline>
                                            <line x1="12" y1="2" x2="12" y2="15"></line>
                                        </svg>
                                    </div>
                                    <div class="activity-body">
                                        <p class="mg-b-2"><strong>Pharmaline Medical, Gurgaon (Distributor)</strong></p>
                                        <small class="tx-pink">Check In: 2024-12-08 12:11:11</br></small>
                                        <small class="tx-indigo">Check Out: 2024-12-09 14:11:11</small>
                                    </div><!-- activity-body -->
                                </li><!-- activity-item -->
                                <li class="activity-item">
                                    <div class="activity-icon bg-pink-light tx-pink">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="8" x2="12" y2="16"></line>
                                            <line x1="8" y1="12" x2="16" y2="12"></line>
                                        </svg>
                                    </div>
                                    <div class="activity-body">
                                        <p class="mg-b-2"><strong>Sharma Agencies, Gurgaon (Agency)</strong></p>
                                        <small class="tx-pink">Check In: 2024-12-10 12:11:11</br></small>
                                        <small class="tx-indigo">Check Out: 2024-12-14 14:11:11</small>
                                    </div><!-- activity-body -->
                                </li><!-- activity-item -->
                                <li class="activity-item">
                                    <div class="activity-icon bg-indigo-light tx-indigo">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
                                            <circle cx="12" cy="12" r="3"></circle>
                                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                        </svg>
                                    </div>
                                    <div class="activity-body">
                                        <p class="mg-b-2"><strong>Metri Chemist, Gurgaon (Retailor)</strong></p>
                                        <small class="tx-pink">Check In: 2024-12-15 12:11:11</br></small>
                                    </div><!-- activity-body -->
                                </li><!-- activity-item -->
                            </ul>

                        </div>
                    </div>
                </div>


                <div class="mg-t-5 d-flex justify-content-center">

                    <button type="button" class="btn  btn-xs btn-outline-danger">Report issue?</button>
                </div><!-- navbar-right -->

            </div><!-- df-example -->




            <footer class="content-footer">
                <div class="d-flex justify-content-center">
                    <span>Powered by <a href="http://tracesci.in">tracesci</a></span>
                </div>

            </footer><!-- content-footer -->
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
                let ip = '{{$clientIp ??'
                '}}';
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
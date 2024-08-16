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
</style>
<div class="content content-components">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="container">

                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bolder;">Product Details</h4>
                        <p class="mg-b-30">Use this page to <code style="color:#e300be;">View</code> product Details.</p>
                        <hr>
                    </div>


                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Product Name:</label>
                                <p> {{$product->name}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Product Brand:</label>
                                <p>{{$product->name}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="company_name">Company Name:</label>
                                <p>{{$product->company_name}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="gtin">GTIN / Product Code:</label>
                                <p>{{$product->gtin}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="image_preview">Image Preview:</label><br>
                                <img src="{{($product->web_url.'/'. $product->image) }}" alt="Product Image" style="max-width: 200px;">
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="label_image_preview">Label Image Preview:</label><br>
                                <img src="{{($product->web_url.'/'. $product->label) }}" alt="Label Image" style="max-width: 200px;">
                                <hr>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-bold" for="description">Description:</label>
                                <p>{!!$product->description!!}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="font-weight-bold" for="status">Status:</label>
                                <p>@if($product->status == 'Active')
                                    <span class="tx-10 badge badge-success">Active</span>
                                    @else
                                    <span class="tx-10 badge badge-danger">Inactive</span>
                                    @endif
                                </p>
                                <hr>
                            </div>
                        </div>

                    </div>
                    <div class="form-group mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary float-left">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result).show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURLLabel(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imagePreviewlabel').attr('src', e.target.result).show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function displayVideoName(input) {
        if (input.files && input.files[0]) {
            var fileName = input.files[0].name;
            $('#videoName').text(fileName).show();
        }
    }
    var quill = new Quill('#editor-container', {
        modules: {
            toolbar: '#toolbar-container'
        },
        placeholder: 'Compose an epic...',
        theme: 'snow'
    });
    document.getElementById('editor-form').addEventListener('submit', function() {
        // Sync Quill content to hidden input field
        var editorContent = document.getElementById('editor-content');
        editorContent.value = quill.root.innerHTML;
    });
</script>
@endsection
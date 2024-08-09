@extends('dummy.app_new')

@section('content')
<style>
    .card {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    .btn-custom {
        background: linear-gradient(45deg, #700877 0%, #ff2759 100%);
        color: white;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 14px;
        border: none;
        transition: background-color 0.3s ease;
    }
</style>
<div class="content content-components">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="container pd-20 mg-t-8 col-11 mx-auto">

                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10" style="font-weight:bold;">Edit Product</h4>
                        <p class="mg-b-30">Use this page to  <code>EDIT</code> Product.</p>
                        <hr>
                    </div>


                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data" id="editor-form">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Name <span style="color: red;">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name" value="{{ $product->name }}">
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="brand">Brand <span style="color: red;">*</span></label>
                                    <input type="text" name="brand" id="brand" class="form-control" placeholder="Enter brand name" value="{{ $product->brand }}">
                                    @error('brand')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="company_name">Company Name <span style="color: red;">*</span></label>
                                    <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Enter company name" value="{{ $product->company_name }}">
                                    @error('company_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="gtin">GTIN</label>
                                    <input type="text" name="gtin" id="gtin" class="form-control" placeholder="Enter GTIN" value="{{ $product->gtin }}">
                                    @error('gtin')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="web_url">Web Url <span style="color: red;">*</span></label>
                                    <input type="text" name="web_url" id="web_url" class="form-control" placeholder="Enter web URL" value="{{ $product->web_url }}">
                                    @error('web_url')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Active" {{ $product->status === 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ $product->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="auth_required">Authentication Required</label>
                                    <select name="auth_required" id="auth_required" class="form-control">
                                        <option value="0" {{ $product->auth_required == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $product->auth_required == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @error('auth_required')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="bypass_conditions">Bypass Conditions</label>
                                    <select name="bypass_conditions" id="bypass_conditions" class="form-control">
                                        <option value="0" {{ $product->bypass_conditions == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $product->bypass_conditions == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @error('bypass_conditions')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <div id="toolbar-container">
                                    <span class="ql-formats">
                                        <select class="ql-font"></select>
                                        <select class="ql-size"></select>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                        <button class="ql-strike"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <select class="ql-color"></select>
                                        <select class="ql-background"></select>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-script" value="sub"></button>
                                        <button class="ql-script" value="super"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-header" value="1"></button>
                                        <button class="ql-header" value="2"></button>
                                        <button class="ql-blockquote"></button>
                                        <button class="ql-code-block"></button>
                                    </span>
                                    <span class="ql-formats mg-t-5">
                                        <button class="ql-list" value="ordered"></button>
                                        <button class="ql-list" value="bullet"></button>
                                        <button class="ql-indent" value="-1"></button>
                                        <button class="ql-indent" value="+1"></button>
                                    </span>
                                    <span class="ql-formats mg-t-5">
                                        <button class="ql-direction" value="rtl"></button>
                                        <select class="ql-align"></select>
                                    </span>
                                    <span class="ql-formats mg-t-5">
                                        <button class="ql-link"></button>
                                        <button class="ql-image"></button>
                                        <button class="ql-video"></button>
                                        <button class="ql-formula"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-clean"></button>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12">

                                <div id="editor-container" class="ht-200">

                                </div>
                                <input type="hidden" name="editor_content" id="editor-content" value="{{old('description')}}">
                            </div>
                            <div class="col-sm-6">
                            <h5>Product Images</h5>
                            <hr>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" onchange="readURL(this);" accept="image/*" id="image" name="image" class="form-control-file">
                                    <small class="form-text">Image size should be below 500 KB in jpeg, png format.</small>
                                    <img id="imagePreview" src="{{ url('/') . '/' . $product->image }}" alt="Preview" class="img-fluid mt-2 mb-2">
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                            <h5>Label Image</h5>
                            <hr>
                                <div class="form-group">
                                    <label for="label_img">Label Image</label>
                                    <input type="file" onchange="readURLLabel(this);" accept="image/*" id="label_img" name="label_img" class="form-control-file">
                                    <small class="form-text" >Image size should be below 500 KB in jpeg, png format.</small>
                                    <img id="imagePreviewLabel" src="{{ url('/') . '/' . $product->label }}" alt="Preview" class="img-fluid mt-2">
                                    @error('label_img')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                            <h5>Media</h5>
                            <hr>
                                <div class="form-group">
                                    <label for="video">Video</label>
                                    <input type="file" accept="video/mp4, video/quicktime" id="video" name="video" class="form-control-file" onchange="displayVideoName(this);">
                                    <small class="form-text">Video size should be below 5 MB in mp4, mov format.</small>
                                    @if (!empty($product->media))
                                    <div id="videoName" class="mt-2">{{ url('/') . '/' . $product->media }}</div>
                                    @endif
                                    @error('video')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-custom float-right"><i class="fas fa-save"></i> Update</button>
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary float-left"><i class="fas fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                    </form>
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
                $('#imagePreviewLabel').attr('src', e.target.result).show();
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
    var editorContentInput = document.getElementById('editor-content');
    quill.root.innerHTML = '{!!$product->description!!}';
    // Handle form submission
    document.getElementById('editor-form').addEventListener('submit', function() {
        // Sync Quill content to hidden input field
        editorContentInput.value = quill.root.innerHTML;
    });
</script>
@endsection
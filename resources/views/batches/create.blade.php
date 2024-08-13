@extends('dummy.app_new')

@section('content')
<style>
    .btn-custom {
        background: linear-gradient(45deg, #700877 0%, #ff2759 100%);
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
        <div class="col-lg-8">
            <div class="container pd-20 mg-t-10 col-11 mx-auto">
                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bold;">Add new Batch</h4>
                        <p class="mg-b-30">Use this page to add <code>NEW</code> Batch.</p>
                        <hr>
                    </div>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('batches.store') }}" id="productForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_id">Select Product <span style="color: red;">*</span></label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="">Please select</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Batch Code <span style="color: red;">*</span></label>
                                    <input type="text" name="code" id="code" class="form-control" placeholder="Batch Code" value="{{ old('code') }}">
                                    @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="currency">Select Currency <span style="color: red;">*</span></label>
                                    <select name="currency" id="currency" class="form-control">
                                        <option value="{{ $product->id }}">Please select</option>
                                        <option value="INR" {{old('currency')=="INR"?'selected':''}}>INR</option>
                                        <option value="USD" {{old('currency')=="USD"?'selected':''}}>USD</option>
                                        <option value="EURO" {{old('currency')=="EURO"?'selected':''}}>EURO</option>
                                    </select>
                                    @error('currency')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price <span style="color: red;">*</span></label>
                                    <input type="number" min="0" step="0.01" name="price" id="price" class="form-control" placeholder="Price" value="{{ old('price') }}">
                                    @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mfg_date">Manufacturing date <span style="color: red;">*</span></label>
                                    <input type="date" name="mfg_date" id="mfg_date" class="form-control" value="{{ old('mfg_date') }}">
                                    @error('mfg_date')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exp_date">Expiry Date <span style="color: red;">*</span></label>
                                    <input type="date" name="exp_date" id="exp_date" class="form-control" value="{{ old('exp_date') }}">
                                    @error('exp_date')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span style="color: red;">*</span></label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Active" {{old('status')=="Active"?'selected':''}}>Active</option>
                                        <option value="Inactive" {{old('status')=="InActive"?'selected':''}}>Inactive</option>
                                    </select>
                                    @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
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
                                <input type="hidden" name="editor_content" id="editor-content">
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-custom float-right">
                                        Submit
                                    </button>
                                    <a href="{{ route('batches.index') }}" class="btn btn-secondary float-left">
                                        Back
                                    </a>
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
    var quill = new Quill('#editor-container', {
        modules: {
            toolbar: '#toolbar-container'
        },
        placeholder: 'Compose an epic...',
        theme: 'snow'
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('productForm');
        var mfgDateInput = document.getElementById('mfg_date');
        var expDateInput = document.getElementById('exp_date');

        // Function to validate the dates
        function validateDates() {
            var mfgDate = new Date(mfgDateInput.value);
            var expDate = new Date(expDateInput.value);

            // Remove previous error messages
            var errorMessages = document.querySelectorAll('.text-danger');
            errorMessages.forEach(function(message) {
                message.textContent = '';
            });

            if (expDate <= mfgDate) {
                // Show error message if expiry date is not after manufactured date
                var errorElement = document.createElement('div');
                errorElement.className = 'text-danger';
                errorElement.textContent = 'Expiry date must be after the manufactured date.';

                var expDateFormGroup = expDateInput.closest('.form-group');
                expDateFormGroup.appendChild(errorElement);

                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }

        // Validate on form submission
        form.addEventListener('submit', function(event) {
            if (!validateDates()) {
                event.preventDefault(); // Prevent form from submitting if validation fails
            } else {
                // Sync Quill content to hidden input field
                var editorContent = document.getElementById('editor-content');
                editorContent.value = quill.root.innerHTML;
            }
        });

        // Optional: Validate on date input change
        mfgDateInput.addEventListener('change', validateDates);
        expDateInput.addEventListener('change', validateDates);
    });
</script>

@endsection
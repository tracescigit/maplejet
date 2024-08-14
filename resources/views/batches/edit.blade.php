@extends('dummy.app_new')

@section('content')
<style>
    .card {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    .btn-custom {
        background: #b70a9b !important;
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
        <div class="col-lg-10">
            <div class="container">
                
                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bold;">Edit Batch</h4>
                        <p class="mg-b-30">Use this page to <code>Edit</code> Batch.</p>
                        <hr>
                    </div>


                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('batches.update', $batch->id) }}" id="productForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="product_id">Select Product</label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="">Please select</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ $product->id == $batch->product_id ? 'selected' : '' }}>{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="code">Batch Code</label>
                                    <input type="text" name="code" id="code" class="form-control" value="{{ $batch->code }}">
                                    @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="currency">Select Currency</label>
                                    <select name="currency" id="currency" class="form-control">
                                        <option value="">Please select</option>
                                        <option value="INR" {{ $batch->currency == 'INR' ? 'selected' : '' }}>INR</option>
                                        <option value="USD" {{ $batch->currency == 'USD' ? 'selected' : '' }}>USD</option>
                                        <option value="EURO" {{ $batch->currency == 'EURO' ? 'selected' : '' }}>EURO</option>
                                    </select>
                                    @error('currency')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" min="0" step="0.01" name="price" id="price" class="form-control" value="{{ $batch->price }}">
                                    @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="mfg_date">Manufacturing Date</label>
                                    <input type="date" name="mfg_date" id="mfg_date" class="form-control" value="{{ $batch->mfg_date ? $batch->mfg_date->format('Y-m-d') : '' }}">
                                    @error('mfg_date')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="exp_date">Expiry Date</label>
                                    <input type="date" name="exp_date" id="exp_date" class="form-control" value="{{ $batch->exp_date ? $batch->exp_date->format('Y-m-d') : '' }}"> 
                                    @error('exp_date')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Active" {{ $batch->status == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ $batch->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="3">{{ $batch->remarks }}</textarea>
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
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-custom float-right">Update</button>
                                <a href="{{ route('batches.index') }}" class="btn btn-secondary float-left"> Back</a>
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
        var editorContentInput = document.getElementById('editor-content');
        quill.root.innerHTML = '{!!$batch->remarks!!}';
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
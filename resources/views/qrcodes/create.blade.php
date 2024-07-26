@extends('dummy.app_new')

@section('content')
<style>
    .input-file-box {
        position: relative;
        width: 100%;
    }

    .input-file-box input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

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

    .input-file-box {
        display: inline-block;
        vertical-align: middle;
    }

    #fileNameContainer {
        display: inline-block;
        margin-left: 10px;
        /* Space between the file input and the file name */
        vertical-align: middle;
    }
</style>

<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card pd-20 mg-t-10 col-11 mx-auto">
                <div class="card-header btn-custom">
                    <h5 class="text-white">Upload QR Codes</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('qrcodes.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_id" class="floating-label">Select Product <span style="color: red;">*</span></label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="">Please select</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ str_replace("_", " ", $product->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="batch" class="floating-label">Batch <span style="color: red;">*</span></label>
                                    <select name="batch" id="batch" class="form-control">
                                        <option value="">Please select Batch</option>
                                        @foreach($batches as $batch)
                                        <option value="{{ $batch->id }}" {{ old('batch') == $batch->id ? 'selected' : '' }}>{{ $batch->code }}</option>
                                        @endforeach
                                    </select>
                                    @error('batch')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="floating-label">Upload File: <span style="color: red;">*</span></label>
                                    <input type="file" id="file" name="file" class="form-control" onchange="displayFileName()">
                                    <label for="file" class="floating-label btn-custom mt-2">Upload File</label>
                                    <span id="fileNameContainer" class="ml-2"></span> <!-- Inline span for file name -->
                                    <span class="text-danger">Please upload a file of type: .csv, .xls, .xlsx.</span>
                                    @error('file')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gs_link" class="floating-label">Generate GS1 Link <span style="color: red;">*</span></label>
                                    <select name="gs_link" id="gs_link" class="form-control">
                                        <option value="no" {{ old('gs_link') == "no" ? 'selected' : '' }}>No</option>
                                        <option value="yes" {{ old('gs_link') == "yes" ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @error('gs_link')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{ route('qrcodes.index') }}" class="btn btn-secondary float-left">
                                    Back
                                </a>

                                <button type="submit" class="btn btn-custom float-right">
                                    Submit
                                </button>
                                <a href="{{ tracescicss('samples/code_sample.csv') }}" download class="btn btn-primary mx-3  float-right" style="margin-top: 2px;">
                                    Download Sample
                                </a>
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
    function displayFileName() {
        var fileInput = document.getElementById('file');
        var fileNameContainer = document.getElementById('fileNameContainer');

        if (fileInput.files.length > 0) {
            var fileName = fileInput.files[0].name;
            fileNameContainer.textContent = fileName;
        } else {
            fileNameContainer.textContent = '';
        }
    }
</script>
@endsection
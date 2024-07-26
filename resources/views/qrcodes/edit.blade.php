@extends('dummy.app_new')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">

                                <div class="card-header">
                                    <h5>Upload QR Codes</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{route('qrcodes.update')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="floating-label">Select product</label>
                                                    <select name="product_id" class="form-control">
                                                        <option value="">Please select</option>
                                                        @foreach($products as $product)
                                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('product_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="floating-label">Batch</label>
                                                    <select name="batch" class="form-control">
                                                        <option value="">Please select Batch</option>
                                                        @foreach($batches as $batch)
                                                        <option value="{{$batch->id}}">{{$batch->code}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('batch')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="input-file-box">
                                                    <input type="file" id="file" name="file">
                                                </div>
                                                <span class="text-danger">The uploaded file must be a file of type: .csv, .xls, .xlsx.</span>
                                                @error('file')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="floating-label">Generate GS1 Link</label>
                                                    <select name="gs_link" class="form-control">
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                    @error('status')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-12">
                                                <div class="form-group" wire:ignore>
                                                    <label class="floating-label">Description</label>
                                                    <textarea wire:model="description" class="form-control" id="description"></textarea>
                                                </div>
                                            </div> -->

                                            <div class="col-sm-12 mt-3">
                                                <a class="btn btn-secondary" href="{{route('batches.index')}}"><img src="{{tracesciimg('icons8-back-80.png')}}" style="max-width:25px;">Back</a>
                                                <a href="{{tracescicss('samples/code_sample.csv') }}" download class="btn btn-md btn-primary ml-3"><img src="{{tracesciimg('icons8-download-50.png')}}" style="max-width:25px;">Download Sample</a>
                                                <button class="btn btn-primary float-right" type="'Submit'"><img src="{{tracesciimg('icons8-submit-50.png')}}" style="max-width:25px;">Submit</button>
                                            </div>
                                        </div>
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
@endsection

<script src="{{tracescijs('summernote.lite.min.js')}}"></script>
@push('scripts')
<script>
    $(document).ready(function() {
        $('#description').summernote({
            height: 300, // Set the height of the editor
            // Add other options here as needed
        });
    });
</script>
@endpush
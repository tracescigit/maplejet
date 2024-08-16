@extends('dummy.app_new')

@section('content')
<style>
    * {
        box-sizing: border-box;
    }

    body,
    html {
        height: 100%;
        margin: 0;
        font-family: Arial, sans-serif;
        
    }

    .card-header {
        background-color: #48b8b2;
        color: white;
    }

    .tablink {
        background-color: #555;
        color: white;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        font-size: 17px;
        width: 50%;
    }

    .tablink:hover {
        background-color: #777;
    }

    .tabcontent {
        display: none;
        padding: 20px;
        /* background-color: #f9f9f9; */
        height: calc(100% - 56px);
        /* Adjusted to fit content properly */
    }

    .form-control {
        border-radius: 0;
    }

    .btn-custom {
        background: #b70a9b !important;
        color: white;
        border-radius: 5px;
        padding: 8px 16px;
        font-size: 14px;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #8a0278;
    }

    /* Card and table styles */
    .card {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    .custom {
        background: linear-gradient(45deg, #700877 0%, #ff2759 100%);
        color: white;
    }
</style>

@if(session('status'))
<div id="statusMessage" class="alert alert-success mt-2" style="background-color:#34eb86">{{session('status')}}</div>
@endif
<div id="statusMessage1" class="alert alert-success mt-2" style="display: none; background-color:#34eb86;"></div>
<div id="statusMessage2" class="alert alert-danger mt-2" style="display: none; background-color:#34eb86;"></div>

<div class="content content-components">
    <div class="container">
        <div data-label="Bulk-Uploads" class="df-example demo-table">
            <div class="d-flex bg-gray-10">
                <div class="pd-10 flex-grow-1">
                    <h4 id="section3" class="mg-b-10 font-weight-bolder">Bulk-Uploads</h4>
                    <p class="mg-b-30">Use this page to add <code style="color:#e300be;">NEW</code> Batch.</p>
                </div>

                <div class="pd-10 mg-l-auto">
                   <button type=" button" class="btn btn-custom btn-icon" data-toggle="modal" data-target="#bulkActionModal"><i data-feather="plus-circle" class="mr-1"></i>Assign Product</button></a>
                </div>
            </div>





            <!-- <div class="content-header mg-b-25">
                <h3>Bulk-Uploads</h3>
                <button type="button" class="btn btn-custom float-right" data-toggle="modal" data-target="#bulkActionModal">Assign Product </button>
            </div> -->






            <div class="card-body">
                <div class="d-flex align-items-end">
                    <button class="tablink tx-17 font-weight-bold " onclick="openPage('Home', this, '#8392a5')" style="background-color: rgb(131, 146, 165);">Upload File</button>
                    <button class="tablink tx-17 font-weight-bold " onclick="openPage('News', this, '#8392a5')" id="defaultOpen" style="margin-left: 20px;">Generate By Serial No</button>
                </div>
                <div id="Home" class="tabcontent" style="display:block;">
                    <h3>Upload File</h3>
                    <form method="POST" action="{{ route('bulkuploads.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input type="file" id="file" name="file" class="form-control-file">
                                    <small class="text-danger">Uploaded file must be .csv, .xls, or .xlsx</small>
                                    @error('file')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <button class="btn btn-custom" type="submit">
                                    Submit
                                </button>
                                <a href="{{ tracescicss('samples/code_sample.csv') }}" download class="btn btn-md btn-primary ml-3">
                                    Download Sample
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="News" class="tabcontent">
                    <form method="POST" action="{{ route('bulkuploads.store_serial_no') }}">
                        @csrf
                        <div class="form-group w-25">
                            <select name="option" id="status" class="form-control" onchange="toggleQuantityInput()">
                                <option value="generate_by_serial">Generate By Serialization.</option>
                                <option value="generate_by_random">By Randomization.</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="floating-label">Quantity</label>
                                    <input type="number" name="quantity" class="form-control" placeholder="Quantity" required>
                                </div>
                            </div>
                            <div class="col-sm-6" id="quantityInput">
                                <div class="form-group">
                                    <label class="floating-label">Starting Code</label>
                                    <input type="text" name="starting_code" class="form-control" placeholder="Start Code">
                                    <small class="text-danger">Starting code must be between 7 and 21 digits</small>
                                </div>
                            </div>
                            <div class="col-sm-12 mx-2">
                                <button type="submit" class="btn btn-custom">Submit</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="bulkActionModal" tabindex="-1" role="dialog" aria-labelledby="bulkTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="bulkForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkTitle">Assign Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="floating-label">Start Code</label>
                                <input type="text" value="{{old('start_code')}}" name="start_code" class="form-control" placeholder="Start Code" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="floating-label">Quantity</label>
                                <input type="number" value="{{old('number')}}" min="1" name="quantity" class="form-control" placeholder="Quantity" required value="1">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="floating-label">Select product</label>
                                <select name="product_id" class="form-control">
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="floating-label">Batch</label>
                                <select name="batch_id" class="form-control">
                                    <option value="">Please select Batch</option>
                                    @foreach($batches as $batch)
                                    <option value="{{ $batch->id }}" {{ old('batch_id') == $batch->id ? 'selected' : '' }}>{{ $batch->code }}</option>
                                    @endforeach
                                </select>
                                @error('batch_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="floating-label">Generate GS1 Link</label>
                                <select name="gs1_link" class="form-control" id="gs1_link_select">
                                    <option value="no" {{ old('gs1_link') == "no" ? 'selected' : '' }}>NO</option>
                                    <option value="yes" {{ old('gs1_link') == "yes" ? 'selected' : '' }}>YES</option>
                                </select>
                                @error('gs1_link')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6" id="generate_gs1_link_with" style="display: none;">
                            <div class="form-group">
                                <label class="floating-label">Generate GS1 Link With</label>
                                <select name="generate_gs1_link_with" class="form-control">
                                    <option value="batch" {{ old('generate_gs1_link_with') == "batch" ? 'selected' : '' }}>Batch</option>
                                    <option value="serial_no" {{ old('generate_gs1_link_with') == "serial_no" ? 'selected' : '' }}>Serial No</option>
                                </select>
                                @error('generate_gs1_link_with')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="floating-label">Action</label>
                                <select name="status" class="form-control">
                                    <option value="active" {{ old('status') == "active" ? 'selected' : '' }}>Activate</option>
                                    <option value="inactive" {{ old('status') == "inactive" ? 'selected' : '' }}>Deactivate</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button class="btn btn-custom">
                         Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection




@section('js')
<script>
    $('#bulkActionModal').on('hidden.bs.modal', function() {
        $('.modal-backdrop').remove();
    });

    function closemodal() {
        $('#bulkActionModal').modal('hide');
    }

    function chooseFile() {
        document.getElementById('fileInput').click();
    }

    function submitForm() {
        document.getElementById('importForm').submit();
    }

    function updateStatus(status) {
        if (confirm('Are you sure to change the Status?')) {
            document.getElementById('statusInput').value = status;
            document.getElementById('updateForm').submit();
        }
    }

    function showmodal() {
        $('#bulkActionModal').modal('show');
    }
    $(document).ready(function() {
        $('#bulkForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "{{route('bulkupload.bulkassign')}}",
                data: formData,
                success: function(response) {
                    if (response.startcodeerror) {
                        $('text-danger').html('');
                        $('input[name="start_code"]').closest('.form-group').append('<div class="text-danger">' + response.startcodeerror + '</div>');
                    } else if (response.status == 'GTIN number not provided while creating product') {
                        $('#statusMessage2').html(response.status);
                        $('#statusMessage2').css('display', 'block');
                        closemodal();
                    } else if (response.producterror == 'Code is not assigned Product and Batch. Please assign Product and Batch First.') {
                        $('text-danger').html('');
                        $('input[name="start_code"]').closest('.form-group').append('<div class="text-danger">' + response.producterror + '</div>');
                        setTimeout(function() {
                            closemodal();
                        }, 2000);
                    } else {
                        $('#bulkActionModal').modal('hide');
                        if (response.status) {
                            $('#statusMessage1').html(response.status);
                            $('#statusMessage1').css('display', 'block');
                            setTimeout(function() {
                                location.reload();
                            }, 4000);

                        }


                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

    });

    function openPage(pageName, elmnt, color) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].style.backgroundColor = "";
        }
        document.getElementById(pageName).style.display = "block";
        elmnt.style.backgroundColor = color;
    }

    function toggleQuantityInput() {
        var status = document.getElementById("status").value;
        var quantityInput = document.getElementById("quantityInput");

        if (status === "generate_by_serial") {
            quantityInput.style.display = "block"; // Show Quantity input
        } else {
            quantityInput.style.display = "none"; // Hide Quantity input
        }
    }

    // Ensure initial state matches the selected option on page load
    toggleQuantityInput();
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('gs1_link_select').addEventListener('change', function() {
            var generateGS1LinkWith = document.getElementById('generate_gs1_link_with');
            if (this.value === 'yes') {
                generateGS1LinkWith.style.display = 'block';
            } else {
                generateGS1LinkWith.style.display = 'none';
            }
        });
    });
</script>

@endsection
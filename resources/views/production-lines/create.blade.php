@extends('dummy.app_new')

@section('content')
<style>
    .checkbox-row {
        display: flex;
        align-items: center;
        /* Center checkboxes vertically */
    }

    .checkbox-row label {
        margin: 0;
        padding: 0 10px 0 0;
        /* Add padding for checkbox label */
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
        padding: 8px 16px;
        font-size: 14px;
        border: none;
        transition: background-color 0.3s ease;
    }
</style>

<div class="content content-components">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="container pd-20 mg-t-10 col-11 mx-auto">

                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bold;">Add new production Line</h4>
                        <p class="mg-b-30">Use this page to add <code>NEW</code> Production Line</p>
                        <hr>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('production-lines.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="plant_id" class="floating-label">Production Plant <span style="color: red;">*</span></label>
                                    <select name="plant_id" id="plant_id" class="form-control" required>
                                        <option value="">Please select</option>
                                        @foreach($productionplant as $plant) <!-- Assuming $productionplants is the correct variable -->
                                        <option value="{{ $plant->id }}" {{ old('plant_id') == $plant->id ? 'selected' : '' }}>{{ $plant->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('plant_id')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="floating-label">Name <span style="color: red;">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="{{ old('name')}}" vrequired>
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code" class="floating-label">Code <span style="color: red;">*</span></label>
                                    <input type="text" name="code" id="code" class="form-control" placeholder="Enter Code" value="{{ old('code')}}" required>
                                    @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ip_address" class="floating-label">System IP <span style="color: red;">*</span></label>
                                    <input type="text" name="ip_address" id="ip_address" class="form-control" placeholder="Enter System IP " value="{{ old('ip_address')}}" required>
                                    @error('ip_address')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="printer_name" class="floating-label">Printer Name <span style="color: red;">*</span></label>
                                    <select name="printer_name" id="printer_name" class="form-control" required>
                                        <option value="maplejet" {{ old('printer_name')=="maplejet" ?'selected':''}}>Maplejet</option>
                                        <!-- <option value="wb">maplejet</option>
                                        <option value="dn"></option> -->
                                    </select>
                                    @error('printer_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="floating-label">Status <span style="color: red;">*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="Active" {{ old('status') =="Active"?'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ old('status') == "Inactive" ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="checkbox-row">
                                    <label><input type="checkbox" name="has_printer" onchange="toggleInput(this, 'printer')" checked> Printer</label>
                                </div>
                            </div>
                            <div class="col-md-6" id="printerInput">
                                <input type="text" name="ip_printer" class="form-control" placeholder="IP">
                                <div class="d-flex">
                                    <input type="text" name="port_printer" class="form-control mt-2 w-50 mr-2" placeholder="Port">
                                    @error('port_printer')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="text" name="printer_id" class="form-control mt-2 w-50 d-flex" placeholder="Printer ID">
                                    @error('printer_id')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="password" name="printer_password" class="form-control mt-2 w-50 d-flex ml-2" placeholder="Printer Password">
                                    @error('printer_password')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="checkbox-row">
                                    <label><input type="checkbox" name="has_camera" onchange="toggleInput(this, 'camera')"> Camera</label>
                                </div>
                            </div>
                            <div class="col-md-6" id="cameraInput" style="display: none;">
                                <input type="text" name="ip_camera" class="form-control" placeholder="IP">
                                <input type="text" name="port_camera" class="form-control mt-2" placeholder="Port">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="checkbox-row">
                                    <label><input type="checkbox" name="has_plc" onchange="toggleInput(this, 'plc')"> PLC / Rejection / Alarm</label>
                                </div>
                            </div>
                            <div class="col-md-6" id="plcInput" style="display: none;">
                                <input type="text" name="ip_plc" class="form-control" placeholder="IP">
                                <input type="text" name="port_plc" class="form-control mt-2" placeholder="Port">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('production-lines.index') }}" class="btn btn-secondary float-left">
                                        Back
                                    </a>
                                    <button type="submit" class="btn btn-custom float-right">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleInput(checkbox, inputName) {
        var inputDiv = document.getElementById(inputName + 'Input');
        if (checkbox.checked) {
            inputDiv.style.display = 'block'; // Changed to 'block' for proper display
        } else {
            inputDiv.style.display = 'none';
        }
    }
</script>
@endsection
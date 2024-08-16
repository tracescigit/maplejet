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
</style>
<div class="content content-components">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="container">
              
                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bolder;">Edit Production line</h4>
                        <p class="mg-b-30">Use this page to <code style="color:#e300be;">Edit</code> production line</p>
                        <hr>
                    </div>


                </div>
                
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('production-lines.update', $productionlines->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="plant_id">Production Plant</label>
                                    <select name="plant_id" id="plant_id" class="form-control">
                                        <option value="">Please select</option>
                                        @foreach ($productionplant as $plant)
                                        <option value="{{ $plant->id }}" {{ $productionlines->plant_id == $plant->id ? 'selected' : '' }}>{{ $plant->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Name <span style="color: red;">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $productionlines->name }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="code">Code <span style="color: red;">*</span></label>
                                    <input type="text" name="code" id="code" class="form-control" value="{{ $productionlines->code }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ip_address">IP Address <span style="color: red;">*</span></label>
                                    <input type="text" name="ip_address" id="ip_address" class="form-control" value="{{ $productionlines->ip_address }}">

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="printer_name">Printer Name <span style="color: red;">*</span></label>
                                    <select name="printer_name" id="printer_name" class="form-control">
                                        <option value="vj" {{ $productionlines->printer_name == 'vj' ? 'selected' : '' }}>maplejet</option>
                                        <!-- <option value="wb" {{ $productionlines->printer_name == 'wb' ? 'selected' : '' }}>X1 Jet Markoprint (Weber)</option>
                                        <option value="dn" {{ $productionlines->printer_name == 'dn' ? 'selected' : '' }}>Domino</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="status">Status <span style="color: red;">*</span></label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Active" {{ $productionlines->status == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ $productionlines->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
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
                                <input type="text" name="ip_printer" class="form-control" placeholder="IP" value="{{ $productionlines->ip_printer??''}}">
                                <div class="d-flex">
                                    <input type="text" name="port_printer" class="form-control mt-2 w-50 mr-2" placeholder="Port" value="{{ $productionlines->port_printer }}">
                                    <input type="text" name="printer_id" class="form-control mt-2 w-50 d-flex" value="{{ old('printer_id', $productionlines->printer_id) }}" placeholder="Printer ID">
                                    <input type="password" name="printer_password" class="form-control mt-2 w-50 d-flex" placeholder="Printer Password">


                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="cameraCheckbox" name="Camera" onchange="toggleInput(this, 'camera')" {{ $productionlines->ip_camera ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="cameraCheckbox">Camera</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6" id="cameraInput" style="display: {{ $productionlines->ip_camera ? 'flex' : 'none' }};">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="ip_camera" id="ip_camera" class="form-control" placeholder="IP Camera" value="{{ $productionlines->ip_camera }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="port_camera" id="port_camera" class="form-control" placeholder="Port Camera" value="{{ $productionlines->port_camera }}">
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="plcCheckbox" name="PLC" onchange="toggleInput(this, 'plc')" {{ $productionlines->ip_plc ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="plcCheckbox">PLC</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" id="plcInput" style="display: {{ $productionlines->ip_plc ? 'flex' : 'none' }};">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="ip_plc">IP PLC</label>
                                            <input type="text" name="ip_plc" id="ip_plc" class="form-control" value="{{ $productionlines->ip_plc }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="port_plc">Port PLC</label>
                                            <input type="text" name="port_plc" id="port_plc" class="form-control" value="{{ $productionlines->port_plc }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <button type="submit" class="btn btn-custom float-right"> Update</button>
                            <a href="{{ route('production-lines.index') }}" class="btn btn-secondary float-left"> Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Function to toggle input fields based on checkbox status
    function toggleInput(checkbox, inputName) {
        var inputDiv = document.getElementById(inputName + 'Input');
        if (checkbox.checked) {
            inputDiv.style.display = 'block';
        } else {
            inputDiv.style.display = 'none';
        }
    }
</script>
@endsection
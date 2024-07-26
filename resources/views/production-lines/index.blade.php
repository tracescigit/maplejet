@extends('dummy.app_new')

@section('content')
<style>
    /* Custom styles for improved design */

    /* Button styles */
    .btn-custom {
        background: transparent linear-gradient(45deg, #700877 0%, #ff2759 100%, #ff2759 100%) repeat scroll 0 0;
        color: white;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 14px;
        border: none;
        transition: background-color 0.3s ease;
        opacity: 1;
    }

    .btn-custom:hover {
        /* background-color: #8a0278; */
    }

    /* Card and table styles */
    .card {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .table th {
        text-align: center;
    }

    .table tbody tr:hover {
        background-color: #f0f0f0;
    }

    /* Modal styles */
    #myModal .modal-content {
        border-radius: 10px;
    }

    #myModal .modal-header {
        background-color: #343a40;
        color: white;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    #myModal .modal-footer {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .info-box {
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        border-radius: .25rem;
        background-color: #fff;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 1rem;
        min-height: 80px;
        padding: .5rem;
        position: relative;
        width: 100%;
    }

    .info-box .info-box-icon {
        border-radius: .25rem;
        -ms-flex-align: center;
        align-items: center;
        display: -ms-flexbox;
        display: flex;
        font-size: 1.875rem;
        -ms-flex-pack: center;
        justify-content: center;
        text-align: center;
        width: 70px;
    }

    .info-box .info-box-content {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        -ms-flex-pack: center;
        justify-content: center;
        line-height: 1.8;
        -ms-flex: 1;
        flex: 1;
        padding: 0 10px;
        overflow: hidden;
    }
</style>

<div id="myModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Production Plant Details</h5>
                <button type="button" onclick="closeModal()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tbody id="table-body">
                        <!-- Modal content dynamically populated here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="main-panel" id="main-panel">
        <div class="row">
            <div class="col-md-12">
                @if(session('status'))
                <div id="statusMessage" class="alert alert-success mt-2" style="background-color:#34eb86">{{session('status')}}</div>
                @endif
            </div>
            <div class="d-sm-flex mx-auto mg-t-10 col-lg-11">



                <div class="col-sm-3 col-lg-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary tx-teal elevation-1 op-6"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                        <div class="info-box-content" style="font-weight:bold;">
                            <span class="info-box-text">Last Prod.Line</span>
                            <span class="info-box-number" style="justify-self:center">Production2</span>
                        </div>

                    </div>
                </div>


                <div class="col-sm-3 col-lg-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info tx-teal elevation-1 op-6"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                        <div class="info-box-content" style="font-weight:bold;">
                            <span class="info-box-text">Total Prod.Lines</span>
                            <span class="info-box-number" style="justify-self:center">8</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 col-lg-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-pink elevation-1 op-4"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                        <div class="info-box-content" style="font-weight:bold;">
                            <span class="info-box-text"> Active</span>
                            <span class="info-box-number" style="justify-self:center">4</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 col-lg-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1 op-4"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                        <div class="info-box-content" style="font-weight:bold;">
                            <span class="info-box-text"> Inactive</span>
                            <span class="info-box-number" style="justify-self:center">4</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card pd-20 mg-t-10 col-11 mx-auto">
                    <h3 class="content-header mg-b-25">Production Lines</h3>
                    <div class="d-flex justify-content-between align-items-start">
                        <a href="{{ route('production-lines.create') }}" class="btn btn-custom op-6 ml-3">
                            <img src="{{ tracesciimg('icons8-create-16.png') }}" class="mr-1">{{ __('Add Production Lines') }}
                        </a>
                        <form class="form-inline mr-4" method="GET" action="{{ route('production-plants.index') }}">
                            <div class="form-group mb-2">
                                <input type="search" name="pl_name" class="form-control" placeholder="Search By Plant Line Name" aria-label="Search">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <input type="search" name="pl_code" class="form-control" placeholder="Search By Plant Line Code" aria-label="Search">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <input type="search" name="pp_name" class="form-control" placeholder="Search By Production Plant Name" aria-label="Search">
                            </div>
                            <button class="btn btn-primary mb-2" type="submit">Search</button>
                        </form>
                    </div>

                <div class="table-responsive">
                    <table class="table table-dashboard mg-b-0">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-left">Plant Line Name</th>
                                <th class="text-left">Plant Line Code</th>
                                <th class="text-left">Production Plant Name </th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productionlines as $index=>$singleplant)
                            @php
                            $page = $productionlines->currentPage();
                            $perPage = $productionlines->perPage();
                            $incrementingIndex = ($page - 1) * $perPage + $index + 1;
                            @endphp
              

                            <tr>
                                <td class="tx-color-03 tx-normal text-center">
                                    {{ $incrementingIndex }}
                                </td>
                                <td class="text-left">
                                    {{$singleplant->name}}
                                </td>
                                <td class="tx-medium text-left ">
                                    {{$singleplant->code}}
                                </td>
                                <td class="text-left">
                                    {{$singleplant->name}}
                                </td>
                                <td class="text-center">
                                    @if($singleplant->status == 'Active')
                                    <span class="badge badge-success"> {{$singleplant->status}}</span>
                                    @else
                                    <span class="badge badge-danger"> {{$singleplant->status}}</span>
                                </td>
                                @endif
                                <td class="text-center">
                                    <a class="btn btn-outline-primary" type="button" href="{{route('production-lines.show',$singleplant->id)}}"><i class="fas fa-eye" style="color: #63E6BE;"></i></a>
                                    <a href="{{route('production-lines.edit', $singleplant->id)}}" class="btn btn-outline-primary float-center" type="button"><i class="fas fa-edit" style="color: #74C0FC;"></i></a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $productionlines->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>
</div>
@endsection




@section('js')
<script>
    // Function to open modal and fetch data via AJAX
    function openModal(id) {
        // AJAX request to fetch data for the clicked plant
        $.ajax({
            url: "{{ url('getPlantDetails') }}",
            type: 'GET',
            dataType: 'json',
            data: {
                id: id
            },
            success: function(response) {
                // Update modal content with fetched data
                var modalBody = '';
                modalBody += '<tr><td>Plant Code</td><td>' + response.code + '</td></tr>';
                modalBody += '<tr><td>Plant Name</td><td>' + response.name + '</td></tr>';
                modalBody += '<tr><td>Status</td><td>' + response.status + '</td></tr>';
                modalBody += '<tr><td>Description</td><td>' + response.description + '</td></tr>';
                modalBody += '<tr><td>Address</td><td>' + response.address + '</td></tr>';

                $('#table-body').html(modalBody);
                $('#myModal').modal('show');
            },
            error: function(response) {
                console.log(response);
            }
        });
    }

    // Function to close modal
    function closeModal() {
        $('#myModal').modal('hide');
    }
</script>
@endsection
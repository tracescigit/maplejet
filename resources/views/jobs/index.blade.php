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
        background-color: #8a0278;
    }

    .card {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    /* Table styles */
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

    /* Info box styles */
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
                <h5 class="modal-title">Product Details</h5>
                <button type="button" onclick="closeModal()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tbody id="table-body">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @if(session('status'))
        <div id="statusMessage" class="alert alert-success mt-2" style="background-color:#34eb86">{{ session('status') }}</div>
        @endif
        @if(session('error'))
        <div id="errorMessage" class="alert alert-danger" style="background-color:#eb3434">
            {{ session('error') }}
        </div>
        @endif


        <div class="d-sm-flex my-3 col-9 mx-auto">
            <div class="media">

            <div class="col-sm-4 col-lg-4">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-info tx-teal elevation-1 op-6"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                <div class="info-box-content" style="font-weight:bold;">
                  <span class="info-box-text">Last Job Added</span>
                  <span class="info-box-number" style="margin-left: 37px;font-size:x-large;">{{$last_added_job->code??""}}</span>
                </div>

              </div>
            </div>
                <div class="col-md-4 col-lg-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info tx-teal elevation-1 op-6"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                        <div class="info-box-content" style="font-weight:bold;">
                            <span class="info-box-text">Total Jobs</span>
                            <span class="info-box-number" style="margin-left: 37px;font-size:x-large;">{{count($jobdatas)}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-pink elevation-1 op-4"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                        <div class="info-box-content" style="font-weight:bold;">
                            <span class="info-box-text">Total Assigned</span>
                            <span class="info-box-number" style="margin-left: 37px;font-size:x-large;">{{$prodactiveCount}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1 op-4"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                        <div class="info-box-content" style="font-weight:bold;">
                            <span class="info-box-text">Total Unassigned</span>
                            <span class="info-box-number" style="margin-left: 37px;font-size:x-large;">{{ count($jobdatas) - $prodactiveCount }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card pd-20 mg-t-10 col-11 mx-auto">
        <h3 class="content-header mb-3">JOBS</h3>
        <div class="d-flex justify-content-between align-items-start">
            <a href="{{ route('jobs.create') }}" class="btn btn-custom op-6">
                <img src="{{ tracesciimg('icons8-create-16.png') }}" class="mr-1">{{ __('Create Jobs') }}
            </a>

            <form class="form-inline" method="GET" action="{{ route('products.index') }}">
                <div class="form-group mx-sm-3 mb-2">
                    <input type="search" name="products_search" class="form-control" placeholder="Search By Product" aria-label="Search">
                </div>
                <div class="form-group mx-sm-2 mb-2">
                    <select style="padding:5px;" class="form-select"  name="products_assigned" aria-label="Default select example" id="option-assigned">
                        <option value="assigned" {{ request('products_assigned') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                        <option value="unassigned" {{ request('products_assigned') == 'unassigned' ? 'selected' : '' }}>Unassigned</option>
                    </select>
                    @error('product_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary mb-2" type="submit">Search</button>
                <button id="downloadcsvbtn" onclick="downloadcsv()" class="btn btn-custom op-6 ml-3 mb-2" type="button">
                    <img src="{{ tracesciimg('icons8-upload-to-cloud-64.png') }}" style="max-width:18px; margin-right:7px;">Download CSV
                </button>
            </form>
        </div>

        <div class="table-responsive"style="padding:20px;">
            <table class="table table-dashboard">
                <thead>
                    <tr>
                        <th class="text-left">Code</th>
                        <th class="text-left">Plant</th>
                        <th class="text-left">Production Line</th>
                        <th class="text-center">Code Quantity</th>
                        <th class="text-center">Printed</th>
                        <th class="text-center">Verified</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobdatas as $index=>$singledata)
                    <tr>
                        <td class="  text-left">{{$singledata->code}}</td>
                        <td class="tx-medium text-left">{{$singledata->productionplant->name ?? ""}}</td>
                        <td class="text-left">{{$singledata->productionLines->name ?? ""}}</td>
                        <td class="text-center">{{$singledata->quantity}}</td>
                        <td class="text-center tx-success">{{$singledata->printed}}</td>
                        <td class="text-center">{{$singledata->verified}}</td>
                        <td class="tx-medium text-center">
                            @if($singledata->status == 'Assigned')
                            <span class="badge badge-success">{{$singledata->status}}</span>
                            @else
                            <span class="badge badge-danger">{{$singledata->status}}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group" aria-label="Actions">
                                
                                    <a href="{{ route('jobs.show', $singledata->id) }}" class="btn btn-outline-primary" type="button">
                                        <i class="fa fa-eye" style="color: #63E6BE; font-size:18px;"></i>
                                    </a>
                                    <a href="{{ route('jobs.edit', $singledata->id) }}" class="btn btn-outline-primary">
                                        <i class="fa fa-edit" style="color: #74C0FC; font-size:18px;"></i>
                                    </a>
                                   
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $jobdatas->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    function downloadcsv() {
        $.ajax({
            url: '{{ route("jobs.downloadcsv") }}',
            type: 'GET',
            success: function(response) {
                // Create a Blob object from the CSV data
                var blob = new Blob([response], {
                    type: 'text/csv'
                });

                // Create a download link
                var downloadLink = document.createElement('a');
                downloadLink.href = window.URL.createObjectURL(blob);
                downloadLink.download = 'data.csv';

                // Append the download link to the document body
                document.body.appendChild(downloadLink);

                // Trigger the download
                downloadLink.click();

                // Clean up
                document.body.removeChild(downloadLink);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error
            }
        });

    }
</script>

<script>
    function closeModal() {
        $('#myModal').modal('hide');
    }
</script>

@endsection
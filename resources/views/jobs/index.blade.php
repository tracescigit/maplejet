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
    </div>
</div>

<div class="content content-components">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
            <div id="statusMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if ($errors->any())
            <div id="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ $errors->first() }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
        </div>
    </div>
    <div class="container pd-20 mg-t-10 col-10 mx-auto">
        <div class="d-flex bg-gray-10">
            <div class="pd-10 flex-grow-1">
                <h4 id="section3" class="mg-b-10">Create Jobs</h4>
                <p class="mg-b-30">Use <code>Add New</code> page to add <code>NEW</code> Job.</p>
            </div>

            <div class="pd-10 mg-l-auto">
                <a href="{{ route('jobs.create') }}"><button type=" button" class="btn btn-custom btn-icon"><i data-feather="plus-circle"></i> Add New</button></a>
                <button id="downloadcsvbtn" onclick="downloadcsv()" class="btn btn-custom" type="button"><i data-feather="download"></i> Download CSV
                </button>
            </div>
        </div>




        <div data-label="Stats" class="df-example mg-b-30">
            <div class="row row-xs">
                <div class="col-sm">
                    <div class="media">
                        <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-teal tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </div>
                        <div class="media-body">
                            <h6 class="tx-sans tx-uppercase tx-05 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">Last Job Added</h6>
                            <h4 class="tx-10 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{$last_added_job->code??""}}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="media">
                        <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-primary tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </div>
                        <div class="media-body">
                            <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">Total </h6>
                            <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{count($jobdatas)}}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="media">
                        <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-pink tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </div>
                        <div class="media-body">
                            <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8"> Assigned</h6>
                            <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{$prodactiveCount}}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="media">
                        <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-orange tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </div>
                        <div class="media-body">
                            <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8"> Unassigned</h6>
                            <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{ count($jobdatas) - $prodactiveCount }}</h4>
                        </div>
                    </div>
                </div>
            </div><!-- row -->
        </div>

        <form method="GET" action="{{ route('products.index') }}">
            <div data-label="codes List" class="df-example demo-table">
                <div class="row row-sm  mg-b-10">
                    <div class="col-sm-3">
                        <input type="text" name="products_search" class="form-control" placeholder="Product">
                    </div>
                    <div class="col-sm-3 mg-t-10  mg-sm-t-0">
                        <select name="products_assigned" aria-label="Default select example" class="form-control">
                            <option value="assigned" {{ request('products_assigned') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                            <option value="unassigned" {{ request('products_assigned') == 'unassigned' ? 'selected' : '' }}>Unassigned</option>
                        </select>
                        @error('product_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-3 mg-t-10  mg-sm-t-0">
                        <button type="submit" class="btn btn-secondary"><i data-feather="search"></i></button>
                        <!-- <button type="button" class="btn btn-secondary"><i data-feather="download"></i> Export</button> -->
                    </div>
                </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped mg-b-0">
                <thead>
                    <tr>
                        <th scope="col" class="text-left font-weight-bold">Code</th>
                        <th scope="col" class="text-left font-weight-bold">Plant</th>
                        <th scope="col" class="text-left font-weight-bold ">Production Line</th>
                        <th scope="col" class="text-center font-weight-bold">Code Quantity</th>
                        <th scope="col" class="text-center font-weight-bold">Printed</th>
                        <th scope="col" class="text-center font-weight-bold">Verified</th>
                        <th scope="col" class="text-center font-weight-bold">Status</th>
                        <th scope="col" class="text-center font-weight-bold">Action</th>


                    </tr>
                </thead>
                <tbody>
                    @forelse($jobdatas as $index=>$singledata)
                    <tr>
                        <td class="tx-color-03 tx-normal text-center">{{$singledata->code}}</td>
                        <td class="tx-medium text-left">{{$singledata->productionplant->name ?? ""}}</td>
                        <td class="text-left">{{$singledata->productionLines->name ?? ""}}</td>
                        <td class="text-right">{{$singledata->quantity}}</td>
                        <td class="text-center">
                            {{$singledata->printed}}
                        </td>
                        <td class="text-center text-danger">
                            {{$singledata->verified}}
                        </td>
                        <td class="tx-medium text-center">
                            @if($singledata->status == 'Assigned')
                            <span class="badge badge-success">{{$singledata->status}}</span>
                            @else
                            <span class="badge badge-danger">{{$singledata->status}}</span>
                            @endif
                        </td>
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
                    @empty
                    <tr>
                        <td colspan="5" class="text-center" style="color:red">---No data found ---</td> <!-- Adjust colspan based on the number of columns -->
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- card -->

    <div class="mt-3">
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
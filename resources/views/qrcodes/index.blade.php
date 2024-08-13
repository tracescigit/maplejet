@extends('dummy.app_new')

@section('content')
<!-- Include Bootstrap CSS -->

<!-- Custom CSS -->
<style>
    /* Button styles */
    .btn-custom {
        background: linear-gradient(45deg, #700877 0%, #ff2759 100%);
        color: white;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 14px;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #8a0278;
    }

    /* Card styles */
    .card {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    /* Info box styles */
    .info-box {
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        border-radius: .25rem;
        background-color: #fff;
        display: flex;
        margin-bottom: 1rem;
        min-height: 80px;
        padding: .5rem;
        position: relative;
        width: 100%;
    }

    .info-box .info-box-icon {
        border-radius: .25rem;
        align-items: center;
        display: flex;
        font-size: 1.875rem;
        justify-content: center;
        text-align: center;
        width: 70px;
        background-color: #007bff;
        color: #ffffff;
    }

    .info-box .info-box-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        line-height: 1.8;
        flex: 1;
        padding: 0 10px;
        overflow: hidden;
    }
</style>

<!-- Page content -->
<div class="wrapper">
    <div class="main-panel" id="main-panel">
        <!-- Status messages -->
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
                @endif
                <div id="statusMessage1" class="alert alert-success" style="background-color:#34eb86; display:none;">
                    <!-- This content will be set dynamically by JavaScript -->
                </div>

            </div>
        </div>

        <!-- Info boxes -->
        <div class="content content-components">



            <div class="container pd-20 mg-t-10 col-10 mx-auto">
                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10">Create Qr-codes</h4>
                        <p class="mg-b-30">Use <code>Add New</code> page to add <code>NEW</code> Qr-code.</p>
                    </div>

                    <div class="pd-10 mg-l-auto">
                        <a href="{{ route('qrcodes.create') }}"><button type=" button" class="btn btn-custom btn-icon"><i data-feather="plus-circle"></i> Add New</button></a>
                        <div class="form-group  mb-2 mt-2 d-inline-flex">

                            <!-- Bulk Action Form -->
                            <form id="importForm" action="{{ route('batches.import') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <button onclick="showmodal()" type="button" class="btn btn-custom">

                                    Bulk Action
                                </button>
                                <a href="{{ route('bulkuploads.index') }}" class="btn btn-custom"> Bulk Uploads</a>
                                <input type="file" id="fileInput" name="file" style="display: none;" onchange="submitForm()">
                                <button type="submit" style="display: none;">Import</button>
                            </form>
                        </div>
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
                                    <h6 class="tx-sans tx-uppercase tx-05 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">Last Code-Data</h6>
                                    <h4 class="tx-10 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{$last_added_product->code_data??''}}</h4>
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
                                    <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{$qr_count}}</h4>
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
                                    <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8"> Active</h6>
                                    <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{$qractiveCount}}</h4>
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
                                    <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8"> Inactive</h6>
                                    <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{$qr_count-$qractiveCount}}</h4>
                                </div>
                            </div>
                        </div>
                    </div><!-- row -->
                </div>

                <div data-label="codes List" class="df-example demo-table">
                    <form method="GET" action="{{ route('qrcodes.index') }}">
                        <div class="row row-sm mg-b-10">
                            <div class="col-sm-3">
                                <input type="text"
                                    name="products_search"
                                    class="form-control"
                                    placeholder="Product"
                                    value="{{ old('products_search', request('products_search')) }}">
                            </div>
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <input type="text"
                                    name="qrcode_search"
                                    class="form-control"
                                    placeholder="code"
                                    value="{{ old('qrcode_search', request('qrcode_search')) }}">
                            </div>
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <select name="products_assigned"
                                    aria-label="Default select example"
                                    class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="assigned" {{ request('products_assigned') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                                    <option value="unassigned" {{ request('products_assigned') == 'unassigned' ? 'selected' : '' }}>Unassigned</option>
                                </select>
                            </div>
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <button type="submit" class="btn btn-secondary"><i data-feather="search"></i></button>
                                <!-- <button type="button" class="btn btn-secondary"><i data-feather="download"></i> Export</button> -->
                            </div>
                        </div>

                    </form>



                    <div class="table-responsive">
                        <table class="table table-striped mg-b-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center font-weight-bold">ID</th>
                                    <th scope="col" class="text-left font-weight-bold">Product Name</th>
                                    <th scope="col" class="text-left font-weight-bold">Batch Name</th>
                                    <th scope="col" class="text-left font-weight-bold">Code Data</th>
                                    <th scope="col" class="text-center font-weight-bold">Created At</th>
                                    <th scope="col" class="text-center font-weight-bold">Action</th>


                                </tr>
                            </thead>
                            <tbody>
                                @forelse($qrdatas as $index => $singledata)
                                @php
                                $page = $qrdatas->currentPage();
                                $perPage = $qrdatas->perPage();
                                $incrementingIndex = ($page - 1) * $perPage + $index + 1;
                                @endphp
                                <tr>
                                    <td class="tx-color-03 tx-normal text-center">{{ $incrementingIndex }}</td>
                                    <td class="tx-medium text-left">{{ str_replace("_", " ", $singledata->product->name ?? '') }}</td>
                                    <td class="text-left">{{$singledata->batch->code??"" }}</td>
                                    <td class="text-left">{{ $singledata->code_data }}</td>
                                    <td class="text-center text-danger">{{ \Carbon\Carbon::parse($singledata->created_at)->format('d-m-Y') }}</td>
                                    <td class="text-center">
                                        <form id="statusform" method="POST">
                                            @csrf
                                            <div class="mx-auto" style="text-align: center;">
                                                @if($singledata->status == 'Active')
                                                <button class="btn btn-sm btn-outline-success" type="button" onclick="changestatus('Inactive','{{$singledata->id}}')" {{ empty($singledata->product->name) ? 'disabled' : '' }}>
                                                    <i class="fas fa-thumbs-up"></i>
                                                </button>
                                                @else
                                                <button class="btn btn-sm btn-outline-danger" type="button" onclick="changestatus('Active','{{$singledata->id}}')" {{ empty($singledata->product->name) ? 'disabled' : '' }}>
                                                    <i class="fas fa-thumbs-down"></i>
                                                </button>
                                                @endif

                                                @if(!empty($singledata->product->name))
                                                <a href="{{$singledata->url}}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-link"></i>
                                                </a>
                                                @else
                                                <button class="btn btn-sm  btn-outline-primary" disabled>
                                                    <i class="fas fa-link"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </form>
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
                </div>
            </div><!-- card -->

            <div class="mt-3">
                {{ $qrdatas->links('pagination::bootstrap-5') }}
            </div>
        </div>
        <!-- Modal for bulk actions -->
        <div class="modal fade" id="bulkActionModal" tabindex="-1" role="dialog" aria-labelledby="bulkTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="bulkForm" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="bulkTitle">Bulk Action</h5>
                            <button type="button" onclick="closemodal()" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="floating-label">Start Code</label>
                                        <input type="text" name="start_code" class="form-control" placeholder="Start Code" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="floating-label">Quantity</label>
                                        <input type="number" min="1" name="quantity" class="form-control" placeholder="Quantity" required value="1">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="floating-label">Action</label>
                                        <select name="action" class="form-control">
                                            <option value="active">Activate</option>
                                            <option value="inactive">Deactivate</option>
                                            <option value="Export">Export</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closemodal()" data-dismiss="modal">
                                Close
                            </button>
                            <button class="btn btn-md btn-custom float-right">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Status Change</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="confirmStatusChange()" class="btn btn-primary">Confirm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<!-- jQuery -->
<!-- Custom JavaScript -->
<script>
    // Function to close modal
    function closemodal() {
        $('#bulkActionModal').modal('hide');
    }

    // Function to show modal
    function showmodal() {
        $('#bulkActionModal').modal('show');
    }

    // Function to submit form for import
    function submitForm() {
        document.getElementById('importForm').submit();
    }

    // Function to update status
    function updateStatus(status) {
        if (confirm('Are you sure to change the Status?')) {
            document.getElementById('statusInput').value = status;
            document.getElementById('updateForm').submit();
        }
    }

    // jQuery to handle bulk action form submission
    $(document).ready(function() {
        $('#bulkForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var url = '{{url("")}}';
            $.ajax({
                type: 'POST',
                url: "{{ route('batches.bulstatuschange') }}",
                data: formData,
                success: function(response) {
                    if (response.status == 'Status updated successfully') {
                        $('#bulkActionModal').modal('hide');
                        showStatusMessage('Status Updated successfully');
                    } else if (response.status == 'Invalid or missing start_code or quantity') {
                        $('#bulkActionModal').modal('hide');
                        errorMessage('Invalid or missing start_code or quantity');
                    } else {
                        var downloadUrl = '{{ url("download") }}/' + response.filename;

                        // Trigger download using hidden iframe
                        var iframe = document.createElement('iframe');
                        iframe.style.display = 'none';
                        iframe.src = downloadUrl;
                        document.body.appendChild(iframe);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });

    function showStatusMessage(message) {
        var statusMessageElement = document.getElementById('statusMessage');
        if (statusMessageElement) {
            statusMessageElement.textContent = message; // Set the message content
            statusMessageElement.style.display = 'block'; // Show the message
        }
        setTimeout(function() {
            statusMessageElement.style.display = 'none'; // Hide the message
        }, 5000); // 5000 milliseconds = 5 seconds
    }

    function errorMessage(message) {
        var statusMessageElement = document.getElementById('errorMessage');
        if (statusMessageElement) {
            statusMessageElement.textContent = message; // Set the message content
            statusMessageElement.classList.remove('alert-success');
            statusMessageElement.classList.add('alert-danger');
            statusMessageElement.style.display = 'block'; // Show the message
            setTimeout(function() {
                statusMessageElement.style.display = 'none'; // Hide the message
            }, 5000); // 5000 milliseconds = 5 seconds
        }
    }
</script>
<script>
    var statusToChange;
    var requestId;

    function changestatus(value, id) {
        $('#statusModal').modal('show'); // Show the modal
        statusToChange = value; // Store the value
        requestId = id; // Store the id
    }

    function confirmStatusChange() {
        var url = `{{ route('qrcodes.update', ':id') }}`.replace(':id', requestId);

        $.ajax({
            type: 'PUT',
            url: url,
            data: {
                _token: '{{ csrf_token() }}',
                status_to_change: statusToChange
            },
            success: function(response) {
                // Handle success, e.g., reload the page or update UI
                location.reload(); // Example: reload the page to see the update
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });

        $('#statusModal').modal('hide'); // Hide the modal
    }
</script>
@endsection
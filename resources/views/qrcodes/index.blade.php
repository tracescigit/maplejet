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
                @if(session('status'))
                <div id="statusMessage" class="alert alert-success" style="background-color:#34eb86">{{session('status')}}</div>

                <div id="errorMessage" class="alert alert-danger" style="background-color:#eb3434">
                    {{ session('status') }}
                </div>
                @endif

                <div id="statusMessage" class="alert alert-success" style="background-color:#34eb86; display:none;">
                    <!-- This content will be set dynamically by JavaScript -->
                </div>

            </div>
        </div>

        <!-- Info boxes -->
        <div class="d-sm-flex mx-auto mg-t-10 col-11">



            <div class="col-sm-3 col-lg-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary tx-teal elevation-1 op-6"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                    <div class="info-box-content" style="font-weight:bold;">
                        <span class="info-box-text">Last Code-Data</span>
                        <span class="info-box-number" style="justify-self:center">200236522</span>
                    </div>

                </div>
            </div>


            <div class="col-sm-3 col-lg-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info tx-teal elevation-1 op-6"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                    <div class="info-box-content" style="font-weight:bold;">
                        <span class="info-box-text">Total Code-Data</span>
                        <span class="info-box-number" style="justify-self:center">10000</span>
                    </div>
                </div>
            </div>

            <div class="col-sm-3 col-lg-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-pink elevation-1 op-4"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                    <div class="info-box-content" style="font-weight:bold;">
                        <span class="info-box-text">Active</span>
                        <span class="info-box-number" style="justify-self:center">50</span>
                    </div>
                </div>
            </div>

            <div class="col-sm-3 col-lg-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-1 op-4"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                    <div class="info-box-content" style="font-weight:bold;">
                        <span class="info-box-text"> Inactive</span>
                        <span class="info-box-number" style="justify-self:center">9950</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card pd-20 mg-t-10 col-11 mx-auto">
            <h3 class="content-header mb-4">QR Code Data</h3>
            <!-- Button: Upload Qrcodes -->
            <div class="d-flex justify-content-between align-items-start">
                <a href="{{ route('qrcodes.create') }}" class="btn btn-custom mx-3 mb-2">
                    <img src="{{ tracesciimg('icons8-create-16.png') }}" style="max-width:18px;" class="me-2">
                    Upload Qrcodes
                </a>
                <!-- Search Form -->
                <form class="form-inline mr-4" method="GET" action="{{ route('qrcodes.index') }}">
                    <input type="search" name="products_search" class="form-control mr-3" placeholder="Search By Product" aria-label="Search">
                    <input type="search" name="qrcode_search" class="form-control mr-3" placeholder="Search By Code" aria-label="Search">

                    <select class="form-select mr-3 p-1" name="products_assigned" aria-label="Default select example">
                        <option value="assigned" {{ request('products_assigned') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                        <option value="unassigned" {{ request('products_assigned') == 'unassigned' ? 'selected' : '' }}>Unassigned</option>
                    </select>
                    <button class="btn-primary " type="submit">Search</button>
                </form>
                <div class="form-group mx-sm-3 mb-2">

                    <!-- Bulk Action Form -->
                    <form id="importForm" action="{{ route('batches.import') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <button onclick="showmodal()" type="button" class="btn btn-custom" style="background-color: #ffa500;">
                            <img src="{{ tracesciimg('icons8-action-64.png') }}" style="max-width: 18px;" class="me-2">
                            Bulk Action
                        </button>
                        <a href="{{ route('bulkuploads.index') }}" class="btn btn-custom"> Bulk Uploads</a>
                        <input type="file" id="fileInput" name="file" style="display: none;" onchange="submitForm()">
                        <button type="submit" style="display: none;">Import</button>
                    </form>
                </div>
            </div>

            <!-- QR Code data table -->
            <div class="table-responsive">
                <table class="table table-dashboard">
                    <thead>
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-left">Product Name</th>
                            <th class="text-left">Batch Name</th>
                            <th class="text-left">Code Data</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Action</th>
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
                            <td class="tx-medium text-left">{{$singledata->batch->code??"" }}</td>
                            <td class="text-left">{{ $singledata->code_data }}</td>
                            <td class="text-center text-danger">{{ \Carbon\Carbon::parse($singledata->created_at)->format('d-m-Y') }}</td>
                            <td>
                                <form action="{{ route('qrcodes.update', $singledata->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mx-auto" style="text-align: center;">
                                        

                                        @if($singledata->status == 'Active')
                                        <button class="btn btn-sm btn-success" type="submit" onclick="return confirm('Are you sure to change the Status?')" {{ empty($singledata->product->name) ? 'disabled' : '' }}>
                                            <i class="fas fa-thumbs-up"></i> Active
                                        </button>
                                        <input type="hidden" name="status_to_change" value="Inactive">
                                        @else
                                        <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure to change the Status?')" {{ empty($singledata->product->name) ? 'disabled' : '' }}>
                                            <i class="fas fa-thumbs-down"></i> Inactive
                                        </button>
                                        <input type="hidden" name="status_to_change" value="Active">
                                        @endif

                                        @if(!empty($singledata->product->name))
                                        <a href="{{ $singledata->url }}" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-link"></i> Link
                                        </a>
                                        @else
                                        <button class="btn btn-sm btn-primary" disabled>
                                            <i class="fas fa-link"></i> Link
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
                <!-- Pagination links -->
                {{ $qrdatas->links('pagination::bootstrap-5') }}
            </div>
        </div>
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
                        <i class="fas fa-times"></i> Close
                    </button>
                    <button class="btn btn-md btn-primary float-right">
                        <i class="fas fa-download"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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
@endsection
@extends('dummy.app_new')

@section('content')
<style>
    /* Custom button styles */
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
    #exampleModal .modal-content {
        border-radius: 10px;
    }

    #exampleModal .modal-header {
        background-color: #343a40;
        color: white;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    #exampleModal .modal-body {
        padding: 20px;
    }

    #exampleModal .modal-footer {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }
</style>
<div class="content content-components">
    <div class="container">
        <div class="d-flex bg-gray-10">
            <div class="pd-10 flex-grow-1">
                <h4 id="section3" class="mg-b-10 font-weight-bolder">System Alerts</h4>
                <p class="mg-b-30">Use this page to <code style="color:#e300be;">View</code> System Reports .</p>
            </div>

            <div class="pd-10 mg-l-auto">
                <a href="#" class="btn btn-custom btn-icon" type="submit"><i data-feather="plus-circle" class="mr-1"></i> Export</a>
            </div>
        </div>
        <div data-label="search" class="df-example demo-table">
            <form method="GET" action="{{ route('systemalerts') }}">
                <div class="row row-sm mg-b-10">
                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <label>Start Date: </label>
                        <input type="date"
                            name="start_date"
                            class="form-control"
                            value="{{ old('start_date', request('start_date')) }}">
                    </div>
                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <label>End Date: </label>
                        <input type="date"
                            name="end_date"
                            class="form-control"
                            value="{{ old('end_date', request('end_date')) }}">
                    </div>
                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <button type="submit" class="btn btn-secondary" style="margin-top: 28px;"><i data-feather="search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div data-label="System Alerts" class="df-example demo-table">
            <div class="table-responsive">
                <table class="table table-striped mg-b-0">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center font-weight-bold">ID</th>
                            <th scope="col" class="text-left font-weight-bold">Product</th>
                            <th scope="col" class="text-left font-weight-bold">Batch</th>
                            <th scope="col" class="text-left font-weight-bold">Issue</th>
                            <th scope="col" class="text-left font-weight-bold">Logged On</th>
                            <th scope="col" class="text-center font-weight-bold">View Details</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($systemalerts as $index=>$singledata)
                        @php
                        $page = $systemalerts->currentPage();
                        $perPage = $systemalerts->perPage();
                        $incrementingIndex = ($page - 1) * $perPage + $index + 1;
                        @endphp

                        <tr>
                            <td class="tx-color-03 tx-normal text-center">{{ $incrementingIndex }}</td>
                            <td class="tx-medium text-left"> {{$singledata->product}}</td>
                            <td class="tx-medium text-left"> {{$singledata->batches->code}}</td>
                            <td class="tx-medium text-left"> {{$singledata->report_reason}}</td>
                            <td class="tx-medium text-left"> {{ \Carbon\Carbon::parse($singledata->created_at)->format('d-m-Y') }}</td>
                            <td class="tx-medium text-center">
                                <a type="button" class="btn btn-outline-primary" href="{{route('systemalerts.systemalertshow',$singledata->id)}}">
                                    <i class="fas fa-eye"></i></a>
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
            {{ $systemalerts->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
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
            $('.btn-primary').text('Please wait...');
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: "{{route('batches.bulstatuschange')}}",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        var link = document.createElement('a');
                        // Assuming `response.filename` contains the filename you want to append
                        const filename = response.filename;

                        // Get the current page's base URL
                        const baseUrl = window.location.origin;

                        // Construct the full URL
                        const fullUrl = `${baseUrl}/${filename}`;

                        // Assuming `link` is a reference to your link element
                        link.href = fullUrl;

                        link.download = response.filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    } else {

                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
<script>
    function openModal(singledata) {
        $('#exampleModal').modal('show');
        $('#modal-card-body').html('');
        console.log(singledata);
        var html = '<div class="row">' +
            '<div class="col-md-6"><label class="mb-0">Issue:</label><p>' + singledata.report_reason + '</p></div>' +
            '<div class="col-md-6"><label class="mb-0">Description:</label><p>' + singledata.description + '</p></div>' +
            '<div class="col-md-6"><label class="mb-0">Image:</label><p>' + singledata.image + '</p></div>' +
            '<div class="col-md-6"><label class="mb-0">Lat:</label><p>' + singledata.lat + '</p></div>' +
            '<div class="col-md-6"><label class="mb-0">Long:</label><p>' + singledata.long + '</p></div>' +
            '<div class="col-md-6"><label class="mb-0">IP:</label><p>' + singledata.ip + '</p></div>' +
            '<div class="col-md-6"><label class="mb-0">Mobile:</label><p>' + singledata.mobile + '</p></div>' +
            '</div>';
        $('#modal-card-body').html(html);
    }

    function closemodal() {
        $('#exampleModal').modal('hide');
    }
</script>
@endsection
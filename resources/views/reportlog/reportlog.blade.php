@extends('dummy.app_new')

@section('content')
<style>
    /* Custom button styles */
    .btn-custom {
        background: linear-gradient(45deg, #700877 0%, #ff2759 100%);
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

<div class="wrapper">
    <div class="main-panel" id="main-panel">
    <div class="row">
                <div class="col-md-12">
                        @if(session('status'))
                        <div id="statusMessage" class="alert alert-success" style="background-color:#34eb86">{{session('status')}}</div>
                        @endif
                        @if(session('error'))
                        <div id="errorMessage" class="alert alert-danger" style="background-color:#eb3434">
                            {{ session('error') }}
                        </div>
                        @endif

                <div class="card pd-20 mg-t-10 col-11 mx-auto">
                    <h3 class="content-header mg-b-25">Consumer Feedback </h3>
                    <div class="d-flex justify-content-end align-items-start mb-3">
                        <form class="form-inline mr-4" method="GET" action="{{route('reportlog.exceldownload')}}">
                           
                        
                            <div class="form-group mx-sm-3 mb-2 ">
                                <label class="mx-4">Start Date: </label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label class="mx-4">End Date</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                            <button class="btn btn-custom" type="submit">Download Report Excel</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-dashboard mg-b-0">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-left">Issue</th>
                                    <th class="text-left">Description</th>
                                    <th class="text-center">View Details</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($reportlog as $index=>$singledata)
                                @php
                                $page = $reportlog->currentPage();
                                $perPage = $reportlog->perPage();
                                $incrementingIndex = ($page - 1) * $perPage + $index + 1;
                                @endphp

                                <tr>
                                    <td class="tx-color-03 tx-normal text-center">
                                        {{ $incrementingIndex }}
                                    </td>
                                    <td class="tx-medium text-left ">
                                    {{$singledata->report_reason}}
                                    </td>
                                    <td class="text-left">
                                    {{$singledata->description}}
                                    </td>
                                    <td class="text-center">
                                        <a type="button" class="btn btn-outline-primary" href="{{route('reportlog.show',$singledata->id)}}">
                                            <i class="fas fa-eye mr-2"></i> View Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $reportlog->links('pagination::bootstrap-5') }}

                    </div>
                </div>
            </div>
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
                        console.log(response);
                        console.log(response);
                        var link = document.createElement('a');
                        link.href = 'http://192.168.0.166:8000/' + response.filename;
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


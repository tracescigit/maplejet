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
        display: flex;
        margin-bottom: 1rem;
        padding: .5rem;
    }

    .info-box .info-box-icon {
        border-radius: .25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.875rem;
        width: 70px;
        background-color: #17a2b8;
        color: #ffffff;
    }

    .info-box .info-box-content {
        flex: 1;
        padding: 0 10px;
    }

    .info-box .info-box-number {
        font-size: x-large;
        margin-left: 37px;
    }
</style>

<div class="content content-components">
    <div class="main-panel" id="main-panel">
        <div class="row">
            <div class="col-md-12">
                @if(session('status'))
                <div id="statusMessage" class="alert alert-success mt-2">{{ session('status') }}</div>
                @endif



                <div class="card pd-20 mg-t-10 col-11 mx-auto">
                    <h3 class="content-header mg-b-25">User Log</h3>
                    <div class="d-flex justify-content-end align-items-start mb-3">
                        <form id="userlog-form" class="form-inline mr-4" method="GET">
                            <input type="hidden" name="action" id="form-action" value="search">

                            <div class="form-group mb-2">
                                <label class="mx-4">Select User: </label>
                                <select class="form-control mr-2" name="user">
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mx-sm-3 mb-2 ">
                                <label class="mx-4">Start Date: </label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label class="mx-4">End Date: </label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                            <button class="btn btn-primary mb-2" type="submit" onclick="submitForm('search')">Search</button>
                            <button class="btn btn-custom mr-3 mb-2" type="submit" onclick="submitForm('export')">Export Excel</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-dashboard mg-b-0">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-left">Module Name</th>
                                    <th class="text-left">Details</th>
                                    <th class="text-left">UserId</th>
                                    <th class="text-center">Date & Time</th>
                                    <th class="text-center">View Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userlog as $index=>$singledata)
                                @php
                                $page = $userlog->currentPage();
                                $perPage = $userlog->perPage();
                                $incrementingIndex = ($page - 1) * $perPage + $index + 1;
                                @endphp
                                <tr>
                                    <td class="tx-color-03 tx-normal text-center">
                                        {{ $incrementingIndex }}
                                    </td>
                                    <td class="tx-medium text-left ">
                                        {{$singledata->log_name}}
                                    </td>
                                    <td class="text-left">
                                        {{ \Illuminate\Support\Str::limit($singledata->description, 30, '...') }}
                                    </td>
                                    <td class="text-left">
                                        {{$singledata->user->name??""}}
                                    </td>
                                    @php
                                    $dateTime = new DateTime($singledata->created_at);
                                    $formattedDate = $dateTime->format('d M Y');
                                    $formattedTime = $dateTime->format('h:i A');
                                    @endphp
                                    <td class="text-center text-danger">
                                        {{ $dateTime->format('d M Y') }}. {{ $dateTime->format('h:i A') }}
                                    </td>
                                    <td class="text-center">
                                        <a type="button" class="btn btn-outline-primary " href="{{route('userlog.show',$singledata->id)}}">View Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color:#f5f5ef;">
                                        <h5 class="modal-title">User Details Log</h5>
                                        <button type="button" onclick="closemodal()" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-content">
                                        <div class="p-3" id="modal-card-body">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    {{ $userlog->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

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
</script>
<script>
    function submitForm(actionType) {
        // Set the action attribute based on the button clicked
        document.getElementById('form-action').value = actionType;

        // Adjust the form action URL based on the action type
        var form = document.getElementById('userlog-form');
        if (actionType === 'search') {
            form.action = '{{ route("userlog.index") }}';
        } else if (actionType === 'export') {
            form.action = '{{ route("userlog.downloadexcel") }}';
        }
    }

    function openModal(singledata) {
        var name = '';
        if (singledata.user) {
            name = singledata.user.name;
        }

        $.ajax({
            type: 'GET',
            url: "{{route('populatemodal')}}",
            data: singledata,
            success: function(response) {
                $('#modal-card-body').html(''); // Clear the modal content
                console.log(response);

                function generateKeyValueHTML(obj, title) {
                    var html = '<div class="col-md-12"><h5>' + title + '</h5></div>';
                    for (var key in obj) {
                        if (obj.hasOwnProperty(key)) {
                            html += '<div class="col-md-6"><label class="mb-0">' + key + ':</label><p>' + obj[key] + '</p></div>';
                        }
                    }
                    return html;
                }
                var html = '<div class="row">' +
                    '<div class="col-md-6"><label class="mb-0">Module Name:</label><p>' + singledata.log_name + '</p></div>' +
                    '<div class="col-md-6"><label class="mb-0">Description:</label><p>' + singledata.description + '</p></div>' +
                    '<div class="col-md-6"><label class="mb-0">Event:</label><p>' + singledata.event + '</p></div>' +
                    '<div class="col-md-6"><label class="mb-0">User Name:</label><p>' + name + '</p></div>' +
                    generateKeyValueHTML(response.new_data, 'New Attributes') +
                    generateKeyValueHTML(response.old_data, 'Old Attributes') +
                    '</div>';
                $('#modal-card-body').html(html); // Insert new content
                $('#exampleModal').modal('show'); // Show the modal
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Log any errors to the console
            }
        });
    }

    function closemodal() {
        $('#exampleModal').modal('hide');
    }
</script>
@endsection
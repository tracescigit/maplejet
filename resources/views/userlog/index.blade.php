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


@if(session('status'))
<div id="statusMessage" class="alert alert-success mt-2">{{ session('status') }}
</div>
@endif

<div class="content content-components">
    <div class="container">
        <div class="d-flex bg-gray-10">
            <div class="pd-10 flex-grow-1">
                <h4 id="section3" class="mg-b-10 font-weight-bolder">Userlog</h4>
                <p class="mg-b-30">Use this page to <code style="color:#e300be;">View</code> Recent activities .</p>
            </div>

            <div class="pd-10 mg-l-auto">
                <button type=" button" class="btn btn-custom btn-icon" type="submit" onclick="submitForm('export')"><i data-feather="download" class="mr-1"></i> Export</button>
            </div>
        </div>





        <div data-label="Search" class="df-example demo-table">
            <form method="GET" id="userlog-form" action="{{ route('userlog.index') }}">
                <div class="row row-sm  mg-b-10">
                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <label>Select User: </label>
                        <select class="form-control mr-2" name="user">
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user', request('user')) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <label>Start Date: </label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ old('start_date', request('start_date')) }}">
                    </div>
                    <div class="col-sm-3 mg-t-10  mg-sm-t-0">
                        <label>End Date: </label>
                        <input type="date" name="end_date" class="form-control"
                            value="{{ old('end_date', request('end_date')) }}">
                    </div>
                    <div class="col-sm-3 mg-t-10  mg-sm-t-0">
                        <!-- <button type="button" class="btn btn-secondary"><i data-feather="download"></i> Export</button> -->
                        <button type="submit" class="btn btn-secondary" style="margin-top: 28px;"><i data-feather="search"></i></button>
                    </div>
                </div>

            </form>
        </div>
        <div data-label="Logs" class="df-example demo-table mg-t-20">
            <div class="table-responsive">
                <table class="table table-striped mg-b-0">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center font-weight-bold">ID</th>
                            <th scope="col" class="text-left font-weight-bold">Module Name</th>
                            <th scope="col" class="text-left font-weight-bold">Details</th>
                            <th scope="col" class="text-left font-weight-bold">UserId</th>
                            <th scope="col" class="text-center font-weight-bold">Date & Time</th>
                            <th scope="col" class="text-center font-weight-bold">View Details</th>


                        </tr>
                    </thead>
                    <tbody>
                        @forelse($userlog as $index=>$singledata)
                        @php
                        $page = $userlog->currentPage();
                        $perPage = $userlog->perPage();
                        $incrementingIndex = ($page - 1) * $perPage + $index + 1;
                        @endphp
                        <tr>
                            <td class="tx-color-03 tx-normal text-center">{{ $incrementingIndex }}</td>
                            <td class="tx-medium text-left">{{$singledata->log_name}}</td>
                            <td class="tx-medium text-left"> {{ \Illuminate\Support\Str::limit($singledata->description, 30, '...') }}</td>
                            <td class="text-left"> {{$singledata->user->name??""}}</td>
                            @php
                            $dateTime = new DateTime($singledata->created_at);
                            $formattedDate = $dateTime->format('d M Y');
                            $formattedTime = $dateTime->format('h:i A');
                            @endphp
                            <td class="text-center"> {{ $dateTime->format('d M Y') }}. {{ $dateTime->format('h:i A') }}</td>
                            <td class="tx-medium text-center">
                                <a type="button" class="btn btn-outline-primary" href="{{route('userlog.show',$singledata->id)}}"> <i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center" style="color:red">---No data found ---</td> <!-- Adjust colspan based on the number of columns -->
                        </tr>
                        @endforelse
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

            </div><!-- table-responsive -->


            <div class="mt-3">
                {{ $userlog->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div><!-- card -->



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
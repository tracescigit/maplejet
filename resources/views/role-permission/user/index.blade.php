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
    <div class="container pd-20 mg-t-10 col-10 mx-auto">
        <div class="d-flex bg-gray-10">
            <div class="pd-10 flex-grow-1">
                <h4 id="section3" class="mg-b-10">User Data</h4>
                <p class="mg-b-30">Use <code>Add New</code> page to Create <code>New</code> User .</p>
            </div>

            <div class="pd-10 mg-l-auto">
                <a href="{{ route('users.create') }}"><button type=" button" class="btn btn-custom btn-icon"><i data-feather="plus-circle"></i> Add New</button></a>
                <a href="{{ route('permissions.index') }}" class="btn btn-custom ">Permissions</a>
                <a href="{{ route('roles.index') }}" class="btn btn-custom">Roles</a>
            </div>
        </div>
        <div data-label="Users" class="df-example demo-table">
        <div class="table-responsive">
            <table class="table table-striped mg-b-0">
                <thead>
                    <tr>
                        <th scope="col" class="text-left font-weight-bold">ID</th>
                        <th scope="col" class="text-left font-weight-bold"> Name</th>
                        <th scope="col" class="text-left font-weight-bold">Email</th>
                        <th scope="col" class="text-left font-weight-bold">Status</th>
                        <th scope="col" class="text-center font-weight-bold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index=> $user)
                    @php
                    $page = $users->currentPage();
                    $perPage = $users->perPage();
                    $incrementingIndex = ($page - 1) * $perPage + $index + 1;
                    @endphp
                    <tr>
                        <td class="tx-color-03 tx-normal text-left">{{ $incrementingIndex }}</td>
                        <td class="tx-medium text-left">{{ $user->name }}</td>

                        <td class="text-left ">{{ $user->email }}</td>

                        <td class="text-left ">@if($user->status == 'Active')
                            <span class="tx-10 badge badge-success">{{$user->status}}</span>
                            @else
                            <span class="tx-10 badge badge-danger">{{$user->status}}</span>
                            @endif
                        </td>
                        <td class="text-center">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-primary"><i class="fas fa-edit" style="color: #74C0FC; font-size:18px;"></i></a>
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


        <div class="mt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div><!-- card -->
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Users for Role: <span id="roleName"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        <!-- Dynamic content goes here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
    function openModal(id, name, email, roles) {

        var html = '<tr>' +
            '<td><strong>ID:</strong></td>' +
            '<td>' + id + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td><strong>NAME:</strong></td>' +
            '<td>' + name + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td><strong>EMAIL:</strong></td>' +
            '<td>' + email + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td><strong>ROLES:</strong></td>'
        '<td>' + roles + '</td>'
        '</tr';

        $('#table-body').html(html);
        $('#myModal').modal('show');
    }
</script>
<script>
    function closemodal() {
        $('#myModal').modal('hide');
    }
</script>

@endsection
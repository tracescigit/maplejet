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


<div class="row">
    <div class="col-md-12">
        @if(session('status'))
        <div id="statusMessage" class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card pd-20 mg-t-8 col-11 mx-auto">
            <h3 class="content-header mg-b-25">Roles</h3>
            <div class="d-flex align-items-start">
                <a href="{{ route('roles.create') }}" class="btn btn-custom  ml-3 mb-2">
                    <img src="{{ tracesciimg('icons8-create-16.png') }}" class="mr-1">{{ __('Add Role') }}
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-dashboard mg-b-0">
                    <thead>
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-left">Name</th>
                            <th class="text-left">Emails</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $index=> $role)
                        @php
                        $page = $roles->currentPage();
                        $perPage = $roles->perPage();
                        $incrementingIndex = ($page - 1) * $perPage + $index + 1;
                        @endphp

                        <tr>
                            <td class="text-center">{{ $incrementingIndex }}
                            </td>
                            <td class="text-left">{{ $role->name }}</td>
                            <td class="text-left">{{ $role->email }}</td>
                            @php
                            $dateTime = new DateTime($role->created_at);
                            $formattedDate = $dateTime->format('d M Y');
                            $formattedTime = $dateTime->format('h:i:s');
                            @endphp
                            <td class="text-center text-success">
                                {{ $dateTime->format('d M Y') }}. {{ $dateTime->format('h:i:s') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-outline-primary"><i class="fas fa-edit" style="color: #74C0FC; font-size:18px;"></i></a>
                                <a href="{{route('manageroles',$role->id)}}" class="btn btn-warning btn-sm">Add/Edit Role</i></a>
                               
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $roles->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script>
    function openModal(id) {
        // Replace with your AJAX implementation to fetch and show modal content
        alert('Implement your AJAX logic here to fetch and display modal content.');
    }
</script>

@endsection
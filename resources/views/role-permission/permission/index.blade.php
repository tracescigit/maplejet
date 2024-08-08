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
    </div>
</div>
<div class="content content-components">
    <div class="card pd-20 mg-t-10 col-10 mx-auto">
        <div class="d-flex bg-gray-10">
            <div class="pd-10 flex-grow-1">
                <h4 id="section3" class="mg-b-10">Permissions</h4>
                <p class="mg-b-30">Use this page to Create <code>New</code> Permission .</p>
            </div>

            <div class="pd-10 mg-l-auto">
                <a href="{{ route('permissions.create') }}"><button type=" button" class="btn btn-custom btn-icon"><i data-feather="plus-circle"></i> Add New</button></a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped mg-b-0">
                <thead>
                    <tr>
                        <th scope="col" class="text-left font-weight-bold">ID</th>
                        <th scope="col" class="text-left font-weight-bold"> Name</th>
                        <th scope="col" class="text-center font-weight-bold">Created At</th>
                        <th scope="col" class="text-center font-weight-bold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $index => $permission)
                    @php
                    $page = $permissions->currentPage();
                    $perPage = $permissions->perPage();
                    $incrementingIndex = ($page - 1) * $perPage + $index + 1;
                    @endphp
                    <tr>
                        <td class="tx-color-03 tx-normal text-left">{{ $incrementingIndex }}</td>
                        <td class="tx-medium text-left">{{$permission->name}}</td>
                        @php
                        $dateTime = new DateTime($permission->created_at);
                        $formattedDate = $dateTime->format('d M Y');
                        $formattedTime = $dateTime->format('h:i:s');
                        @endphp
                        <td class="text-center text-danger"> {{ $dateTime->format('d M Y') }}. {{ $dateTime->format('h:i:s') }}</td>
                        <td class="text-center">
                            <form action="{{route('permissions.destroy',$permission->id)}}" method="POST">
                                <a href="{{route('permissions.edit',$permission->id)}}" class="btn btn-outline-primary"><i class="fas fa-edit" style="color: #74C0FC;font-size:18px;"></i></a>

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


        <div class="mt-3">
            {{ $permissions->links('pagination::bootstrap-5') }}
        </div>
    </div><!-- card -->
</div>






<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script>
    function openModal(id) {
        // Replace with your AJAX implementation to fetch and show modal content
        alert('Implement your AJAX logic here to fetch and display modal content.');
    }
</script>

@endsection
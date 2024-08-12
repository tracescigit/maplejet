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
        /* background-color: #8a0278; */
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
        /* background-color: #343a40; */
        color: white;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    #myModal .modal-footer {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

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
                <h5 class="modal-title">Production Plant Details</h5>
                <button type="button" onclick="closeModal()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tbody id="table-body">
                        <!-- Modal content dynamically populated here -->
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
        <div id="statusMessage" class="alert alert-success mt-2" style="background-color:#34eb86">{{session('status')}}</div>
        @endif

        <div class="content content-components">



            <div class="container pd-20 mg-t-10 col-10 mx-auto">
                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10">Create Production-Plants</h4>
                        <p class="mg-b-30">Use this page to add <code>NEW</code> production-Plant.</p>
                    </div>

                    <div class="pd-10 mg-l-auto">
                        <a href="{{ route('production-plants.create') }}"><button type=" button" class="btn btn-custom btn-icon"><i data-feather="plus-circle"></i> Add New</button></a>
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
                                    <h6 class="tx-sans tx-uppercase tx-05 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">Last Prod.Plant</h6>
                                    <h4 class="tx-10 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{$last_added_plplant->name??"--"}}</h4>
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
                                    <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{count($productionplant)}}</h4>
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
                                    <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8"> Inactive</h6>
                                    <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{ count($productionplant) - $prodactiveCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div><!-- row -->
                </div>

                <form method="GET" action="{{ route('production-plants.index') }}">
                    <div data-label="Prod. list" class="df-example demo-table">
                        <div class="row row-sm mg-b-10">
                            <div class="col-sm-3">
                                <input type="text"
                                    name="plants_search"
                                    class="form-control"
                                    placeholder="code"
                                    value="{{ old('plants_search', request('plants_search')) }}">
                            </div>
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <input type="text"
                                    name="plants_name_search"
                                    class="form-control"
                                    placeholder="name"
                                    value="{{ old('plants_name_search', request('plants_name_search')) }}">
                            </div>
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <button type="submit" class="btn btn-secondary">
                                    <i data-feather="search"></i>
                                </button>
                                <!-- <button type="button" class="btn btn-secondary"><i data-feather="download"></i> Export</button> -->
                            </div>
                        </div>
                    </div>
                </form>



                <div class="table-responsive">
                    <table class="table table-striped mg-b-0">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center font-weight-bold">ID</th>
                                <th scope="col" class="text-left font-weight-bold">Plant Code</th>
                                <th scope="col" class="text-left font-weight-bold">Plant Name</th>
                                <th scope="col" class="text-center font-weight-bold">Status</th>
                                <th scope="col" class="text-center font-weight-bold">Created On</th>
                                <th scope="col" class="text-center font-weight-bold">Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productionplant as $index => $singleplant)
                            @php
                            $page = $productionplant->currentPage();
                            $perPage = $productionplant->perPage();
                            $incrementingIndex = ($page - 1) * $perPage + $index + 1;
                            @endphp
                            <tr>
                                <td class="tx-color-03 tx-normal text-center">{{ $incrementingIndex }}</td>
                                <td class="tx-medium text-left">{{$singleplant->code}}</td>
                                <td class="text-left">{{$singleplant->name}}</td>
                                <td class="tx-medium text-center">
                                    @if($singleplant->status == 'Active')
                                    <span class="badge badge-success"> {{$singleplant->status}}</span>
                                    @else
                                    <span class="badge badge-danger"> {{$singleplant->status}}</span>
                                </td>
                                @endif
                                <td class="text-center text-danger">
                                    {{ \Carbon\Carbon::parse($singleplant->created_at)->format('d-m-Y') }}
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-outline-primary float-center" type="button" href="{{route('production-plants.show',$singleplant->id)}}"><i class="fas fa-eye" style="color: #63E6BE;"></i></a>
                                    <a href="{{route('production-plants.edit',$singleplant->id)}}" class="btn btn-outline-primary float-center"><i class="fas fa-edit" style="color: #74C0FC;"></i></a>
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
                {{ $productionplant->links('pagination::bootstrap-5') }}
            </div>
        </div>

        @endsection




        @section('js')
        <script>
            function openModal(id, plantscode, plantsname) {
                console.log(id, plantscode, plantsname);
                var html = '<tr>' +
                    '<td><strong>ID:</strong></td>' +
                    '<td>' + id + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><strong>PLANTS-CODE:</strong></td>' +
                    '<td>' + plantscode + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><strong>PLANTS-NAME:</strong></td>' +
                    '<td>' + plantsname + '</td>' +
                    '</tr>' +
                    '<tr>';
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
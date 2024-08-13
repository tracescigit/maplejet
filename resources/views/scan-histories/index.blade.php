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
        background-color: #343a40;
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

<div class="content content-components">



    <div class="container pd-20 mg-t-10 col-10 mx-auto">
        <div class="d-flex bg-gray-10">
            <div class="pd-10 flex-grow-1">
                <h4 id="section3" class="mg-b-10">Scan History</h4>
                <p class="mg-b-30">Use this page to <code>View</code> Scan History.</p>
            </div>

            <div class="pd-10 mg-l-auto">
                <button type="button" onclick="scandownload()" class="btn btn-custom"><i data-feather="download"></i> Export</button>
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
                            <h6 class="tx-sans tx-uppercase tx-05 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">Last Scanned</h6>
                            <h4 class="tx-10 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{$last_added_history->qr_code??""}}</h4>
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
                            <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{$scan_count}}</h4>
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
                            <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">Genuine</h6>
                            <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{$genuine}}</h4>
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
                            <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8"> Suspicious</h6>
                            <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{ $scan_count - $genuine }}</h4>
                        </div>
                    </div>
                </div>
            </div><!-- row -->
        </div>

        <form method="GET" action="{{ route('scanhistories.index') }}">
            <div data-label="Product List" class="df-example demo-table">
                <div class="row row-sm mg-b-10">
                    <div class="col-sm-3">
                        <input type="text"
                            name="products_search"
                            class="form-control"
                            placeholder="Search By Product"
                            value="{{ old('products_search', request('products_search')) }}">
                    </div>
                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <input type="text"
                            name="genuine"
                            class="form-control"
                            placeholder="Search By Qr code"
                            value="{{ old('genuine', request('genuine')) }}">
                    </div>
                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <input type="text"
                            name="qrcode"
                            class="form-control"
                            placeholder="Search By Qr code"
                            value="{{ old('qrcode', request('qrcode')) }}">
                    </div>
                    <div class="col-sm-3 mg-t-10  mg-sm-t-0">
                        <button type="submit" class="btn btn-secondary"><i data-feather="search"></i></button>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped mg-b-0">
                <thead>
                    <tr>
                        <th scope="col" class="text-center font-weight-bold">ID</th>
                        <th scope="col" class="text-left font-weight-bold">Product</th>
                        <th scope="col" class="text-left font-weight-bold">Serial No</th>
                        <th scope="col" class="text-left font-weight-bold">IP Address</th>
                        <th scope="col" class="text-center font-weight-bold">Genuine</th>
                        <th scope="col" class="text-center font-weight-bold">Qr Code Scanned</th>
                        <th scope="col" class="text-center font-weight-bold">Scanned At</th>
                        <th scope="col" class="text-center font-weight-bold">Action</th>


                    </tr>
                </thead>
                <tbody>
                    @forelse($scanhistories as $index=>$product)
                    @php
                    $page = $scanhistories->currentPage();
                    $perPage = $scanhistories->perPage();
                    $incrementingIndex = ($page - 1) * $perPage + $index + 1;
                    $dateTime = new DateTime($product->updated_at);
                    $dateTime->modify('+5 hours +30 minutes');
                    $formattedDateTime = $dateTime->format('d-m-Y H:i:s');
                    @endphp
                    <tr>
                        <td class="tx-color-03 tx-normal text-center">{{ $incrementingIndex }}</td>
                        <td class="tx-medium text-left">{{$product->product}}</td>
                        <td class="tx-medium text-left">{{$product->batch}}</td>
                        <td class="text-left">{{$product->ip_address}}</td>

                        <td class="text-center">
                            @if ($product->genuine == 1)
                            <!-- Genuine product -->
                            <span class="badge tx-success" style="font-size: 15px;">Genuine</span>
                            @elseif ($product->genuine == 2)
                            <!-- Suspicious product -->
                            <span class="badge tx-warning" style="font-size: 15px;">Suspicious</span>
                            @else
                            <!-- Fake product -->
                            <span class="badge tx-danger" style="font-size: 15px;">Fake</span>
                            @endif
                        </td>

                        <td class="text-center">{{$product->qr_code}}</td>
                        <td class="text-center">{{$formattedDateTime}}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group" aria-label="Actions">
                                <a type="button" class="btn btn-outline-primary" href="{{route('scanhistories.show',$product->id)}}" title="View"><i class="fas fa-eye" style="color: #63E6BE;font-size:18px;"></i></a>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center" style="text-align: center; color: red;">
                            <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                                ---No data found ---
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- card -->

    <div class="mt-3">
        {{ $scanhistories->links('pagination::bootstrap-5') }}
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
    function openModal(id, name, brand, companyname) {
        var html = '<tr>' +
            '<td><strong>ID:</strong></td>' +
            '<td>' + id + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td><strong>NAME:</strong></td>' +
            '<td>' + name + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td><strong>BRAND:</strong></td>' +
            '<td>' + brand + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td><strong>COMPANY-NAME:</strong></td>' +
            '<td>' + companyname + '</td>' +
            '</tr>';

        $('#table-body').html(html);
        $('#myModal').modal('show');
    }

    function closeModal() {
        $('#myModal').modal('hide');
    }

    function scandownload() {
        window.location.href = "{{ route('scanhistoriesdownloadexcel') }}";
    };
</script>
@endsection
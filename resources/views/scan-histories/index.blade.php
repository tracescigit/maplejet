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

<div id="myModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Details</h5>
                <button type="button" onclick="closeModal()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tbody id="table-body">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="d-sm-flex mg-t-10 mx-auto col-11">
                   


                        <div class="col-sm-3 col-lg-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-primary  elevation-1 op-6"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                                <div class="info-box-content" style="font-weight:bold;">
                                    <span class="info-box-text">Last Scanned</span>
                                    <span class="info-box-number" style="justify-self:center">product1</span>
                                </div>

                            </div>
                        </div>


                        <div class="col-sm-3 col-lg-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info tx-teal elevation-1 op-6"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                                <div class="info-box-content" style="font-weight:bold;">
                                    <span class="info-box-text">Total Products</span>
                                    <span class="info-box-number" style="justify-self:center">10</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3 col-lg-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-pink elevation-1 op-4"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                                <div class="info-box-content" style="font-weight:bold;">
                                    <span class="info-box-text">Genuine</span>
                                    <span class="info-box-number" style="justify-self:center">5</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3 col-lg-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-primary elevation-1 op-4"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
                                <div class="info-box-content" style="font-weight:bold;">
                                    <span class="info-box-text">Suspicious</span>
                                    <span class="info-box-number" style="justify-self:center">5</span>
                                </div>
                            </div>
                        </div>
                </div>
<div class="wrapper">
    <div class="main-panel" id="main-panel">
        <div class="card pd-20 mg-t-10 col-11 mx-auto">
            <h3 class="content-header mg-b-25">Scan Histories</h3>
            <div class="d-flex justify-content-end align-items-start">
                <form class="form-inline mr-4" method="GET" action="{{ route('products.index') }}">
                    <div class="form-group mb-2">
                        <input type="search" name="products_search" class="form-control" placeholder="Search By Product" aria-label="Search">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="search" name="brands_search" class="form-control" placeholder="Search By Brand" aria-label="Search">
                    </div>
                    <div class="form-group mx-sm-2 mb-2">
                        <input type="search" name="company_search" class="form-control" placeholder="Search By Company" aria-label="Search">
                    </div>
                    <button class="btn btn-primary mb-2" type="submit">Search</button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-dashboard mg-b-0">
                    <thead>
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-center">Product</th>
                            <th class="text-center">Serial No</th>
                            <th class="text-center">IP Address</th>
                            <th class="text-center">Genuine</th>
                            <th class="text-center">Qr Code Scanned</th>
                            <th class="text-center">Scanned At</th>
                            <th class="text-center">Actions</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach($scanhistories as $index=>$product)
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
                            <td class="tx-medium text-center">{{$product->product}}
                            </td>
                            <td class="text-center">{{$product->batch}}
                            </td>
                            <td class="text-center">{{$product->ip_address}}
                            </td>
                            <td class="tx-medium text-center">
                                @if($product->genuine == 1)
                                {{ 'Genuine' }}
                                @elseif($product->genuine == 0)
                                {{ 'Fake' }}
                                @else
                                {{ 'Suspicious' }}
                                @endif
                            </td>
                            <td class="text-center tx-warning">{{$product->qr_code}}
                            </td>
                            <td class="text-center tx-warning">{{$formattedDateTime}}
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Actions">

                                    <a  type="button" class="btn btn-outline-primary" href="{{route('scanhistories.show',$product->id)}}" title="View"><i class="fas fa-eye" style="color: #63E6BE;font-size:18px;"></i></a>
                                   
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- table-responsive -->
        </div><!-- card -->

        <div class="mt-3">
            {{ $scanhistories->links('pagination::bootstrap-5') }}
        </div>

    </div><!-- col-md-12 -->
</div><!-- row -->
</div><!-- wrapper -->



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
</script>
@endsection





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
    /* background-color:linear-gradient(45deg, #700877 0%, #ff2759 100%); */
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
    display: grid;
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
        <div class="table-body" id="table-body"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="wrapper">
  <div class="main-panel" id="main-panel">
    <div class="pd-20 mg-t-10 col-11 mx-auto row">
      <div class="col-md-12">
        @if(session('status'))
        <div id="statusMessage" class="alert alert-success mt-2" style="background-color:#34eb86">{{session('status')}}</div>
        @endif

        <div class="d-sm-flex">




          <div class="col-sm-3 col-lg-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary tx-teal elevation-1 op-6"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
              <div class="info-box-content" style="font-weight:bold;">
                <span class="info-box-text">Last Added </span>
                <span class="info-box-number" style="justify-self:center">{{$last_added_product}}</span>
              </div>

            </div>
          </div>

          <div class="col-sm-3 col-lg-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info tx-teal elevation-1 op-6"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
              <div class="info-box-content" style="font-weight:bold;">
                <span class="info-box-text">Total Products</span>
                <span class="info-box-number" style="justify-self:center">{{count($products)}}</span>
              </div>

            </div>
          </div>



          <div class="col-sm-3 col-lg-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-pink elevation-1 op-4"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
              <div class="info-box-content" style="font-weight:bold;">
                <span class="info-box-text">Total Active</span>
                <span class="info-box-number" style="justify-self:center">{{$prodactiveCount}}</span>
              </div>

            </div>
          </div>


          <div class="col-sm-3 col-lg-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1 op-4"><i class="fas fa-chart-line" style="color: #ffffff;"></i></span>
              <div class="info-box-content" style="font-weight:bold;">
                <span class="info-box-text">Total Inactive</span>
                <span class="info-box-number" style="justify-self:center">{{ count($products) - $prodactiveCount }}</span>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- d-sm-flex -->
    <!-- card -->



    <div class="card pd-20 mg-t-10 col-11 mx-auto">
      <h3 class="content-header mg-b-25">Products</h3>
      <div class="d-flex justify-content-between align-items-start">
        <a href="{{ route('products.create') }}" class="btn btn-custom op-6 ml-3">
          <img src="{{ tracesciimg('icons8-create-16.png') }}" class="mr-1">{{ __('Create Products') }}
        </a>
        <form class="form-inline mr-4" method="GET" action="{{ route('products.index') }}">
          <div class="form-group mb-2">
            <input type="search" name="products_search" class="form-control" placeholder="Search By Product" aria-label="Search">
          </div>
          <div class="form-group mx-sm-3 mb-2">
            <input type="search" name="brands_search" class="form-control" placeholder="Search By Brand" aria-label="Search">
          </div>
          <div class="form-group mx-sm-3 mb-2">
            <input type="search" name="company_search" class="form-control" placeholder="Search By Company" aria-label="Search">
          </div>
          <button class="btn btn-primary mb-2" type="submit">Search</button>
        </form>
      </div>

      <div class="table-responsive">
        <table class="table table-dashboard mg-b-0">
          <thead>
            <tr>
              <th class="text-center">ID</th>
              <th class="text-left">NAME</th>
              <th class="text-left">BRAND</th>
              <th class="text-center">COMPANY NAME</th>
              <th class="text-center">STATUS</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $index => $product)
            @php
            $page = $products->currentPage();
            $perPage = $products->perPage();
            $incrementingIndex = ($page - 1) * $perPage + $index + 1;
            @endphp
            <tr>
              <td class="tx-color-03 tx-normal text-center">{{ $incrementingIndex }}</td>
              <td class="tx-medium text-left">{{ str_replace('_', ' ', $product->name) }}</td>
              <td class="text-left">{{ $product->brand }}</td>
              <td class="text-center">{{ $product->company_name }}</td>
              <td class="tx-medium text-center">
                @if($product->status == 'Active')
                <span class="tx-10 badge badge-success">Active</span>
                @else
                <span class="tx-10 badge badge-danger">Inactive</span>
                @endif
              </td>
              <td class="text-center">
                <div class="btn-group" role="group" aria-label="Actions">
                  <a class="btn btn-outline-primary" type="button" href="{{route('products.show', $product->id)}}" title="View"><i class="fas fa-eye" style="color: #63E6BE;font-size:18px;"></i></a>
                  <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-primary" title="Edit"><i class="fas fa-edit" style="color: #74C0FC;font-size:18px;"></i></a>
                </div>
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
      {{ $products->links('pagination::bootstrap-5') }}
    </div>
  </div>
</div>
@endsection




@section('js')

<script>
  function openModal(id, name, brand, companyname) {
    var html = '<div class="row">' +
      '<div class="col-md-6">' +
      '<strong>ID:</strong> ' + id +
      '</div>' +
      '<div class="col-md-6">' +
      '<strong>NAME:</strong> ' + name +
      '</div>' +
      '<div class="col-md-6">' +
      '<strong>BRAND:</strong> ' + brand +
      '</div>' +
      '<div class="col-md-6">' +
      '<strong>COMPANY-NAME:</strong> ' + companyname +
      '</div>' +
      '</div>';


    $('#table-body').html(html);
    $('#myModal').modal('show');
  }

  function closeModal() {
    $('#myModal').modal('hide');
  }
</script>
@endsection
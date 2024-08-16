@extends('dummy.app_new')
@section('content')
<style>
  #map {
    height: 400px;
    /* Adjust height for responsiveness */
    margin: auto;
    border: 1px solid #ccc;
    overflow: hidden !important;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1) !important;
  }

  #barGraph {
    width: 100%;
    height: 300px;
    /* Adjust height for responsiveness */
    margin: 20px auto;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .card-header {
    background-color: #F0F0F0;
    border-bottom: 1px solid rgba(72, 94, 144, 0.16);
  }

  /* Responsive Styles */
  @media (max-width: 767px) {
    .btn-custom {
      display: block;
      width: 100%;
      margin-bottom: 10px;
    }

    #map {
      height: 300px;
      /* Adjust for smaller screens */
    }

    #barGraph {
      height: 250px;
      /* Adjust for smaller screens */
    }

    .card-body canvas {
      height: 250px !important;
      /* Ensure chart fits on smaller screens */
    }
  }

  @media (min-width: 768px) {
    .btn-custom {
      display: inline-block;
      margin-left: 5px;
    }
  }
</style>

<div class="content content-components">
  @if (session('status'))
  <div id="statusMessage" class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  @if ($errors->any())
  <div id="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> {{ $errors->first() }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page" style="color:#e300be;">Centralized Monitoring</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Welcome to Dashboard</h4>
      </div>
      <div class="d-none d-md-flex">
        <a class="btn btn-sm pd-x-15 btn-custom btn-uppercase mg-l-5" href="{{ route('products.create') }}">
          <i data-feather="file" class="wd-10 mg-r-5"></i> Create Products
        </a>
        <a class="btn btn-sm pd-x-15 btn-custom btn-uppercase mg-l-5" href="{{ route('jobs.create') }}">
          <i data-feather="file" class="wd-10 mg-r-5"></i> Create Jobs
        </a>
        <a class="btn btn-sm pd-x-15 btn-custom btn-uppercase mg-l-5" href="{{ route('batches.create') }}">
          <i data-feather="file" class="wd-10 mg-r-5"></i> Create Batch
        </a>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-sm-6 col-lg-3">
        <div class="card card-body">
          <h6 class="tx-uppercase tx-17 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 mt-3">Total Products</h6>
          <div class="d-flex d-lg-block d-xl-flex align-items-end">
            <h2 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">{{$total_products}}</h2>
          </div>
        </div>
      </div><!-- col -->
      <div class="col-sm-6 col-lg-3 mg-t-10 mg-sm-t-0">
        <div class="card card-body">
          <h6 class="tx-uppercase tx-17 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 mt-3">Total Batches</h6>
          <div class="d-flex d-lg-block d-xl-flex align-items-end">
            <h2 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">{{$total_batch}}</h2>
          </div>
        </div>
      </div><!-- col -->
      <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
        <div class="card card-body">
          <h6 class="tx-uppercase tx-17 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 mt-3">Total Users</h6>
          <div class="d-flex d-lg-block d-xl-flex align-items-end">
            <h2 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">{{$total_user}}</h2>
          </div>
        </div>
      </div><!-- col -->
      <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
        <div class="card card-body">
          <h6 class="tx-uppercase tx-17 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 mt-3">Total Qr-Codes Data</h6>
          <div class="d-flex d-lg-block d-xl-flex align-items-end">
            <h2 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">{{$total_qrcodes}}</h2>
          </div>
        </div>
      </div><!-- col -->
      <div class="col-lg-8 col-xl-6 mg-t-10">
        <div class="card">
          <div class="card-header pd-y-20 d-md-flex align-items-center justify-content-between">
            <h6 class="mg-b-0">Jobs Status</h6>
          </div><!-- card-header -->
          <div class="card-body pos-relative pd-0">
            <div class="pos-absolute t-20 l-20 wd-xl-100p z-index-10">
              <div class="row">
                <div class="col-sm-5">
                  <h3 class="tx-normal tx-rubik tx-spacing--2 mg-b-5">Jobs</h3>
                  <p class="mg-b-0 tx-12 tx-color-03">Jobs that are being created.</p>
                  <h4 class="mt-3 tx-primary">{{$total_jobs}}</h4>
                </div><!-- col -->
                <div class="col-sm-5 mg-t-20 mg-sm-t-0">
                  <h3 class="tx-normal tx-rubik tx-spacing--2 mg-b-5">Active Jobs</h3>
                  <p class="mg-b-0 tx-12 tx-color-03">Total jobs that are active.</p>
                  <h4 class="mt-3 tx-success">{{$active_jobs}}</h4>
                </div><!-- col -->
              </div><!-- row -->
            </div>

            <!-- Adjust canvas size as needed -->
            <canvas id="jobChart" style="width: 100%; height: 300px;margin-top:30%;"></canvas>
          </div><!-- card-body -->
        </div><!-- card-body -->
      </div><!-- card -->
      <div class="col-lg-4 col-xl-6 mg-t-10">
        <div class="card h-100 d-flex flex-column">
          <div class="flex-fill">
            <div class="card-header pd-t-20 pd-b-0 bd-b-0 pb-3">
              <h6 class="mg-b-5">Case Status</h6>
            </div>
          </div><!-- card-header -->
          <div class="card-body pd-20">
            <div style="width: 100%; margin: 0 auto;">
              <div class="row">
                <div class="col-sm mg-sm-t-0">
                  <h4 class="tx-normal tx-rubik tx-spacing--1 mg-b-5">Total</h4>
                  <div class="tx-20 tx-primary">{{$total_scan ?? "0"}}</div>
                </div><!-- col -->
                <div class="col-sm mg-sm-t-0">
                  <h4 class="tx-normal tx-rubik tx-spacing--1 mg-b-5">Active</h4>
                  <div class="tx-20 tx-success">{{$total_scan ?? "0"}}</div>
                </div><!-- col -->
                <div class="col-sm">
                  <h4 class="tx-normal tx-rubik tx-spacing--1 mg-b-5">Common</h4>
                  <div class="tx-20 tx-warning">{{$mostCommonIssue->report_reason ?? "--"}}</div>
                </div><!-- col -->
                <div id="barGraph"></div>
              </div><!-- row -->
            </div><!-- card-body -->
          </div><!-- card -->
        </div>
      </div>
    </div>
    <div class="row mt-4 mb-4">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pd-y-20 d-md-flex align-items-center justify-content-between">
            <h6 class="mg-b-0">Recently Scanned</h6>
          </div>
          <div class="card-body mb-3">
            <div class="row">
              <div class="col-12">
                <div id="map"></div>
              </div>
            </div>
          </div>
        </div><!-- row -->
      </div><!-- container -->
    </div>
  </div>
</div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDADniYJASHh9Fbu-PagV7vFtjM9bJx9dU&callback=initMap">
</script>
<script>
  function initMap() {
    // Assuming these values are being rendered correctly

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 5,
      center: {
        lat: 28.7041,
        lng: 77.1025
      } // Change this to your desired location
    });



    // Add markers
    var locationsString = '{{$jsonLocations}}';
    var decodedString = locationsString.replace(/&quot;/g, '"');
    var locations = JSON.parse(decodedString);

    for (var i = 0; i < locations.length; i++) {
      var marker = new google.maps.Marker({
        position: {
          lat: parseFloat(locations[i].lat),
          lng: parseFloat(locations[i].lng)
        },
        map: map,
        title: location.title || 'No Title'
      });
    }
  }

  // Initialize the map when the page loads
  window.onload = initMap;
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Sample data (dynamic values from Laravel Blade)
  const totalIssues = '{{$total_scan}}';
  const resolvedIssues = '{{$total_scan}}';

  // Create a function to draw the bar graph
  function drawBarGraph() {
    const canvas = document.createElement('canvas');
    canvas.width = 400;
    canvas.height = 300;

    const ctx = canvas.getContext('2d');

    // Calculate bar dimensions
    const barWidth = 100;
    const barMargin = 50;
    const barSpacing = 20;

    // Draw total issues bar
    ctx.fillStyle = '#ff275994';
    ctx.fillRect(barMargin, 250 - totalIssues, barWidth, totalIssues);

    // Draw resolved issues bar
    ctx.fillStyle = '#10b759';
    ctx.fillRect(barMargin + barWidth + barSpacing, 250 - resolvedIssues, barWidth, resolvedIssues);

    // Labels
    ctx.fillStyle = 'black';
    ctx.font = '12px Arial';
    ctx.textAlign = 'center';
    ctx.fillText('Total Cases', barMargin + barWidth / 2, 270);
    ctx.fillText('Active Cases', barMargin + barWidth + barSpacing + barWidth / 2, 270);

    const graphContainer = document.getElementById('barGraph');
    graphContainer.appendChild(canvas);
  }

  // Call the function to draw the bar graph when the page loads
  window.onload = drawBarGraph;
</script>


<script>
  // Data passed from Laravel controller
  const months = {
    !!json_encode($months) !!
  }; // Month names
  const data = {
    !!json_encode($data) !!
  }; // Job counts

  const jobData = {
    labels: months,
    datasets: [{
      label: 'Total Jobs Created',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 2,
      fill: false,
      data: data
    }]
  };

  // Get the context of the canvas element where we will draw the chart
  const ctx = document.getElementById('jobChart').getContext('2d');

  // Create the line chart
  const jobChart = new Chart(ctx, {
    type: 'line',
    data: jobData,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var statusAlert = document.getElementById('statusAlert');
    if (statusAlert) {
      setTimeout(function() {
        statusAlert.style.opacity = 0;
        setTimeout(function() {
          statusAlert.style.display = 'none';
        }, 600); // Delay to allow fade-out transition
      }, 5000); // 5 seconds before hiding
    }
  });
</script>
@endsection
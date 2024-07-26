@extends('dummy.app_new')
@section('content')
<style>
  #map {
    height: 500px;
    margin: auto;
    border: 1px solid #ccc;
    overflow: hidden !important;
    /* Important to override potential conflicting styles */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1) !important;
    /* Important to override potential conflicting styles */
  }

  #barGraph {
    width: 100%;
    height: 300px;
    margin: 20px auto;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  .card-header{
    background-color:#F0F0F0;
  }
</style>
<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Centralized Monitoring</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Welcome to Dashboard</h4>
      </div>
      <div class="d-none d-md-block">
        <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="mail" class="wd-10 mg-r-5"></i> Email</button>
        <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="printer" class="wd-10 mg-r-5"></i> Print</button>
        <a class="btn btn-sm pd-x-15 btn-custom btn-uppercase mg-l-5" href="{{ route('products.create') }}"><i data-feather="file" class="wd-10 mg-r-5"></i> Create products</a>
        <a class="btn btn-sm pd-x-15 btn-custom btn-uppercase mg-l-5" href="{{ route('jobs.create') }}"><i data-feather="file" class="wd-10 mg-r-5"></i> Create jobs</a>
        <a class="btn btn-sm pd-x-15 btn-custom btn-uppercase mg-l-5" href="{{ route('batches.create') }}"><i data-feather="file" class="wd-10 mg-r-5"></i> Create Batch</a>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-sm-6 col-lg-3">
        <div class="card card-body">
          <h6 class="tx-uppercase tx-17 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 mt-3 ">Total Products</h6>
          <div class="d-flex d-lg-block d-xl-flex align-items-end">
            <h2 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">06</h2>
          </div>
        </div>
      </div><!-- col -->
      <div class="col-sm-6 col-lg-3 mg-t-10 mg-sm-t-0">
        <div class="card card-body">
          <h6 class="tx-uppercase tx-17 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 mt-3 ">Total Batches</h6>
          <div class="d-flex d-lg-block d-xl-flex align-items-end">
            <h2 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">05</h2>
          </div>
        </div>
      </div><!-- col -->
      <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
        <div class="card card-body">
          <h6 class="tx-uppercase tx-17 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 mt-3">Total Users</h6>
          <div class="d-flex d-lg-block d-xl-flex align-items-end">
            <h2 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">07</h2>
          </div>
        </div>
      </div><!-- col -->
      <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
        <div class="card card-body">
          <h6 class="tx-uppercase tx-17 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 mt-3">Total Qr-Codes Data</h6>
          <div class="d-flex d-lg-block d-xl-flex align-items-end">
            <h2 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">10000</h2>
          </div>
        </div>
      </div><!-- col -->
      <div class="col-lg-8 col-xl-6 mg-t-10">
        <div class="card">
          <div class="card-header pd-y-20 d-md-flex align-items-center justify-content-between">
            <h6 class="mg-b-0">Jobs Status</h6>
            <ul class="list-inline d-flex mg-t-20 mg-sm-t-10 mg-md-t-0 mg-b-0">
              <li class="list-inline-item d-flex align-items-center">
                <span class="d-block wd-10 ht-10 bg-df-1 rounded mg-r-5"></span>
                <span class="tx-sans tx-uppercase tx-10 tx-medium tx-color-03">Active</span>
              </li>

            </ul>
          </div><!-- card-header -->
          <div class="card-body pos-relative pd-0">
            <div class="pos-absolute t-20 l-20 wd-xl-100p z-index-10">
              <div class="row">
                <div class="col-sm-5">
                  <h3 class="tx-normal tx-rubik tx-spacing--2 mg-b-5"> Jobs </h3>
                  <p class="mg-b-0 tx-12 tx-color-03"> jobs that are being created.</p>
                  <h4 class="mt-3 tx-primary">05</h4>
                </div><!-- col -->
                <div class="col-sm-5 mg-t-20 mg-sm-t-0">
                  <h3 class="tx-normal tx-rubik tx-spacing--2 mg-b-5"> Active Jobs </h3>
                  <p class="mg-b-0 tx-12 tx-color-03">Total jobs that are active.</p>
                  <h4 class="mt-3 tx-warning">03</h4>
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

            <div class="card-header  pd-t-20 pd-b-0 bd-b-0 pb-3">
              <h6 class="mg-b-5">Case Status</h6>
              <p class="tx-12 tx-color-03 mg-b-0"></p>
            </div>
          </div><!-- card-header -->
          <div class="card-body pd-20">
            <div style="width: 80%; margin: 0 auto;">
              <div class="row">
                <div class="col-sm mg-sm-t-0">
                  <h4 class="tx-normal tx-rubik tx-spacing--1 mg-b-5">Total </h4>
                  <div class="tx-20 tx-primary">12</div>
                </div><!-- col -->
                <div class="col-sm  mg-sm-t-0">
                  <h4 class="tx-normal tx-rubik tx-spacing--1 mg-b-5">Active</h4>
                  <div class="tx-20 tx-danger">07</div>
                </div><!-- col -->
                <div class="col-4">
                  <h4 class="tx-normal tx-rubik tx-spacing--1 mg-b-5 d-flex ">Common</h4>
                  <div class="tx-20 tx-warning">Damaged Product</div>
                </div><!-- col -->
                <div id="barGraph"></div>
              </div><!-- row -->
            </div><!-- card-body -->
          </div><!-- card -->
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header pd-y-20 d-md-flex align-items-center justify-content-between">
            <h6 class="mg-b-0">Recently Scanned</h6>
            <ul class="list-inline d-flex mg-t-20 mg-sm-t-10 mg-md-t-0 mg-b-0">

            </ul>
          </div>
          <div class="card-body ">

            <div class="row">
              <div class="col-12">
                <div id="map">
                </div>
              </div>
            </div>
          </div>
        </div><!-- row -->
      </div><!-- container -->
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Sample data (static values for total and resolved issues)
  const totalIssues = 100;
  const resolvedIssues = 70;

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
    ctx.fillStyle = ' #ff275994';
    ctx.fillRect(barMargin, 250, barWidth, -totalIssues);

    // Draw resolved issues bar
    ctx.fillStyle = '#a1c70c82';
    ctx.fillRect(barMargin + barWidth + barSpacing, 250, barWidth, -resolvedIssues);

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
  document.addEventListener("DOMContentLoaded", function() {
    // Dummy data for illustration

    // Update totals
    var activeTotal = data.datasets[0].data[0];
    var inactiveTotal = data.datasets[0].data[1];
    document.getElementById('activeTotal').textContent = '$' + activeTotal.toLocaleString();
    document.getElementById('inactiveTotal').textContent = '$' + inactiveTotal.toLocaleString();
  });

  $(function() {
    'use strict'

    var plot = $.plot('#flotChart', [{
      data: df3,
      color: '#69b2f8'
    }, {
      data: df1,
      color: '#d1e6fa'
    }, {
      data: df2,
      color: '#d1e6fa',
      lines: {
        fill: false,
        lineWidth: 1.5
      }
    }], {
      series: {
        stack: 0,
        shadowSize: 0,
        lines: {
          show: true,
          lineWidth: 0,
          fill: 1
        }
      },
      grid: {
        borderWidth: 0,
        aboveData: true
      },
      yaxis: {
        show: false,
        min: 0,
        max: 350
      },
      xaxis: {
        show: true,
        ticks: [
          [0, ''],
          [8, 'Jan'],
          [20, 'Feb'],
          [32, 'Mar'],
          [44, 'Apr'],
          [56, 'May'],
          [68, 'Jun'],
          [80, 'Jul'],
          [92, 'Aug'],
          [104, 'Sep'],
          [116, 'Oct'],
          [128, 'Nov'],
          [140, 'Dec']
        ],
        color: 'rgba(255,255,255,.2)'
      }
    });


    $.plot('#flotChart2', [{
      data: [
        [0, 55],
        [1, 38],
        [2, 20],
        [3, 70],
        [4, 50],
        [5, 15],
        [6, 30],
        [7, 50],
        [8, 40],
        [9, 55],
        [10, 60],
        [11, 40],
        [12, 32],
        [13, 17],
        [14, 28],
        [15, 36],
        [16, 53],
        [17, 66],
        [18, 58],
        [19, 46]
      ],
      color: '#69b2f8'
    }, {
      data: [
        [0, 80],
        [1, 80],
        [2, 80],
        [3, 80],
        [4, 80],
        [5, 80],
        [6, 80],
        [7, 80],
        [8, 80],
        [9, 80],
        [10, 80],
        [11, 80],
        [12, 80],
        [13, 80],
        [14, 80],
        [15, 80],
        [16, 80],
        [17, 80],
        [18, 80],
        [19, 80]
      ],
      color: '#f0f1f5'
    }], {
      series: {
        stack: 0,
        bars: {
          show: true,
          lineWidth: 0,
          barWidth: .5,
          fill: 1
        }
      },
      grid: {
        borderWidth: 0,
        borderColor: '#edeff6'
      },
      yaxis: {
        show: false,
        max: 80
      },
      xaxis: {
        ticks: [
          [0, 'Jan'],
          [4, 'Feb'],
          [8, 'Mar'],
          [12, 'Apr'],
          [16, 'May'],
          [19, 'Jun']
        ],
        color: '#fff',
      }
    });

    $.plot('#flotChart3', [{
      data: df4,
      color: '#9db2c6'
    }], {
      series: {
        shadowSize: 0,
        lines: {
          show: true,
          lineWidth: 2,
          fill: true,
          fillColor: {
            colors: [{
              opacity: 0
            }, {
              opacity: .5
            }]
          }
        }
      },
      grid: {
        borderWidth: 0,
        labelMargin: 0
      },
      yaxis: {
        show: false,
        min: 0,
        max: 60
      },
      xaxis: {
        show: false
      }
    });

    $.plot('#flotChart4', [{
      data: df5,
      color: '#9db2c6'
    }], {
      series: {
        shadowSize: 0,
        lines: {
          show: true,
          lineWidth: 2,
          fill: true,
          fillColor: {
            colors: [{
              opacity: 0
            }, {
              opacity: .5
            }]
          }
        }
      },
      grid: {
        borderWidth: 0,
        labelMargin: 0
      },
      yaxis: {
        show: false,
        min: 0,
        max: 80
      },
      xaxis: {
        show: false
      }
    });

    $.plot('#flotChart5', [{
      data: df6,
      color: '#9db2c6'
    }], {
      series: {
        shadowSize: 0,
        lines: {
          show: true,
          lineWidth: 2,
          fill: true,
          fillColor: {
            colors: [{
              opacity: 0
            }, {
              opacity: .5
            }]
          }
        }
      },
      grid: {
        borderWidth: 0,
        labelMargin: 0
      },
      yaxis: {
        show: false,
        min: 0,
        max: 80
      },
      xaxis: {
        show: false
      }
    });

    $.plot('#flotChart6', [{
      data: df4,
      color: '#9db2c6'
    }], {
      series: {
        shadowSize: 0,
        lines: {
          show: true,
          lineWidth: 2,
          fill: true,
          fillColor: {
            colors: [{
              opacity: 0
            }, {
              opacity: .5
            }]
          }
        }
      },
      grid: {
        borderWidth: 0,
        labelMargin: 0
      },
      yaxis: {
        show: false,
        min: 0,
        max: 60
      },
      xaxis: {
        show: false
      }
    });

    $('#vmap').vectorMap({
      map: 'usa_en',
      showTooltip: true,
      backgroundColor: '#fff',
      color: '#d1e6fa',
      colors: {
        fl: '#69b2f8',
        ca: '#69b2f8',
        tx: '#69b2f8',
        wy: '#69b2f8',
        ny: '#69b2f8'
      },
      selectedColor: '#00cccc',
      enableZoom: false,
      borderWidth: 1,
      borderColor: '#fff',
      hoverOpacity: .85
    });


    var ctxLabel = ['6am', '10am', '1pm', '4pm', '7pm', '10pm'];
    var ctxData1 = [20, 60, 50, 45, 50, 60];
    var ctxData2 = [10, 40, 30, 40, 55, 25];

    // Bar chart
    var ctx1 = document.getElementById('chartBar1').getContext('2d');
    new Chart(ctx1, {
      type: 'horizontalBar',
      data: {
        labels: ctxLabel,
        datasets: [{
          data: ctxData1,
          backgroundColor: '#69b2f8'
        }, {
          data: ctxData2,
          backgroundColor: '#d1e6fa'
        }]
      },
      options: {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false,
          labels: {
            display: false
          }
        },
        scales: {
          yAxes: [{
            gridLines: {
              display: false
            },
            ticks: {
              display: false,
              beginAtZero: true,
              fontSize: 10,
              fontColor: '#182b49'
            }
          }],
          xAxes: [{
            gridLines: {
              display: true,
              color: '#eceef4'
            },
            barPercentage: 0.6,
            ticks: {
              beginAtZero: true,
              fontSize: 10,
              fontColor: '#8392a5',
              max: 80
            }
          }]
        }
      }
    });

  })
</script>
<script>
  // Static data for job creation month-wise
  const jobData = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
    datasets: [{
      label: 'Total Jobs Created',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 2,
      fill: false,
      data: [120, 150, 180, 200, 190, 210],
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDADniYJASHh9Fbu-PagV7vFtjM9bJx9dU"></script>
<script>
  function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {
        lat: 40.7128,
        lng: -74.006
      },
      zoom: 12
    });

    var marker = new google.maps.Marker({
      position: {
        lat: 40.7128,
        lng: -74.006
      },
      map: map,
      title: 'Marker 1'
    });

    var marker2 = new google.maps.Marker({
      position: {
        lat: 40.712,
        lng: -74.1
      },
      map: map,
      title: 'Marker 2'
    });

    // Add more markers as needed
  }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDADniYJASHh9Fbu-PagV7vFtjM9bJx9dU&callback=initMap">
</script>
<script>
  // Data for the bar chart
  var data = {
    labels: ["Total Cases", "Active Cases"],
    datasets: [{
      label: 'Cases',
      data: [50, 30], // Replace with your actual data
      backgroundColor: [
        'rgba(255, 99, 132, 0.5)', // Red color with transparency
        'rgba(54, 162, 235, 0.5)' // Blue color with transparency
      ],
      borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)'
      ],
      borderWidth: 1
    }]
  };

  // Configuration options
  var options = {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  };

  // Get the canvas element
  var ctx = document.getElementById('myChart').getContext('2d');

  // Create the bar chart
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: options
  });
</script>
@endsection
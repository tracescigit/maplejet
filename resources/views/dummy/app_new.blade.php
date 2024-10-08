<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tracesci</title>

  <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/favicon.png">
  <link href="{{url('/assets/new_css/all.min.css')}}" rel="stylesheet">
  <!-- <link href="{{url('/assets/new_css/ionicons.min.css')}}" rel="stylesheet"> -->

  <script src="{{tracescicss('bootstrap4.5.min.css')}}"></script>
  <link href="{{url('/assets/new_css/jqvmap.min.css').cssVer()}}" rel="stylesheet">

  <!-- DashForge CSS -->
  <link rel="stylesheet" href="{{url('/assets/new_css/dashforge.css')}}">
  <link rel="stylesheet" href="{{url('/assets/new_css/dashforge.dashboard.css')}}">
  <link rel="stylesheet" href="{{url('/assets/new_css/dashforge.demo2.css')}}">

  <!-- bootstrap-->
  <link href="{{tracescicss('quill.snow.css')}}" rel="stylesheet" />
  <!-- <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" /> -->

  <style>
    .nav-link.active {
      color: #b70a9b;
    }

    .btn-custom {
      background: #b70a9b !important;
      color: white;
      border-radius: 5px;
      padding: 10px 20px;
      font-size: 14px;
      border: none;
      transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
      background: #2d6ac2 !important;
      color: white !important;
    }

    .ql-container.ql-snow {
      height: 200px;
      margin-bottom: 30px;
    }

    .nav-aside .nav-item ul .active a {
      color: #b70a9b !important;
    }

    .nav-aside .nav-item.active .nav-link {
      opacity: 1;
      color: #b70a9b !important;
      font-weight: 500;
    }

    .nav-aside .nav-item.active svg {
      color: #b70a9b !important;
      fill: rgba(1, 104, 250, 0.2);
    }

    .footer {
      /* color: white; */
      text-align: center;
      padding: 10px;
      position: fixed;
      bottom: 0;
      width: 100%;
      left: 0;
    }

    .submenu {
      display: none;
      /* Hide submenu by default */
      list-style: none;
      /* Remove default list styling */
      padding: 0;
      margin: 0;
    }

    .submenu.show {
      display: block;
      /* Show submenu when 'show' class is added */
    }

    .nav-item.with-sub.show .submenu {
      display: block;
      /* Show submenu when 'show' class is added to parent <li> */
    }

    .justify-content-center {
      margin-bottom: 30px;
    }

    .btn-outline-primary:hover {
      border-color: blue;
      /* Optional: Change the border color to match the background */
      color: white;
      /* Optional: Change the text color to ensure it's visible on the red background */
    }

    .btn-custom,
    .btn-secondary {
      display: inline-flex;
      align-items: center;
      padding: 10px 20px;
      /* Adjust padding as needed */
      font-size: 16px;
      /* Make sure the font size is consistent */
    }

    .btn-custom i,
    .btn-secondary i {
      margin-right: 8px;
      /* Space between icon and text */
    }

    .btn-custom,
    .btn-secondary {
      height: 40px;
      /* Set a fixed height to ensure consistency */
      line-height: 20px;
      /* Adjust line-height to match text height */
    }

    .btn-custom i,
    .btn-secondary i {
      vertical-align: middle;
      /* Align icons vertically in the center */
    }

    .profile {
      padding-top: 5px !important;
    }

    .profile_icon {
      padding: 0px !important;
    }

    /* Ensure pagination is centered and responsive */
    .pagination {
      margin: 0;
    }

    .page-item {
      margin: 0 2px;
    }

    .page-item.active .page-link {
      background-color: #007bff;
      border-color: #007bff;
    }

    .page-item.disabled .page-link {
      color: #6c757d;
      pointer-events: none;
      background-color: #fff;
      border-color: #dee2e6;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
      .pagination {
        font-size: 0.75rem;
      }
    }
  </style>

</head>

<body>


  @if(!Route::is("password.request") && !Route::is("login") && !Route::is("logout1"))
  @include('dummy.navbar_new')
  @include('dummy.top_navbar_new')
  @endif

  @yield('content')
  @include('layout.footer')

  <!-- <script src="{{tracescijs('jquery3.5.min.js')}}"></script> -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script> -->
  <script src="{{tracescijs('popper.min.js').jsVer()}}"></script>
  <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
  <script src="{{tracescijs('bootstrap.min.js').jsVer()}}"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script> -->
  <script src="{{tracescijs('quill.js').jsVer()}}"></script>


  <script src="{{url('/assets/js/js_new/jquery.min.js')}}"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->




  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> -->
  <script src="{{tracescijs('popper2.min.js')}}"></script>

  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

  <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
  <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> -->
  <script src="{{tracescijs('bundle.min.js')}}"></script>

  <script src="{{url('/assets/js/js_new/feather.min.js')}}"></script>
  <script src="{{url('/assets/js/js_new/perfect-scrollbar.min.js')}}"></script>
  <script src="{{url('/assets/js/js_new/jquery.flot.js')}}"></script>
  <script src="{{url('/assets/js/js_new/jquery.flot.stack.js')}}"></script>
  <script src="{{url('/assets/js/js_new/jquery.flot.resize.js')}}"></script>
  <script src="{{url('/assets/js/js_new/Chart.bundle.min.js')}}"></script>
  <script src="{{url('/assets/js/js_new/jquery.vmap.min.js')}}"></script>
  <script src="{{url('/assets/js/js_new/jquery.vmap.usa.js')}}"></script>

  <script src="{{url('/assets/js/js_new/dashforge.js')}}"></script>
  <script src="{{url('/assets/js/js_new/dashforge.aside.js')}}"></script>
  <script src="{{url('/assets/js/js_new/dashforge.sampledata.js')}}"></script>

  <!-- append theme customizer -->
  <script src="{{url('/assets/js/js_new/js.cookie.js')}}"></script>
  <script src="{{url('/assets/js/js_new/dashforge.settings.js')}}"></script>
  <script>
    function closeProfile() {
      var profileElement = document.getElementById('open_profile');
      profileElement.style.display = 'none';
    }
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

    function toggleSubMenu(event, element) {
      event.preventDefault(); // Prevent the default link behavior

      // Get the parent <li> element
      const parentLi = element.closest('li');
      parentLi.classList.toggle('show');
      parentLi.classList.toggle('active');
      // Find the submenu <ul> inside the parent <li>
    }

    function openProfile() {
      var profileElement = document.getElementById('open_profile');
      if (profileElement.style.display === 'none' || profileElement.style.display === '') {
        profileElement.style.display = 'block';
      } else {
        profileElement.style.display = 'none';
      }


    }
  </script>
  @yield('js')

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        Dashboard TRACESCI
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- CSS Files -->
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="{{tracesciicon('fontawesome.min.css')}}" rel="stylesheet">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script> -->

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{tracescicss('demo/select2/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{tracescicss('all.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{tracesci_dash('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{tracesci_dash('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <!-- <link rel="stylesheet" href="{{tracesci_dash('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}"> -->
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{tracesci_dash('plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{tracesci_dash('dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{tracesci_dash('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{tracesci_dash('plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{tracesci_dash('plugins/summernote/summernote-bs4.min.css')}}">
    <link href="{{tracesciicon('fontawesome.min.css')}}" rel="stylesheet">
    <style>
        .main-sidebar {
            background: linear-gradient(#000000
                   );
        }

        .nav-link.active {
            background-color: #007bff !important;
        }

        .nav-sidebar>.nav-item {
            margin-bottom: 10px !important;
        }

        .main-header navbar navbar-expand navbar-white navbar-light {
            margin-left: 0px !important;
        }
  .select_colour{
    color:#ffffff !important;
     font-weight:700 !important;
  }
    </style>



</head>

<body>

    @include('layout.dash_new')
    @yield('content')
    @include('layout.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{tracescijs('core/bootstrap-bundle.min.js')}}"></script>
    <script src="{{tracescicss('demo/select2/js/select2.full.min.js')}}"></script>
    <!-- <script src="{{tracescijs('core/popper.min.js')}}"></script> -->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
    <!-- <script src="{{tracescijs('plugins/chartjs.min.js')}}"></script>
    <script src="{{tracescijs('plugins/bootstrap-notify.js')}}"></script> -->
    <script src="{{tracescijs('plugins/chartjs.min.js')}}"></script>
    <script src="{{tracescijs('now-ui-dashboard.min.js')}}" type="text/javascript"></script>

    <script>
        let serialNo = 1;

        function addRowToTable(data) {
            const tableBody = document.querySelector('#camera-data-table tbody');
            if (tableBody) {
                const newRow = document.createElement('tr');

                const serialNoCell = document.createElement('td');
                serialNoCell.textContent = serialNo++;
                newRow.appendChild(serialNoCell);

                const dataCell = document.createElement('td');
                dataCell.textContent = JSON.stringify(data);
                newRow.appendChild(dataCell);

                const timeCell = document.createElement('td');
                const currentTime = new Date().toLocaleString();
                timeCell.textContent = currentTime;
                newRow.appendChild(timeCell);
                const remarkCell = document.createElement('td');
                remarkCell.textContent = ''; // Empty for now
                newRow.appendChild(remarkCell);

                tableBody.appendChild(newRow);
            } else {
                console.error('Table body not found');
            }
        }
    </script>

    <script>
        $("#phoneNumberForm").submit(function(event) {
            event.preventDefault();
            var phoneNumber = $("#phone_number").val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/api/getphonenumber',
                type: 'GET',
                contentType: 'application/json',
                dataType: 'json',
                data: {
                    _token: csrfToken,
                    phone_number: phoneNumber
                },
                success: function(data) {
                    alert(data.message);
                    $('#phoneNumberForm').hide();
                    $('#otpForm').show();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            var statusMessage = document.getElementById('statusMessage');

            if (statusMessage) {
                setTimeout(function() {
                    statusMessage.style.display = 'none';
                }, 5000);
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            var errorMessage = document.getElementById('errorMessage');

            if (errorMessage) {
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 5000);
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.querySelector(".sidebar");
            const content = document.querySelector(".main-panel");
            const navbar = document.querySelector(".navbar-transparent");
            const breadcrumbLink = document.getElementById("breadcrumb-link");
            const cardbody = document.querySelector(".card-body");
            if (breadcrumbLink) {
                breadcrumbLink.addEventListener("click", function(event) {
                    event.preventDefault();
                    sidebar.classList.toggle("collapsed");
                    // Adjust content width based on sidebar state
                    if (sidebar.classList.contains("collapsed")) {
                        content.style.transition = "width 0.3s ease";
                        setTimeout(() => {
                            content.style.width = "calc(100% - 50px)";
                            document.querySelectorAll('.sidebar .nav li>a').forEach(function(item) {
                                item.style.margin = "0 !important";
                            });
                            navbar.style.marginLeft = "25px";
                            cardbody.style.marginLeft = "25px";
                        }, 3);
                    } else {
                        content.style.transition = "width 0.3s ease";
                        setTimeout(() => {
                            content.style.width = "calc(100% - 250px)"; // Adjust the expanded width as needed
                            // Revert CSS changes when sidebar is expanded
                            document.querySelectorAll('.sidebar .nav li>a').forEach(function(item) {
                                item.style.margin = ""; // Remove inline style
                            });
                            document.querySelectorAll('.sidebar .nav li>a, .off-canvas-sidebar .nav li>a').forEach(function(item) {
                                item.style.padding = "7px 0px";
                            });
                            navbar.style.marginLeft = "";
                            cardbody.style.marginLeft = "";
                        }, 3);
                    }
                });
            }



        });
        // // Initialize Select2 on your select element
        // $(document).ready(function() {
        //     $('.select2').select2();
        // });
    </script>
    <!-- <script>
        $(function() {
            $('#description').summernote({
                placeholder: '',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['codeview', 'help']]
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                        document.getElementById('description').value = contents;
                    }
                }
            });
        });
    </script> -->
    <script>
        // jQuery code
        $(document).ready(function() {
            $('.dropdown-toggle').click(function() {
                var $dropdownMenu = $(this).next('.dropdown-menu');
                if ($dropdownMenu.css('display') === 'none') {
                    $dropdownMenu.css('display', 'block');
                } else {
                    $dropdownMenu.css('display', 'none');
                }
            });
            
            // Close dropdown when clicking outside
            $(document).click(function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').css('display', 'none');
                }
            });

            // Prevent default action for logout link
            $('.logout-link').click(function(e) {
                e.preventDefault();
                $(this).closest('form').submit();
            });
        });
    </script>
    <script>
        function removedisplaynone() {
            $('#collapse-2').toggle();
        }

        function toggleprod() {
            $('#collapse-1').toggle();
        }
    </script>
    <script>
        //     $(document).ready(function() {
        //     // Toggle logos when navbar collapse button is clicked
        //     $('.navbar-toggler').click(function() {
        //         // Check if navbar collapse is currently shown or hidden
        //         var isCollapsed = $('.navbar-collapse').hasClass('show');

        //         // Toggle images based on collapse state
        //         if (isCollapsed) {
        //             $('.nav-link img').attr('src', "{{ tracesciimg('tracescilogo.png') }}");
        //             // Change to logo1 image src if applicable
        //         } else {
        //             $('.nav-link img').attr('src', "{{ tracesciimg('tracesci_logo2.jpg') }}");
        //             // Change to logo2 image src if applicable
        //         }
        //     });
        // });
    </script>
    <script src="{{tracesci_dash('plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{tracesci_dash('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{tracesci_dash('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{tracesci_dash('plugins/chart.js/Chart.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{tracesci_dash('plugins/sparklines/sparkline.js')}}"></script>
    <!-- JQVMap -->
    <script src="{{tracesci_dash('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{tracesci_dash('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{tracesci_dash('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{tracesci_dash('plugins/moment/moment.min.js')}}"></script>
    <script src="{{tracesci_dash('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{tracesci_dash('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{tracesci_dash('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{tracesci_dash('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{tracesci_dash('dist/js/adminlte.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{tracesci_dash('dist/js/demo.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{tracesci_dash('dist/js/pages/dashboard.js')}}"></script>
    @yield('js')
</body>

</html>
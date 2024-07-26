<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{tracesciicon('fontawesome.min.css')}}" rel="stylesheet">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script> -->
    <!-- <link href="{{tracescicss('bootstrap.min.css')}}" rel="stylesheet" /> -->
    <link href="{{tracescicss('now-ui-dashboard.css')}}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{tracescicss('demo/demo.css')}}" rel="stylesheet" />
    <link href="{{tracescicss('demo/select2/css/select2.min.css')}}" rel="stylesheet" />
    <!-- <link href="{{tracescicss('summernote.lite.min.css')}}" rel="stylesheet" /> -->
    <link href="{{tracescicss('all.css')}}" rel="stylesheet" />



</head>

<body>

    @include('layout.header')
    @yield('content')
    @include('layout.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{tracescijs('core/bootstrap-bundle.min.js')}}"></script>
    <script src="{{tracescicss('demo/select2/js/select2.full.min.js')}}"></script>
    <script src="{{tracescijs('demo.js')}}"></script>
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
    <script type="text/javascript">
        Echo.channel(`channel-name`)
            .listen('CameraDataRead', (e) => {
                console.log(e);
                addRowToTable(e);
            });
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
            // Get the sidebar element
            var hoversidebar = document.getElementById("sidebarhover");
            hoversidebar.addEventListener("mouseover", function() {
                hoversidebar.classList.remove("collapsed");
                const content = document.querySelector(".main-panel");
                if (content) {
                    content.style.transition = "width 0.3s ease";
                    setTimeout(() => {
                        content.style.width = "calc(100% - 250px)"; // Adjust the expanded width as needed
                        document.querySelectorAll('.sidebar .nav li>a').forEach(function(item) {
                            item.style.margin = ""; // Remove inline style
                        });
                        document.querySelectorAll('.sidebar .nav li>a, .off-canvas-sidebar .nav li>a').forEach(function(item) {
                            item.style.padding = "7px 0px";
                        });
                    }, 3);
                }

            });


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
    @yield('js')
</body>

</html>
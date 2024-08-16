<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Dashboard TRACESCI
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <style>
    .btn-custom {
      background: linear-gradient(45deg, #700877 0%, #ff2759 100%);
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

    .body {
      font-family: "IBM Plex Sans, sans-serif" !important;
    }
  </style>
 <link rel="stylesheet" href="{{url('/assets/new_css/dashforge.css')}}">
  <link rel="stylesheet" href="{{url('/assets/new_css/dashforge.demo2.css')}}">
  <link rel="stylesheet" href="{{url('/assets/new_css/dashforge.demo.css')}}">
  <link rel="stylesheet" href="{{url('/assets/new_css/fontawesome.css')}}">
  <link rel="stylesheet" href="{{url('/assets/new_css/ion.min.css')}}">
  <link rel="stylesheet" href="{{url('/assets/new_css/typicons.css')}}">
  <link rel="stylesheet" href="{{url('/assets/new_css/prism-vs.css')}}">



</head>

<body>
  @yield('content')
  @include('layout.footer')
 
  @yield('js')
</body>

</html>
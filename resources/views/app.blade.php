<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <title>Take Me Date</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
 <!-- plugins:css -->
    <link rel="stylesheet" href="{{ URL::asset('dash_assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('dash_assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('dash_assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('dash_assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ URL::asset('dash_assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('dash_assets/js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200&display=swap" rel="stylesheet">

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ URL::asset('dash_assets/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
</head>
<body>
    <div id="app"></div>

 <script src="{{ URL::asset('dash_assets/vendors/js/vendor.bundle.base.js') }}"></script>
 <script src="{{ URL::asset('dash_assets/js/off-canvas.js') }}"></script>
 <script src="{{ URL::asset('dash_assets/js/hoverable-collapse.js') }}"></script>
 <script src="{{ URL::asset('dash_assets/js/template.js') }}"></script>
 <script src="{{ URL::asset('dash_assets/js/settings.js') }}"></script>
 <script src="{{ URL::asset('dash_assets/js/todolist.js') }}"></script>
 <script src="{{ URL::asset('dash_assets/vendors/chart.js/Chart.min.js') }} "></script>
 <script src="{{ URL::asset('dash_assets/js/chart.js') }} "></script>
 <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>

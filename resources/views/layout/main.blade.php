<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{asset('/vendor/fonts/boxicons.css')}}" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{asset('/vendor/css/core.css')}}" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{asset('/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{asset('/css/demo.css')}}" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{asset('/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="{{asset('/vendor/css/pages/page-auth.css')}}" />
  <!-- Helpers -->
  <script src="{{asset('/vendor/js/helpers.js')}}"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="{{asset('/js/config.js')}}"></script>
  <title>{{$title ?? 'Laravel'}}</title>
</head>

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      @include('layout/sidebar')
      <div class="layout-page">
        <div class="container-xxl flek-graw-1 container-p-y">
          @yield('content')
        </div>
      </div>
    </div>
  </div>
  <script src="{{asset('/vendor/libs/jquery/jquery.js')}}"></script>
  <script src="{{asset('/vendor/libs/popper/popper.js')}}"></script>
  <script src="{{asset('/vendor/js/bootstrap.js')}}"></script>
  <script src="{{asset('/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

  <script src="{{asset('/vendor/js/menu.js')}}"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->

  <!-- Main JS -->
  <script src="{{asset('/js/main.js')}}"></script>
</body>

</html>

<!--
=========================================================
* Soft UI Dashboard Tailwind - v1.0.5
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard-tailwind
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Phenix</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('storage/img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('storage/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('storage/img/favicon-16x16.png') }}">
    <meta name="description" content="Dashboard du projet RP Phenix" />
    <meta name="author" content="Lacy" />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Nucleo Icons -->
    <link href="{{ url('storage/dashboard/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ url('storage/dashboard/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Main Styling -->
    <link href="{{ url('storage/dashboard/css/soft-ui-dashboard-tailwind.css') }}" rel="stylesheet" />
  </head>

  <body class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-50 text-slate-500">
    <!-- sidenav  -->
    @include("dashboard.sidebar")

    <!-- end sidenav -->

    <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
      <!-- Navbar -->
      @include("dashboard.navbar")
      <!-- end Navbar -->
        <!-- cards -->
        <div class="w-full px-6 py-6 mx-auto">
          <div class="flex flex-wrap items-center justify-center">
              @foreach ($scores as $name=>$score)
              <div class="ml-4 mr-4 text-center text-gray-500">
                  <img class="mx-auto mb-4 w-24 h-24 rounded-full" src="{{ url('storage/img/ecurie/' . $name . '.png') }}">
                  <h2 class="mb-1 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                      {{ $name }}
                  </h2>
                  <p>{{ $score }} points</p>
              </div>
              @endforeach
          </div>
      </div>
      <!-- end cards -->
    </main>
  </body>
  <!-- plugin for charts  -->
  <script src="{{ url('storage/dashboard/js/chartjs.min.js') }}" async></script>
  <!-- plugin for scrollbar  -->
  <script src="{{ url('storage/dashboard/js/perfect-scrollbar.min.js') }}" async></script>
  <!-- github button -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- main script file  -->
  <script src="{{ url('storage/dashboard/js/soft-ui-dashboard-tailwind.js') }}?v=1.0.5" async></script>
</html>

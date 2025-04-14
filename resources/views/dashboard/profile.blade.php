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
        <div class="w-full px-6 py-6 mx-auto">
        @if(session('success'))
            <div class="relative w-full p-4 text-white rounded-lg bg-emerald-500">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="relative w-full p-4 text-white bg-red-600 rounded-lg">Erreur : {{ $error }}</div>
            @endforeach
        @endif
        <!-- cards -->
        <div class="w-full px-6 py-6 mx-auto">
            <!-- row 1 -->
            <div class="flex flex-wrap my-6 -mx-3">
                <div class="w-full max-w-full px-3 mt-0 mb-6 md:mb-0 w-full">
                    <div class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                        <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
                            <div class="flex flex-wrap mt-0 -mx-3">
                                <div class="flex-none w-7/12 max-w-full px-3 mt-0 lg:w-1/2 lg:flex-none">
                                    <h6>Modifier mes informations</h6>
                                </div>
                            </div>
                        </div>
                        <div class="flex-auto p-6 px-0 pb-2">
                            <form method="POST" action="/editProfile">
                                @csrf
                                <div class="flex flex-wrap -mx-3 px-6">
                                  <div class="w-full max-w-full shrink-0 md:w-6/12 md:flex-0 px-3">
                                      <label for="name" class="mb-2 ml-1 font-bold text-xs text-slate-700">Nom complet (prénom nom)</label>
                                      <input required type="text" name="name" value="{{ auth()->user()->fullname }}" placeholder="Votre prénom et nom" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"></input>
                                  </div>
                                  <div class="w-full max-w-full shrink-0 md:w-6/12 md:flex-0 px-3">
                                      <label for="phone" class="mb-2 ml-1 text-xs text-slate-700"><span class="font-bold">Numéro de téléphone</span></label>
                                      <input type="text" name="phone" value="{{ auth()->user()->phone }}" placeholder="555-XXXX" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"></input>
                                      <label for="phone" class="mb-2 ml-1 text-xs text-slate-700"><br><small>Optionnel, obligatoire pour parier</small></label>
                                  </div>
                                </div>
                                <div class="flex flex-wrap -mx-3 mt-4 w-full">
                                    <div class="mt-4 ml-4 w-full lg:flex-none flex flex-col items-center">
                                        <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">Modifier</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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

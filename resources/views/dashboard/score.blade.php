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
@include("dashboard.head")

  <body class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-50 text-slate-500">
    <!-- sidenav  -->
    @include("dashboard.sidebar")

    <!-- end sidenav -->

    <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
      <!-- Navbar -->
      @include("dashboard.navbar")
        <div class="w-full px-6 py-6 mx-auto">
        @if(session('success'))
            <div class="relative w-full p-4 text-white rounded-lg bg-emerald-500">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="relative w-full p-4 text-white bg-red-600 rounded-lg">Erreur : {{ $error }}</div>
            @endforeach
        @endif
      <!-- end Navbar -->
        <!-- cards -->
        <div class="w-full px-6 py-6 mx-auto">
          <div class="mx-auto mb-8 max-w-screen-sm lg:mb-16">
              <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white text-center">Tableau général</h2>
          </div>
          <div class="flex flex-wrap items-center justify-center">
              @foreach ($globalScores as $id=>$score)
              <div class="ml-4 mr-4 text-center text-gray-500">
                  <img class="mx-auto mb-4 w-24 h-24" src="{{ url('storage/ecuries/' . $id . '.png') }}">
                  <h2 class="mb-1 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                      {{ $ecuries->where("id", $id)->first()->name }}
                  </h2>
                  <p>{{ $score }} points<br>{{ $ecuries->where("id", $id)->first()->sponsor == "Aucun" ? "" : "Sponsorisé par " . $ecuries->where("id", $id)->first()->sponsor }}</p>
              </div>
              @endforeach
          </div>
      </div>
        <div class="w-full max-w-full px-3 mt-0 mb-6 md:mb-0 w-full mt-4">
            <div class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
                    <div class="flex flex-wrap mt-0 -mx-3">
                        <div class="flex-none w-7/12 max-w-full px-3 mt-0 lg:w-1/2 lg:flex-none">
                            <h6>Score ({{ $currentCourse->name }})</h6>
                        </div>
                    </div>
                </div>
                <div class="flex-auto p-6 px-0 pb-2">
                    <div class="overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 pl-2 text-center font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Pilote</th>
                                    <th class="px-6 py-3 pl-2 text-center font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Écuries</th>
                                    <th class="px-6 py-3 pl-2 text-center font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Place</th>
                                    <th class="px-6 py-3 pl-2 text-center font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Points gagnés</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($scores->where("course", $currentCourse->name) as $score)
                                <tr>
                                    <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap">
                                        <span class="text-xs font-semibold leading-tight">{{ $users->where("id", $score->discord)->first()->fullname }}</span>
                                    </td>
                                    <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap">
                                        <span class="text-xs font-semibold leading-tight">{{ $score->ecurie }}</span>
                                    </td>
                                    <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap">
                                        <span class="text-xs font-semibold leading-tight">{{ $score->place }}</span>
                                    </td>
                                    <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap">
                                        <span class="text-xs font-semibold leading-tight">{{ $score->score }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      <!-- end cards -->
    </main>
  </body>
  <!-- plugin for scrollbar  -->
  <script src="{{ url('storage/dashboard/js/perfect-scrollbar.min.js') }}" async></script>
</html>

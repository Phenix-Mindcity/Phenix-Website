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
      <!-- end Navbar -->

        <!-- cards -->
        <div class="w-full px-6 py-6 mx-auto">
            @if(session('success'))
                <div class="relative w-full p-4 text-white rounded-lg bg-emerald-500">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="relative w-full p-4 text-white bg-red-600 rounded-lg">Erreur : {{ $error }}</div>
                @endforeach
            @endif
            <!-- row 1 -->
            <div class="flex flex-wrap my-6 -mx-3">
                <div class="w-full max-w-full px-3 mt-0 mb-6 md:mb-0 w-full">
                    <div class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                        <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
                            <div class="flex flex-wrap mt-0 -mx-3">
                                <div class="flex-none w-full max-w-full px-3 mt-0 lg:w-1/2 lg:flex-none">
                                    <h6>Toutes les mises</h6>
                                </div>
                            </div>
                        </div>
                        <div class="flex-auto p-6 px-0 pb-2 ml-4">
                            <div class="overflow-x-auto">
                                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                                    <thead class="align-bottom">
                                        <tr>
                                            <th class="px-6 py-3 pl-2 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Course</th>
                                            <th class="px-6 py-3 pl-2 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Parieur</th>
                                            <th class="px-6 py-3 pl-2 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Téléphone</th>
                                            <th class="px-6 py-3 pl-2 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Écurie</th>
                                            <th class="px-6 py-3 pl-2 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Montant</th>
                                            <th class="px-6 py-3 pl-2 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bets as $bet)
                                        <tr>
                                            <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b whitespace-nowrap">
                                                <span class="text-xs font-semibold leading-tight">{{ $bet->course }}</span>
                                            </td>
                                           <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b whitespace-nowrap">
                                                <span class="text-xs font-semibold leading-tight">{{ $users->where("id", $bet->discord)->first()->fullname }} ({{ $bet->id }})</span>
                                            </td>
                                            <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b whitespace-nowrap">
                                                <span class="text-xs font-semibold leading-tight">{{ $users->where("id", $bet->discord)->first()->phone }}</span>
                                            </td>
                                            <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b whitespace-nowrap">
                                                <span class="text-xs font-semibold leading-tight">{{ $bet->ecurie }}</span>
                                            </td>
                                            <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b whitespace-nowrap">
                                                <span class="text-xs font-semibold leading-tight">{{ $bet->montant }} $</span>
                                            </td>
                                            <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b whitespace-nowrap">
                                                @if ($bet->status == 0 || $bet->status == 2 || $bet->status == 4)
                                                <span class="py-2.2 px-3.6 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl from-red-600 to-rose-400 align-baseline font-bold uppercase leading-none text-white">En attente de confirmation du paiement</span>
                                                @elseif ($bet->status == 1)
                                                <span class="py-2.2 px-3.6 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl from-red-500 to-yellow-400 align-baseline font-bold uppercase leading-none text-white">En attente du résultat</span>
                                                @elseif ($bet->status == 3)
                                                <span class="py-2.2 px-3.6 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl from-red-600 to-rose-400 align-baseline font-bold uppercase leading-none text-white">Perdu</span>
                                                @elseif ($bet->status == 5)
                                                <span class="py-2.2 px-3.6 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl from-blue-600 to-cyan-400 align-baseline font-bold uppercase leading-none text-white">{{ $bet->paiement == 0 ? 'Calcul à faire' : 'Paiement à faire (' . $bet->paiement .'$)'}}</span>
                                                @elseif ($bet->status == 6)
                                                <span class="py-2.2 px-3.6 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl from-green-600 to-lime-400 align-baseline font-bold uppercase leading-none text-white">Paiement effectué</span>
                                                @endif
                                            </td>
                                            <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b whitespace-nowrap">
                                                @if (auth()->user()->rank >= 10)
                                                    @if ($bet->status == 0 || $bet->status == 2 || $bet->status == 4)
                                                    <a href="/validateBet/{{ $bet->id }}">
                                                        <button type="button" class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">Paiement reçu</button>
                                                    </a>
                                                    @elseif ($bet->status == 5)
                                                    <a href="/validateBet/{{ $bet->id }}">
                                                        <button type="button" class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">Paiement envoyé</button>
                                                    </a>
                                                    @endif
                                                    <a href="/deleteBet/{{ $bet->id }}">
                                                        <button type="button" class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-red-600 to-rose-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">Supprimer</button>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if (auth()->user()->rank >= 10)
                                <a href="/calculBet" class=" mx-0 min-w-full flex flex-col items-center">
                                    <button type="button" class="mt-4 inline-block px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-slate-600 to-slate-300 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">Faire le calcul des pari</button>
                                </a>
                                @endif
                            </div>
                        </div>
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

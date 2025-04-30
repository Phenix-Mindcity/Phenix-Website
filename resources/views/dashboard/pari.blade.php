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
                <div class="w-full max-w-full px-3 mt-0 mb-6 md:mb-0 w-7/12">
                    <div class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                        <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
                            <div class="flex flex-wrap mt-0 -mx-3">
                                <div class="flex-none w-7/12 max-w-full px-3 mt-0 lg:w-1/2 lg:flex-none">
                                    <h6>Ma mise</h6>
                                </div>
                            </div>
                        </div>
                        <div class="flex-auto p-6 px-0 pb-2">
                            <div class="overflow-x-auto">
                                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                                    <thead class="align-bottom">
                                        <tr>
                                            <th class="px-6 py-3 pl-2 text-center font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Course</th>
                                            <th class="px-6 py-3 pl-2 text-center font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Écurie</th>
                                            <th class="px-6 py-3 pl-2 text-center font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Montant</th>
                                            <th class="px-6 py-3 pl-2 text-center font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Gain</th>
                                            <th class="px-6 py-3 pl-2 text-center font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bets as $bet)
                                        <tr>
                                            <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap">
                                                <span class="text-xs font-semibold leading-tight">{{ $bet->course }}</span>
                                            </td>
                                            <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap">
                                                <span class="text-xs font-semibold leading-tight">{{ $bet->ecurie }}</span>
                                            </td>
                                            <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap">
                                                <span class="text-xs font-semibold leading-tight">{{ $bet->montant }} $</span>
                                            </td>
                                            <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap">
                                                <span class="text-xs font-semibold leading-tight {{ $bet->paiement == 0 ? '' : 'text-green-800' }}">{{ $bet->paiement == 0 ?  $bet->paiement : "+ " . $bet->paiement - $bet->montant }} $</span>
                                            </td>
                                            <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap">
                                                @if ($bet->status == 0)
                                                <span class="py-2.2 px-3.6 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl from-red-600 to-rose-400 align-baseline font-bold uppercase leading-none text-white">En attente de confirmation de ton paiement</span>
                                                @elseif ($bet->status == 1)
                                                <span class="py-2.2 px-3.6 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl from-red-500 to-yellow-400 align-baseline font-bold uppercase leading-none text-white">En attente du résultat</span>
                                                @elseif ($bet->status == 2)
                                                <span class="py-2.2 px-3.6 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl from-red-600 to-rose-400 align-baseline font-bold uppercase leading-none text-white">En attente de confirmation de ton paiement</span>
                                                @elseif ($bet->status == 3)
                                                <span class="py-2.2 px-3.6 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl from-red-600 to-rose-400 align-baseline font-bold uppercase leading-none text-white">Perdu</span>
                                                @elseif ($bet->status == 4)
                                                <span class="py-2.2 px-3.6 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl from-green-600 to-lime-400 align-baseline font-bold uppercase leading-none text-white">En attente de confirmation de ton paiement</span>
                                                @elseif ($bet->status == 5)
                                                <span class="py-2.2 px-3.6 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl from-blue-600 to-cyan-400 align-baseline font-bold uppercase leading-none text-white">Paiement en cours</span>
                                                @elseif ($bet->status == 6)
                                                <span class="py-2.2 px-3.6 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl from-green-600 to-lime-400 align-baseline font-bold uppercase leading-none text-white">Tu as gagné.e !</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 lg-max:mt-6 w-5/12">
                    <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                        <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                            <div class="flex flex-wrap -mx-3">
                                <div class="flex items-center w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-none">
                                    <h6 class="mb-0">Faire un pari</h6>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="putBet">
                            @csrf
                            <div class="flex flex-wrap -mx-3 px-6 mt-4">
                              <div class="w-full max-w-full shrink-0 md:w-6/12 md:flex-0 px-3">
                                  <label for="ecurie" class="mb-2 ml-1 font-bold text-xs text-slate-700">Écurie</label>
                                  <select required name="ecurie" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                                    @foreach ($ecuries as $erurie)
                                    <option value="{{ $erurie->name }}">{{ $erurie->name }}</option>
                                    @endforeach
                                  </select>
                              </div>
                              <div class="w-full max-w-full shrink-0 md:w-6/12 md:flex-0 px-3">
                                  <label for="montant" class="mb-2 ml-1 font-bold text-xs text-slate-700">Montant</label>
                                  <input required type="number" name="montant" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"></input>
                              </div>
                              <small><br>Une fois votre pari posé, vous ne pouvez plus annuler et vous devez verser le montant due à la présidence de l'association<br>5% des pari sont donnés à l'association pour le financement des courses<br><b>Veillez à indiquer votre numéro de téléphone sur votre profil</b></small>

                                <div class="flex flex-wrap -mx-3 mt-4 w-full mb-4">
                                    <div class="mt-4 ml-4 w-full lg:flex-none flex flex-col items-center">
                                        <button type="submit" class="inline-block px-8 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">Parier</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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

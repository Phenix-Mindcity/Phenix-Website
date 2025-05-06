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
        <!-- row 1 -->
        <div class="w-full px-6 py-6 mx-auto">
        @if(session('success'))
            <div class="relative w-full p-4 text-white rounded-lg bg-emerald-500">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="relative w-full p-4 text-white bg-red-600 rounded-lg">Erreur : {{ $error }}</div>
            @endforeach
        @endif
            <div class="flex flex-wrap my-6 -mx-3">
                <div class="w-full max-w-full px-3 lg-max:mt-6 w-full">
                    <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                        <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                            <div class="flex flex-wrap -mx-3">
                                <div class="flex items-center w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-none">
                                    <h6 class="mb-0">Ajouter une écurie</h6>
                                </div>
                            </div>
                        </div>
                        <div class="flex-auto p-4">
                            <form method="POST" action="createEcurie" enctype="multipart/form-data">
                                @csrf
                                <div class="flex flex-wrap -mx-3 px-6 mt-4">
                                  <div class="w-full max-w-full shrink-0 md:w-6/12 md:flex-0 px-3">
                                      <label for="name" class="mb-2 ml-1 font-bold text-xs text-slate-700">Nom</label>
                                      <input required type="input" name="name" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"></input>
                                  </div>
                                  <div class="w-full max-w-full shrink-0 md:w-6/12 md:flex-0 px-3">
                                      <label for="sponsor" class="mb-2 ml-1 font-bold text-xs text-slate-700">Sponsor</label>
                                      <select required name="sponsor" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                                        <option value="Aucun">Aucun</option>
                                        @foreach ($sponsors as $sponsor)
                                        <option value="{{ $sponsor->name }}">{{ $sponsor->name }}</option>
                                        @endforeach
                                      </select>
                                  </div>
                                  <div class="w-full max-w-full shrink-0 md:w-6/12 md:flex-0 px-3">
                                      <label for="inscrite" class="mb-2 ml-1 font-bold text-xs text-slate-700">Inscrire l'écurie</label>
                                      <select required name="inscrite" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                                        <option value="1">Inscrite</option>
                                        <option value="0">Non Inscrite</option>
                                      </select>
                                  </div>
                                  <div class="w-full max-w-full shrink-0 md:w-6/12 md:flex-0 px-3">
                                      <label for="logo" class="mb-2 ml-1 font-bold text-xs text-slate-700">Logo</label>
                                      <input name="logo" dropzone type="file" placeholder="Envoyer le fichier..." class="dark:bg-slate-900 dark:text-white dark:bg-gray-950 mb-4 focus:shadow-primary-outline dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">                            </div>
                                  </div>
                                    <div class="flex flex-wrap -mx-3 mt-4 w-full mb-4">
                                        <div class="mt-4 ml-4 w-full lg:flex-none flex flex-col items-center">
                                            <button type="submit" class="inline-block px-8 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">Ajouter l'écurie</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-6">
              <div class="mx-auto mb-8 max-w-screen-sm lg:mb-16">
                  <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Liste des écuries</h2>
              </div>
              <div class="flex flex-wrap items-center justify-center">
                  @foreach ($ecuries as $ecurie)
                  <div class="text-center text-gray-500 ml-4 mr-4">
                      <img class="mx-auto mb-4 w-32 h-32" src="{{ url('storage/ecuries/' . $ecurie->fileName) }}" alt="logo">
                      <h3 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                          {{ $ecurie->name }}
                      </h3>
                    <p>{{ $ecurie->sponsor }}</p>
                    <a href="/editEcurie/{{ $ecurie->id }}">
                        <button type="button" class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">Modifier</button>
                    </a>
                    <div class="flex flex-wrap items-center justify-center">
                        <a href="/deleteEcurie/{{ $ecurie->id }}" class="mt-2">
                            <button type="button" class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-red-600 to-rose-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">Supprimer</button>
                        </a>
                    </div>

                  </div>
                  @endforeach
              </div>
          </div>
      </div>
      <!-- end cards -->
    </main>
  </body>
  <!-- plugin for scrollbar  -->
  <script src="{{ url('storage/dashboard/js/perfect-scrollbar.min.js') }}" async></script>
</html>

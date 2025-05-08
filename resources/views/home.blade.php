<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Phenix</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('storage/img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('storage/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('storage/img/favicon-16x16.png') }}">
    <meta name="description" content="Page du projet RP Phenix" />
    <meta name="author" content="Lacy" />
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
    <!--Replace with your tailwind.css once created-->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
    <!-- Define your gradient here - use online tools to find a gradient matching your branding-->
    <style>
      .gradient {
        background: linear-gradient(90deg, #860f6c 0%, #d74985 100%);
      }
    </style>
  </head>
  <body class="leading-normal tracking-normal text-white gradient" style="font-family: 'Source Sans Pro', sans-serif;">
    <!--Nav-->
    <nav id="header" class="fixed w-full z-30 top-0 text-white">
      <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-2">
        <div class="pl-4 flex items-center">
          <div class="toggleColour text-white no-underline hover:no-underline font-bold text-2xl lg:text-4xl mt-4">
            <!--Icon from: http://www.potlabicons.com/ -->
            <img id="white_nav_logo" src="{{ url('storage/img/logo_white.png') }}" class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-10" alt="main_logo" />
            <img id="purple_nav_logo" src="{{ url('storage/img/logo.png') }}" class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-10 hidden" alt="white_logo" />
            Phenix
          </div>
        </div>
          <a href="/dashboard" class="items-right toggleColour">
              <button id="navBtn" class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 mt-2 font-bold rounded-full py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                Se connecter
              </button>
          </a>
      </div>
    </nav>
    <!--Hero-->
    <div class="pt-24 mt-6">
        <div class="w-full px-32 py-6 mx-auto">
            @if (session('error'))
            <div class="text-center py-4 lg:px-4">
              <div class="p-2 bg-red-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                <span class="flex rounded-full bg-red-500 uppercase px-2 py-1 text-xs font-bold mr-3">Erreur</span>
                <span class="font-semibold mr-2 text-left flex-auto">{{ session('error') }}</span>
              </div>
            </div>
            @endif
        </div>
      <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center mt-12">
        <!--Left Col-->
        <div class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left">
          <p class="uppercase tracking-loose w-full">Phenix Fivefold Crown</p>
          <h1 class="my-4 text-5xl font-bold leading-tight">
            L'Événement automobile de l'année !
          </h1>
          <p class="leading-normal text-2xl mb-8">
            5 épreuves, 5 catégories, un titre à gagner.
          </p>
        </div>
      </div>
    </div>
    <div class="relative -mt-12 lg:-mt-24">
      <svg viewBox="0 0 1428 174" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g transform="translate(-2.000000, 44.000000)" fill="#FFFFFF" fill-rule="nonzero">
            <path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496" opacity="0.100000001"></path>
            <path
              d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
              opacity="0.100000001"
            ></path>
            <path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z" id="Path-4" opacity="0.200000003"></path>
          </g>
          <g transform="translate(-4.000000, 76.000000)" fill="#FFFFFF" fill-rule="nonzero">
            <path
              d="M0.457,34.035 C57.086,53.198 98.208,65.809 123.822,71.865 C181.454,85.495 234.295,90.29 272.033,93.459 C311.355,96.759 396.635,95.801 461.025,91.663 C486.76,90.01 518.727,86.372 556.926,80.752 C595.747,74.596 622.372,70.008 636.799,66.991 C663.913,61.324 712.501,49.503 727.605,46.128 C780.47,34.317 818.839,22.532 856.324,15.904 C922.689,4.169 955.676,2.522 1011.185,0.432 C1060.705,1.477 1097.39,3.129 1121.236,5.387 C1161.703,9.219 1208.621,17.821 1235.4,22.304 C1285.855,30.748 1354.351,47.432 1440.886,72.354 L1441.191,104.352 L1.121,104.031 L0.457,34.035 Z"
            ></path>
          </g>
        </g>
      </svg>
    </div>

    <section class="bg-white border-b py-8">
      <div class="container max-w-5xl mx-auto m-8">
        <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
          Courses
        </h2>
        <div class="w-full mb-4">
          <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
        </div>
        <div class="flex flex-wrap">
          <div class="w-5/6 sm:w-1/2 p-6">
            <h3 class="text-3xl text-gray-800 font-bold leading-none mb-3">
              Rallye
            </h3>
            <p class="text-gray-600 mb-8">
              Un quatre cylindre de 450 chevaux, 4 roues motrices, le 0 à 100 km/h abbatu en 3.8 secondes.
              <br><br>
              Le tout dans des chemins de terre, en enchainant les virages, à quelques mètres du vide
              <br>
              <br>
              Retrouvez l'âme du Groupe B, dans une voiture mythique, rappelant l'âge d'or du Rallye mondiale.

              @if ($courses->where("name", "Rallye")->first()->date != null)
              <br><br>
              <b>{{ $courses->where("name", "Rallye")->first()->current == 1 ? 'Date : ' . \Carbon\Carbon::parse($courses->where("name", "Rallye")->first()->date)->translatedFormat('d F Y à H:i') : 'Prévu en ' . \Carbon\Carbon::parse($courses->where("name", "Rallye")->first()->date)->translatedFormat('F Y'); }}</b>
              @endif
            </p>
          </div>
          <div class="w-full sm:w-1/2 p-6">
            <img src="{{ url('storage/img/courses/Rallye.jpg') }}"> 1410 768
          </div>
        </div>
        <div class="flex flex-wrap flex-col-reverse sm:flex-row">
          <div class="w-full sm:w-1/2 p-6 mt-6">
            <img src="{{ url('storage/img/courses/ringofhell.webp') }}">
          </div>
          <div class="w-full sm:w-1/2 p-6 mt-6">
            <div class="align-middle">
              <h3 class="text-3xl text-gray-800 font-bold leading-none mb-3">
                Ring Of Hell
              </h3>
              <p class="text-gray-600 mb-8">
                Un cercle sans fin, détruisez vos adversaires, et priez que le sors vous soit favorable
                <br><br>
                Le dernier moteur qui tourne, sera couronné gagnant.

                @if ($courses->where("name", "Ring Of Hell")->first()->date != null)
                <br><br>
              <b>{{ $courses->where("name", "Ring Of Hell")->first()->current == 1 ? 'Date : ' . \Carbon\Carbon::parse($courses->where("name", "Ring Of Hell")->first()->date)->translatedFormat('d F Y à H:i') : 'Prévu en ' . \Carbon\Carbon::parse($courses->where("name", "Ring Of Hell")->first()->date)->translatedFormat('F Y'); }}</b>
                @endif
              </p>
            </div>
          </div>
        </div>
        <div class="flex flex-wrap">
          <div class="w-5/6 sm:w-1/2 p-6">
            <h3 class="text-3xl text-gray-800 font-bold leading-none mb-3">
              Street Race
            </h3>
            <p class="text-gray-600 mb-8">
              Non, vous ne rêvez pas, on a réussi à ressortir ce véhicule mythique, produit à 400 exemplaires, une légende du japon, une déesse de la route
              <br><br>
              Le moteur qui ronronne, les pneus qui agrippe le bitume, la ville est notre terrain de jeu.
              @if ($courses->where("name", "Street Race")->first()->date != null)
              <br><br>
              <b>{{ $courses->where("name", "Street Race")->first()->current == 1 ? 'Date : ' . \Carbon\Carbon::parse($courses->where("name", "Street Race")->first()->date)->translatedFormat('d F Y à H:i') : 'Prévu en ' . \Carbon\Carbon::parse($courses->where("name", "Street Race")->first()->date)->translatedFormat('F Y'); }}</b>
              @endif
            </p>
          </div>
          <div class="w-full sm:w-1/2 p-6">
            <img src="{{ url('storage/img/courses/StreetRace.jpg') }}">
          </div>
        </div>
        <div class="flex flex-wrap flex-col-reverse sm:flex-row">
          <div class="w-full sm:w-1/2 p-6 mt-6">
            <img src="{{ url('storage/img/courses/F1.png') }}">
          </div>
          <div class="w-full sm:w-1/2 p-6 mt-6">
            <div class="align-middle">
              <h3 class="text-3xl text-gray-800 font-bold leading-none mb-3">
                F1
              </h3>
              <p class="text-gray-600 mb-8">
                Posé.e dans le cockpit, les yeux rivées sur la piste, le V12 qui crie de toutes ses forces, soyez prêt.e
                <br><br>
                <small>Avec un peu de chance, vous croiserez un Espace sur la piste</small>

                @if ($courses->where("name", "F1")->first()->date != null)
                <br><br>
                 <b>{{ $courses->where("name", "F1")->first()->current == 1 ? 'Date : ' . \Carbon\Carbon::parse($courses->where("name", "F1")->first()->date)->translatedFormat('d F Y à H:i') : 'Prévu en ' . \Carbon\Carbon::parse($courses->where("name", "F1")->first()->date)->translatedFormat('F Y'); }}</b>
                @endif
              </p>
            </div>
          </div>
        </div>
        <div class="flex flex-wrap">
          <div class="w-5/6 sm:w-1/2 p-6">
            <h3 class="text-3xl text-gray-800 font-bold leading-none mb-3">
              👀 Surprise
            </h3>
            <p class="text-gray-600 mb-8">
              J'aurais aimée vous teaser, vous dire à quel point ce sera incroyable, mais pourquoi tout spoiler ?
              <br><br>
              Vous découvrirez l'épreuve, le jour de la course !

              @if ($courses->where("name", "Truck")->first()->date != null)
              <br><br>
              <b>{{ $courses->where("name", "Truck")->first()->current == 1 ? 'Date : ' . \Carbon\Carbon::parse($courses->where("name", "Truck")->first()->date)->translatedFormat('d F Y à H:i') : 'Prévu en ' . \Carbon\Carbon::parse($courses->where("name", "Truck")->first()->date)->translatedFormat('F Y'); }}</b>
              @endif
            </p>
          </div>
          <div class="w-full sm:w-1/2 p-6">

          </div>
        </div>
      </div>
    </section>
    <section class="bg-gray-100 py-8">
      <div class="container mx-auto px-2 pt-4 pb-12 text-gray-800">
        <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
          Inscriptions
        </h2>
        <div class="w-full mb-4">
          <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
        </div>
        <div class="flex flex-col sm:flex-row justify-center pt-12 my-12 sm:my-4">
          <div class="flex flex-col w-5/6 lg:w-1/4 mx-auto lg:mx-0 rounded-none lg:rounded-l-lg bg-white mt-4">
            <div class="flex-1 bg-white text-gray-600 rounded-t rounded-b-none overflow-hidden shadow">
              <div class="p-8 text-3xl font-bold text-center border-b-4">
                Particulier
              </div>
              <ul class="w-full text-center text-sm">
                <li class="border-b py-4">1 écurie par inscription</li>
                <li class="border-b py-4"><s>Logo affiché sur le site et dans la presse</s></li>
              </ul>
            </div>
            <div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
              <div class="w-full pt-6 text-3xl text-gray-600 font-bold text-center">
                $ 5 000
              </div>
            </div>
          </div>
          <div class="flex flex-col w-5/6 lg:w-1/3 mx-auto lg:mx-0 rounded-lg bg-white mt-4 sm:-mt-6 shadow-lg z-10">
            <div class="flex-1 bg-white rounded-t rounded-b-none overflow-hidden shadow">
              <div class="w-full p-8 text-3xl font-bold text-center">
                  Entreprise
              </div>
              <div class="h-1 w-full gradient my-0 py-0 rounded-t"></div>
              <ul class="w-full text-center text-base font-bold">
                <li class="border-b py-4">2 écuries par inscription</li>
                <li class="border-b py-4">Logo affiché sur le site et dans la presse</li>
              </ul>
            </div>
            <div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
              <div class="w-full pt-6 text-4xl font-bold text-center">
                $ 20 000
              </div>
            </div>
          </div>
          <div class="flex flex-col w-5/6 lg:w-1/4 mx-auto lg:mx-0 rounded-none lg:rounded-l-lg bg-white mt-4">
            <div class="flex-1 bg-white text-gray-600 rounded-t rounded-b-none overflow-hidden shadow">
              <div class="p-8 text-3xl font-bold text-center border-b-4">
                Organisation
              </div>
              <ul class="w-full text-center text-sm">
                <li class="border-b py-4">1 écurie par inscription</li>
                <li class="border-b py-4">Logo affiché sur le site et dans la presse</li>
              </ul>
            </div>
            <div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
              <div class="w-full pt-6 text-3xl text-gray-600 font-bold text-center">
                $ 10 000
              </div>
            </div>
          </div>
        </div>
        <p class="leading-normal text-l text-center">
            L'inscription est gratuite pour un pilote, tant qu'il est dans une écurie.<br>Les pilotes sans écuries peuvent se proposer en remplaçant
            <br><br>
            Pour vous inscrire, contactez-nous par téléphone
        </p>
      </div>
    </section>
    <section class="bg-white">
      <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-6">
          <div class="mx-auto mb-8 max-w-screen-sm lg:mb-16">
              <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Nos partenaires</h2>
          </div>
          <div class="flex flex-wrap items-center justify-center">
              @foreach ($sponsors as $sponsor)
              <div class="text-center text-gray-500 ml-4 mb-4 w-60">
                  <img class="mx-auto mb-4 w-36 h-36" src="{{ url('storage/sponsors/' . $sponsor->fileName) }}" alt="logo">
                  <h3 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                      {{ $sponsor->name }}
                  </h3>
                <p>{{ $sponsor->description }}</p>
              </div>
              @endforeach
          </div>
      </div>
    </section>
    <section class="bg-gray-100">
      <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-6">
          <div class="mx-auto mb-8 max-w-screen-sm lg:mb-16">
              <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Notre équipe</h2>
          </div>
          <div class="grid gap-8 lg:gap-16 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
              @foreach ($members as $member)
              <div class="text-center text-gray-500">
                  <img class="mx-auto mb-4 w-36 h-36 rounded-full" src="{{ url('storage/profile/' . $member->id . '.png') }}">
                  <h3 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                      {{ $member->fullname }}
                  </h3>
                  <p>{{ $member->role }}<br><small>{{ $member->phone }}</small></p>
              </div>
              @endforeach
          </div>
      </div>
    </section>
    <!-- Change the colour #f8fafc to match the previous section colour -->
    <svg class="wave-top" viewBox="0 0 1439 147" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g transform="translate(-1.000000, -14.000000)" fill-rule="nonzero">
          <g class="wave" fill="#f3f4f6">
            <path
              d="M1440,84 C1383.555,64.3 1342.555,51.3 1317,45 C1259.5,30.824 1206.707,25.526 1169,22 C1129.711,18.326 1044.426,18.475 980,22 C954.25,23.409 922.25,26.742 884,32 C845.122,37.787 818.455,42.121 804,45 C776.833,50.41 728.136,61.77 713,65 C660.023,76.309 621.544,87.729 584,94 C517.525,105.104 484.525,106.438 429,108 C379.49,106.484 342.823,104.484 319,102 C278.571,97.783 231.737,88.736 205,84 C154.629,75.076 86.296,57.743 0,32 L0,0 L1440,0 L1440,84 Z"
            ></path>
          </g>
          <g transform="translate(1.000000, 15.000000)" fill="#FFFFFF">
            <g transform="translate(719.500000, 68.500000) rotate(-180.000000) translate(-719.500000, -68.500000) ">
              <path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496" opacity="0.100000001"></path>
              <path
                d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
                opacity="0.100000001"
              ></path>
              <path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z" opacity="0.200000003"></path>
            </g>
          </g>
        </g>
      </g>
    </svg>
    <section class="container mx-auto text-center py-6 mb-12">
      <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-white">
        Connecte-toi !
      </h2>
      <div class="w-full mb-4">
        <div class="h-1 mx-auto bg-white w-1/6 opacity-25 my-0 py-0 rounded-t"></div>
      </div>
      <h3 class="my-4 text-3xl leading-tight">
        Pour accéder aux score, pari et résultats
      </h3>
      <a href="/dashboard">
          <button class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
            Se connecter
          </button>
      </a>
    </section>
    <!--Footer-->
    <footer class="bg-white">
      <div class="container mx-auto px-8">
        <div class="w-full flex flex-col md:flex-row py-6">
          <div class="flex-1 mb-6 text-black">
          <div class="text-color-title no-underline hover:no-underline font-bold text-2xl lg:text-4xl mt-4">
              <img src="{{ url('storage/img/logo.png') }}" class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-10" alt="main_logo" />
              Phenix
            </div>
            <br>
            <small>Ce site est destiné à du jeu de rôle sur le serveur GTA RP <a href="https://discord.gg/mindcityrp"><b>MindCity</b></a><br>Ce site n'est pas développé ou maintenu par Mindcity, géré par ImLacy_ (Discord)</small>
          </div>
          <div class="flex-1">
            <p class="uppercase text-gray-500 md:mb-6">Association Phenix</p>
            <ul class="list-reset mb-6">
              <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                <div class="text-gray-800"><a target="_blank" href="https://discord.gg/b6YntEPFCP">Accéder à notre intranet</a></div>
              </li>
              <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                <div class="text-gray-800"><a target="_blank" href="https://github.com/Phenix-Mindcity/Phenix-Website">Code source du site</a></div>
              </li>
              <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                <div class="text-gray-800"><a target="_blank" href="https://github.com/Phenix-Mindcity/Phenix-Documents">Nos documents</a></div>
              </li>
            </ul>
          </div>
          <div class="flex-1">
            <p class="uppercase text-gray-500 md:mb-6"></p>
            <ul class="list-reset mb-6">
              <!--<li class="mt-2 inline-block mr-2 md:block md:mr-0">
                <a href="#" class="no-underline hover:underline text-gray-800 hover:text-pink-500">FAQ</a>
              </li>-->
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <script>
      var scrollpos = window.scrollY;
      var header = document.getElementById("header");
      var white_nav_logo = document.getElementById("white_nav_logo");
      var purple_nav_logo = document.getElementById("purple_nav_logo");
      var navBtn = document.getElementById("navBtn");
      var toToggle = document.querySelectorAll(".toggleColour");

      document.addEventListener("scroll", function () {
        /*Apply classes for slide in bar*/
        scrollpos = window.scrollY;

        if (scrollpos > 140) {
          header.classList.add("bg-white");
          white_nav_logo.classList.add("hidden");
          purple_nav_logo.classList.remove("hidden");

          navBtn.classList.add("bg-btn");
          navBtn.classList.remove("bg-white");

          //Use to switch toggleColour colours
          for (var i = 0; i < toToggle.length; i++) {
            toToggle[i].classList.add("text-color-title");
            toToggle[i].classList.remove("text-white");
          }
          header.classList.add("shadow");
        } else {
          header.classList.remove("bg-white");
          purple_nav_logo.classList.add("hidden");
          white_nav_logo.classList.remove("hidden");

          navBtn.classList.remove("bg-btn");
          navBtn.classList.add("bg-white");

          //Use to switch toggleColour colours
          for (var i = 0; i < toToggle.length; i++) {
            toToggle[i].classList.add("text-white");
            toToggle[i].classList.remove("text-color-title");
          }

          header.classList.remove("shadow");
        }
      });
    </script>
    <style>
        .text-color-title {
            background: linear-gradient(90deg, #860f6c 0%, #d74985 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .bg-btn {
            background: linear-gradient(90deg, #860f6c 0%, #d74985 100%);
            color: white;
        }
    </style>
  </body>
</html>

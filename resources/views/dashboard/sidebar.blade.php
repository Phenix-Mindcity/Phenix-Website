<aside class="max-w-62.5 ease-nav-brand z-990 fixed inset-y-0 my-4 ml-4 block w-full -translate-x-full flex-wrap items-center justify-between overflow-y-auto rounded-2xl border-0 bg-white p-0 antialiased shadow-none transition-transform duration-200 xl:left-0 xl:translate-x-0 xl:bg-transparent">
  <div class="h-19.5">
    <i class="absolute top-0 right-0 hidden p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden" sidenav-close></i>
    <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="/">
      <img src="{{ url('storage/dashboard/img/logo.png') }}" class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-8" alt="main_logo" />
      <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Phenix</span>
    </a>
  </div>

  <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />

  <div class="items-center block w-auto max-h-screen overflow-auto grow basis-full h-screen">
    <ul class="flex flex-col pl-0 mb-0">
      <li class="mt-0.5 w-full">
        <a href="{{ route('dashboard.home') }}" class="{{ (request()->is('dashboard')) ? 'rounded-lg bg-white font-semibold text-slate-700 shadow-soft-xl' : '' }} px-4 py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap transition-colors">
          <div class="{{ (request()->is('dashboard')) ? 'bg-gradient-to-tl from-purple-700 to-pink-500' : '' }} shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
              <span class="{{ (request()->is('dashboard')) ? 'text-white' : '' }} material-symbols-outlined">home</span>
          </div>
          <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Accueil</span>
        </a>
      </li>
      <li class="mt-0.5 w-full">
        <a href="{{ route('dashboard.participants') }}" class="{{ (request()->is('participants')) ? 'rounded-lg bg-white font-semibold text-slate-700 shadow-soft-xl' : '' }} px-4 py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap transition-colors">
          <div class="{{ (request()->is('participants')) ? 'bg-gradient-to-tl from-purple-700 to-pink-500' : '' }} shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
              <span class="{{ (request()->is('participants')) ? 'text-white' : '' }} material-symbols-outlined">groups</span>
          </div>
          <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Participants</span>
        </a>
      </li>
      <li class="mt-0.5 w-full">
        <a href="{{ route('dashboard.score') }}" class="{{ (request()->is('score')) ? 'rounded-lg bg-white font-semibold text-slate-700 shadow-soft-xl' : '' }} px-4 py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap transition-colors">
          <div class="{{ (request()->is('score')) ? 'bg-gradient-to-tl from-purple-700 to-pink-500' : '' }} shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
              <span class="{{ (request()->is('score')) ? 'text-white' : '' }} material-symbols-outlined">scoreboard</span>
          </div>
          <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Tableau des scores</span>
        </a>
      </li>
      <li class="mt-0.5 w-full">
        <a href="{{ route('dashboard.pari') }}" class="{{ (request()->is('pari')) ? 'rounded-lg bg-white font-semibold text-slate-700 shadow-soft-xl' : '' }} px-4 py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap transition-colors">
          <div class="{{ (request()->is('pari')) ? 'bg-gradient-to-tl from-purple-700 to-pink-500' : '' }} shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
              <span class="{{ (request()->is('pari')) ? 'text-white' : '' }} material-symbols-outlined">attach_money</span>
          </div>
          <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Parier</span>
        </a>
      </li>


        @if (auth()->user()->rank >= 5)
            <li class="w-full mt-4">
                <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase opacity-60">Association</h6>
            </li>
            <li class="mt-0.5 w-full">
                <a href="{{ route('dashboard.view_pari') }}" class="{{ (request()->is('view_pari')) ? 'rounded-lg bg-white font-semibold text-slate-700 shadow-soft-xl' : '' }} px-4 py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap transition-colors">
                    <div class="{{ (request()->is('view_pari')) ? 'bg-gradient-to-tl from-purple-700 to-pink-500' : '' }} shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                        <span class="{{ (request()->is('view_pari')) ? 'text-white' : '' }} material-symbols-outlined">attach_money</span>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Vue des pari</span>
                </a>
            </li>
            @if (auth()->user()->rank >= 6)
            <li class="mt-0.5 w-full">
                <a href="{{ route('dashboard.inscription') }}" class="{{ (request()->is('inscription')) ? 'rounded-lg bg-white font-semibold text-slate-700 shadow-soft-xl' : '' }} px-4 py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap transition-colors">
                    <div class="{{ (request()->is('inscription')) ? 'bg-gradient-to-tl from-purple-700 to-pink-500' : '' }} shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                        <span class="{{ (request()->is('inscription')) ? 'text-white' : '' }} material-symbols-outlined">group_add</span>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Inscription</span>
                </a>
            </li>
            <li class="mt-0.5 w-full">
                <a href="{{ route('dashboard.ecurie') }}" class="{{ (request()->is('ecurie')) ? 'rounded-lg bg-white font-semibold text-slate-700 shadow-soft-xl' : '' }} px-4 py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap transition-colors">
                    <div class="{{ (request()->is('ecurie')) ? 'bg-gradient-to-tl from-purple-700 to-pink-500' : '' }} shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                        <span class="{{ (request()->is('ecurie')) ? 'text-white' : '' }} material-symbols-outlined">groups</span>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Écurie</span>
                </a>
            </li>
            <li class="mt-0.5 w-full">
                <a href="{{ route('dashboard.sponsor') }}" class="{{ (request()->is('sponsor')) ? 'rounded-lg bg-white font-semibold text-slate-700 shadow-soft-xl' : '' }} px-4 py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap transition-colors">
                    <div class="{{ (request()->is('sponsor')) ? 'bg-gradient-to-tl from-purple-700 to-pink-500' : '' }} shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                        <span class="{{ (request()->is('sponsor')) ? 'text-white' : '' }} material-symbols-outlined">handshake</span>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Sponsors</span>
                </a>
            </li>

                @if (auth()->user()->rank >= 10)
                <li class="mt-0.5 w-full">
                    <a href="{{ route('dashboard.result') }}" class="{{ (request()->is('result')) ? 'rounded-lg bg-white font-semibold text-slate-700 shadow-soft-xl' : '' }} px-4 py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap transition-colors">
                        <div class="{{ (request()->is('result')) ? 'bg-gradient-to-tl from-purple-700 to-pink-500' : '' }} shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                            <span class="{{ (request()->is('result')) ? 'text-white' : '' }} material-symbols-outlined">sports_score</span>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Résultats</span>
                    </a>
                </li>
                <li class="mt-0.5 w-full">
                    <a href="{{ route('dashboard.membres') }}" class="{{ (request()->is('membres')) ? 'rounded-lg bg-white font-semibold text-slate-700 shadow-soft-xl' : '' }} px-4 py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap transition-colors">
                        <div class="{{ (request()->is('membres')) ? 'bg-gradient-to-tl from-purple-700 to-pink-500' : '' }} shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                            <span class="{{ (request()->is('membres')) ? 'text-white' : '' }} material-symbols-outlined">manage_accounts</span>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Gérer les membres</span>
                    </a>
                </li>
                @endif
            @endif
        @endif
    </ul>
  </div>
</aside>

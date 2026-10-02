<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <div class="flex items-center gap-2 px-2 py-1.5 -ml-2">
                        <x-application-logo class="h-9 w-9 text-indigo-600" />
                        <span class="hidden sm:block text-base font-semibold tracking-tight text-gray-900">
                            flex<span class="text-indigo-600">_sgi</span>
                        </span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-8 sm:flex sm:items-center">
                    @php $dashboardActive = request()->routeIs('dashboard'); @endphp

                    <a href="{{ route('dashboard') }}"
                       @class([
                           'group relative inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium',
                           'transition-all duration-150',
                           'focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2',
                           'text-indigo-700 bg-indigo-50'                          => $dashboardActive,
                           'text-gray-600 hover:text-gray-900 hover:bg-gray-100'   => ! $dashboardActive,
                       ])
                       @if($dashboardActive) aria-current="page" @endif>

                        <!-- Ícone de grid / dashboard -->
                        <svg class="h-4 w-4 shrink-0 transition-transform duration-150 group-hover:scale-110"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="3"  width="7" height="9" rx="1.5"/>
                            <rect x="14" y="3" width="7" height="5" rx="1.5"/>
                            <rect x="14" y="12" width="7" height="9" rx="1.5"/>
                            <rect x="3" y="16" width="7" height="5" rx="1.5"/>
                        </svg>

                        <span>{{ __('Dashboard Principal') }}</span>

                        <!-- Indicador ativo -->
                        @if($dashboardActive)
                            <span class="absolute -bottom-[9px] left-3 right-3 h-0.5 rounded-full bg-indigo-600"></span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-2.5 py-1.5 border border-transparent text-sm leading-4 font-medium rounded-lg
                                       text-gray-600 bg-white hover:text-gray-900 hover:bg-gray-100
                                       focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2
                                       transition ease-in-out duration-150">
                            @auth
                                <!-- Avatar com iniciais -->
                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">
                                    {{ strtoupper(\Illuminate\Support\Str::substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden md:block">{{ Auth::user()->name }}</span>
                            @endauth

                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    class="flex items-center gap-2"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                    <polyline points="16 17 21 12 16 7"/>
                                    <line x1="21" y1="12" x2="9" y2="12"/>
                                </svg>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400
                               hover:text-gray-500 hover:bg-gray-100
                               focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500
                               focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                        aria-label="Toggle navigation menu"
                        :aria-expanded="open.toString()">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @php $dashboardActiveMobile = request()->routeIs('dashboard'); @endphp

            <a href="{{ route('dashboard') }}"
               @class([
                   'flex items-center gap-3 px-4 py-2.5 text-sm font-medium border-l-2',
                   'text-indigo-700 bg-indigo-50 border-indigo-600'                                      => $dashboardActiveMobile,
                   'text-gray-700 hover:bg-gray-50 hover:text-gray-900 border-transparent'               => ! $dashboardActiveMobile,
               ])
               @if($dashboardActiveMobile) aria-current="page" @endif>
                <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3"  width="7" height="9" rx="1.5"/>
                    <rect x="14" y="3" width="7" height="5" rx="1.5"/>
                    <rect x="14" y="12" width="7" height="9" rx="1.5"/>
                    <rect x="3" y="16" width="7" height="5" rx="1.5"/>
                </svg>
                <span>{{ __('Dashboard') }}</span>
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                @auth
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-sm font-semibold">
                            {{ strtoupper(\Illuminate\Support\Str::substr(Auth::user()->name, 0, 1)) }}
                        </span>
                        <div>
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                @endauth
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            class="flex items-center gap-3"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
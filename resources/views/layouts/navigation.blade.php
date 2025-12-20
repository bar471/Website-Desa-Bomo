@if(Auth::user()->role === 'admin')
    
@else
    {{-- ========================================== --}}
    {{-- NAVBAR USER: TETAP ADA (UKURAN KOMPAK)     --}}
    {{-- ========================================== --}}
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-5xl mx-auto px-6 sm:px-8"> 
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/banyuwangi.png') }}" class="h-8 w-auto" alt="Logo Desa" />
                    <span class="text-sm font-bold text-gray-800 uppercase tracking-tight">Desa Bomo</span>
                </div>

                <div class="flex items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 transition">
                                <div class="font-bold uppercase tracking-tight">{{ Auth::user()->name }}</div>
                                <div class="ms-1 italic text-[10px] text-gray-400">(User)</div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </nav>
@endif
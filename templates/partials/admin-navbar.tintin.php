<!-- Navbar -->
<nav class="bg-primary-800 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Navigation Links -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <div class="h-9 w-9 bg-white rounded-lg flex items-center justify-center">
                        <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="ml-3 text-lg font-bold text-white">BCET/COURRIER</span>
                </div>
                <!-- Desktop Navigation -->
                <div class="hidden md:ml-8 md:flex md:space-x-4">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->url() === route('dashboard') ? 'bg-primary-900 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }}">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('users.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md {{ str_contains(request()->url(), '/users') ? 'bg-primary-900 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }}">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Utilisateurs
                    </a>
                    <a href="{{ route('couriers.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md {{ str_contains(request()->url(), '/couriers') ? 'bg-primary-900 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }}">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Colis
                    </a>
                    <a href="{{ route('services.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md {{ str_contains(request()->url(), '/services') ? 'bg-primary-900 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }}">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Services
                    </a>
                </div>
            </div>
            <!-- User Menu -->
            <div class="hidden md:flex md:items-center md:space-x-4">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-3 text-primary-100 hover:text-white focus:outline-none">
                        <div class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center">
                            <span class="text-sm font-medium text-white">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                        </div>
                        <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <div class="px-4 py-2 border-b">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrateur</p>
                        </div>
                        <a href="{{ route('auth.logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <svg class="inline-block mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Déconnexion
                        </a>
                    </div>
                </div>
            </div>
            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-primary-100 hover:text-white hover:bg-primary-700 focus:outline-none">
                    <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" x-transition class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->url() === route('dashboard') ? 'bg-primary-900 text-white' : 'text-primary-100 hover:bg-primary-700' }}">Dashboard</a>
            <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ str_contains(request()->url(), '/users') ? 'bg-primary-900 text-white' : 'text-primary-100 hover:bg-primary-700' }}">Utilisateurs</a>
            <a href="{{ route('couriers.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ str_contains(request()->url(), '/couriers') ? 'bg-primary-900 text-white' : 'text-primary-100 hover:bg-primary-700' }}">Colis</a>
            <a href="{{ route('services.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ str_contains(request()->url(), '/services') ? 'bg-primary-900 text-white' : 'text-primary-100 hover:bg-primary-700' }}">Services</a>
        </div>
        <div class="pt-4 pb-3 border-t border-primary-700">
            <div class="flex items-center px-4">
                <div class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center">
                    <span class="text-sm font-medium text-white">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                </div>
                <div class="ml-3">
                    <p class="text-base font-medium text-white">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-primary-300">Administrateur</p>
                </div>
            </div>
            <div class="mt-3 px-2">
                <a href="{{ route('auth.logout') }}" class="block px-3 py-2 rounded-md text-base font-medium text-red-300 hover:bg-primary-700">Déconnexion</a>
            </div>
        </div>
    </div>
</nav>

%extends('layouts.app')

%block('title', 'Dashboard Admin - BCET/COURRIER')

%block('content')
<div x-data="{ mobileMenuOpen: false, userMenuOpen: false }" class="min-h-screen bg-gray-100">
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

    <!-- Main content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            %if(flash('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ flash('success') }}
            </div>
            %endif

            %if(flash('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ flash('error') }}
            </div>
            %endif

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                <!-- Total Agents -->
                <div class="bg-white overflow-hidden shadow rounded-xl">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Agents</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $stats['total_agents'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Couriers -->
                <div class="bg-white overflow-hidden shadow rounded-xl">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-purple-100 rounded-lg">
                                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Colis</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $stats['total_couriers'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending -->
                <div class="bg-white overflow-hidden shadow rounded-xl">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-yellow-100 rounded-lg">
                                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">En attente</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $stats['pending_couriers'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivered -->
                <div class="bg-white overflow-hidden shadow rounded-xl">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-green-100 rounded-lg">
                                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Livrés</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $stats['delivered_couriers'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Couriers -->
                <div class="bg-white shadow rounded-xl">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Colis récents</h3>
                            <a href="/admin/couriers" class="text-sm text-primary-600 hover:text-primary-800">Voir tout →</a>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200">
                        %if(count($recent_couriers) > 0)
                            %loop($recent_couriers as $courier)
                            <div class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $courier->tracking_number }}</p>
                                        <p class="text-sm text-gray-500">{{ $courier->receiver_name }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        %if($courier->status === 'delivered')
                                        bg-green-100 text-green-800
                                        %elseif($courier->status === 'in_transit')
                                        bg-purple-100 text-purple-800
                                        %elseif($courier->status === 'pending')
                                        bg-yellow-100 text-yellow-800
                                        %else
                                        bg-gray-100 text-gray-800
                                        %endif
                                    ">
                                        {{ $courier->getStatusLabel() }}
                                    </span>
                                </div>
                            </div>
                            %endloop
                        %else
                            <div class="px-6 py-8 text-center text-gray-500">
                                Aucun colis enregistré
                            </div>
                        %endif
                    </div>
                </div>

                <!-- Recent Agents -->
                <div class="bg-white shadow rounded-xl">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Agents récents</h3>
                            <a href="/admin/agents" class="text-sm text-primary-600 hover:text-primary-800">Voir tout →</a>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200">
                        %if(count($recent_agents) > 0)
                            %loop($recent_agents as $agent)
                            <div class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-primary-700">{{ strtoupper(substr($agent->name, 0, 2)) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $agent->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $agent->email }}</p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $agent->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $agent->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </div>
                            </div>
                            %endloop
                        %else
                            <div class="px-6 py-8 text-center text-gray-500">
                                Aucun agent enregistré
                            </div>
                        %endif
                    </div>
                </div>
            </div>
    </main>
</div>
%endblock

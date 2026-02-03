%extends('layouts.app')

%block('title', 'Dashboard Agent - BCET/COURRIER')

%block('content')
<div x-data="{ mobileMenuOpen: false }" class="min-h-screen bg-gray-100">
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
                        <a href="{{ route('couriers.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md {{ str_contains(request()->url(), '/couriers') ? 'bg-primary-900 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }}">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Mes Colis
                        </a>
                        <a href="{{ route('couriers.create') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md bg-white text-primary-700 hover:bg-primary-50">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Nouveau Colis
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
                                <p class="text-xs text-gray-500">Agent</p>
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
                <a href="{{ route('couriers.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ str_contains(request()->url(), '/couriers') ? 'bg-primary-900 text-white' : 'text-primary-100 hover:bg-primary-700' }}">Mes Colis</a>
                <a href="{{ route('couriers.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-primary-600 hover:bg-primary-500">+ Nouveau Colis</a>
            </div>
            <div class="pt-4 pb-3 border-t border-primary-700">
                <div class="flex items-center px-4">
                    <div class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center">
                        <span class="text-sm font-medium text-white">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-base font-medium text-white">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-primary-300">Agent</p>
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

        <!-- Welcome Message -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Bonjour, {{ auth()->user()->name }} 👋</h2>
            <p class="mt-1 text-gray-600">Voici un aperçu de votre activité</p>
        </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total colis</dt>
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

                <!-- In Transit -->
                <div class="bg-white overflow-hidden shadow rounded-xl">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">En transit</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $stats['in_transit_couriers'] }}</dd>
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

            <!-- Quick Actions -->
            <div class="mb-8">
                <a href="{{ route('couriers.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Enregistrer un nouveau colis
                </a>
            </div>

            <!-- Recent Couriers -->
            <div class="bg-white shadow rounded-xl">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Colis récents</h3>
                        <a href="{{ route('couriers.index') }}" class="text-sm text-primary-600 hover:text-primary-800">Voir tout →</a>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    %if(count($recent_couriers) > 0)
                        %loop($recent_couriers as $courier)
                        <a href="{{ route('couriers.show', ['id' => $courier->id]) }}" class="block px-6 py-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-mono font-medium text-primary-600">{{ $courier->tracking_number }}</p>
                                    <p class="text-sm text-gray-900 mt-1">{{ $courier->receiver_name }} - {{ $courier->receiver_phone }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ date('d/m/Y H:i', strtotime($courier->created_at)) }}</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    %if($courier->status === 'delivered')
                                    bg-green-100 text-green-800
                                    %elseif($courier->status === 'in_transit')
                                    bg-purple-100 text-purple-800
                                    %elseif($courier->status === 'received')
                                    bg-blue-100 text-blue-800
                                    %elseif($courier->status === 'pending')
                                    bg-yellow-100 text-yellow-800
                                    %else
                                    bg-red-100 text-red-800
                                    %endif
                                ">
                                    {{ $courier->getStatusLabel() }}
                                </span>
                            </div>
                        </a>
                        %endloop
                    %else
                        <div class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <p class="mt-2">Aucun colis enregistré</p>
                            <a href="{{ route('couriers.create') }}" class="mt-4 inline-flex items-center text-primary-600 hover:text-primary-800">
                                <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Créer votre premier colis
                            </a>
                        </div>
                    %endif
                </div>
            </div>
    </main>
</div>
%endblock

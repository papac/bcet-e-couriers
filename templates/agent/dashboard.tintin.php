%extends('layouts.app')

%block('title', 'Dashboard Agent - BCET e-Couriers')

%block('content')
<div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100">
    <!-- Mobile sidebar -->
    <div x-show="sidebarOpen" class="fixed inset-0 z-40 lg:hidden" x-cloak>
        <div x-show="sidebarOpen" class="fixed inset-0 bg-gray-600 bg-opacity-75" @click="sidebarOpen = false"></div>
        <div x-show="sidebarOpen" class="relative flex-1 flex flex-col max-w-xs w-full bg-primary-800">
            %include('partials.agent-sidebar')
        </div>
    </div>

    <!-- Desktop sidebar -->
    <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">
        <div class="flex-1 flex flex-col min-h-0 bg-primary-800">
            %include('partials.agent-sidebar')
        </div>
    </div>

    <!-- Main content -->
    <div class="lg:pl-64 flex flex-col flex-1">
        <!-- Top bar -->
        <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
            <button @click="sidebarOpen = true" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none lg:hidden">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>
            <div class="flex-1 px-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-900">Mon Dashboard</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                    <a href="/logout" class="text-sm text-red-600 hover:text-red-800">Déconnexion</a>
                </div>
            </div>
        </div>

        <main class="flex-1 p-6">
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
                <a href="/agent/couriers/create" class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
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
                        <a href="/agent/couriers" class="text-sm text-primary-600 hover:text-primary-800">Voir tout →</a>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    %if(count($recent_couriers) > 0)
                        %foreach($recent_couriers as $courier)
                        <a href="/agent/couriers/{{ $courier->id }}" class="block px-6 py-4 hover:bg-gray-50">
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
                        %endforeach
                    %else
                        <div class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <p class="mt-2">Aucun colis enregistré</p>
                            <a href="/agent/couriers/create" class="mt-4 inline-flex items-center text-primary-600 hover:text-primary-800">
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
</div>
%endblock

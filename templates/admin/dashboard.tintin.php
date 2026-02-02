%extends('layouts.app')

%block('title', 'Dashboard Admin - BCET e-Couriers')

%block('content')
<div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100">
    <!-- Mobile sidebar -->
    <div x-show="sidebarOpen" class="fixed inset-0 z-40 lg:hidden" x-cloak>
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-600 bg-opacity-75" @click="sidebarOpen = false"></div>
        
        <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative flex-1 flex flex-col max-w-xs w-full bg-primary-800">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            %include('partials.admin-sidebar')
        </div>
    </div>

    <!-- Desktop sidebar -->
    <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">
        <div class="flex-1 flex flex-col min-h-0 bg-primary-800">
            %include('partials.admin-sidebar')
        </div>
    </div>

    <!-- Main content -->
    <div class="lg:pl-64 flex flex-col flex-1">
        <!-- Top bar -->
        <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
            <button @click="sidebarOpen = true" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 lg:hidden">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>
            <div class="flex-1 px-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-900">Dashboard Administrateur</h1>
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
                            %foreach($recent_couriers as $courier)
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
                            %endforeach
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
                            %foreach($recent_agents as $agent)
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
                            %endforeach
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
</div>
%endblock

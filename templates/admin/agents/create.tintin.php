%extends('layouts.app')

%block('title', 'Nouvel agent - BCET e-Couriers')

%block('content')
<div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100">
    <!-- Mobile sidebar -->
    <div x-show="sidebarOpen" class="fixed inset-0 z-40 lg:hidden" x-cloak>
        <div x-show="sidebarOpen" class="fixed inset-0 bg-gray-600 bg-opacity-75" @click="sidebarOpen = false"></div>
        <div x-show="sidebarOpen" class="relative flex-1 flex flex-col max-w-xs w-full bg-primary-800">
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
            <button @click="sidebarOpen = true" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none lg:hidden">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>
            <div class="flex-1 px-4 flex justify-between items-center">
                <div class="flex items-center">
                    <a href="/admin/agents" class="text-gray-500 hover:text-gray-700 mr-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Nouvel agent</h1>
                </div>
                <a href="/logout" class="text-sm text-red-600 hover:text-red-800">Déconnexion</a>
            </div>
        </div>

        <main class="flex-1 p-6">
            %if(flash('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ flash('error') }}
            </div>
            %endif

            <div class="max-w-2xl">
                <div class="bg-white shadow rounded-xl">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Informations de l'agent</h3>
                        <p class="mt-1 text-sm text-gray-500">Créez un nouveau compte agent pour permettre l'accès au système.</p>
                    </div>
                    <form action="/admin/agents" method="POST" class="p-6 space-y-6">
                        {{ csrf_field() }}
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet *</label>
                            <input type="text" name="name" id="name" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="Jean Dupont">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email *</label>
                            <input type="email" name="email" id="email" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="agent@example.com">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                            <input type="tel" name="phone" id="phone" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="+225 XX XX XX XX XX">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe *</label>
                            <input type="password" name="password" id="password" required minlength="6"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="Minimum 6 caractères">
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                            <a href="/admin/agents" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Annuler
                            </a>
                            <button type="submit" class="px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Créer l'agent
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
%endblock

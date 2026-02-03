%extends('layouts.app')

%block('title', 'Modifier utilisateur - BCET/COURRIER')

%block('content')
<div x-data="{ mobileMenuOpen: false }" class="min-h-screen bg-gray-100">
    %include('partials.admin-navbar')

    <!-- Main content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        %if(flash('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
            {{ flash('error') }}
        </div>
        %endif

        %if(flash('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ flash('success') }}
        </div>
        %endif

        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center">
                <a href="{{ route('users.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Modifier l'utilisateur</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ $user->name }} - {{ $user->email }}</p>
                </div>
            </div>
        </div>

        <div class="max-w-2xl">
            <form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST" class="space-y-6">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                
                <!-- User Information -->
                <div class="bg-white shadow rounded-xl">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Informations de l'utilisateur</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet *</label>
                            <input type="text" name="name" id="name" required value="{{ $user->name }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email *</label>
                            <input type="email" name="email" id="email" required value="{{ $user->email }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                            <input type="tel" name="phone" id="phone" required value="{{ $user->phone }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                            <input type="password" name="password" id="password" minlength="6"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="Laisser vide pour conserver l'actuel">
                            <p class="mt-1 text-xs text-gray-500">Laissez vide si vous ne souhaitez pas modifier le mot de passe</p>
                        </div>

                        <div>
                            <label for="service_id" class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                            <select name="service_id" id="service_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="">-- Sélectionner un service --</option>
                                %loop($services as $service)
                                <option value="{{ $service->id }}" {{ $user->service_id == $service->id ? 'selected' : '' }}>{{ $service->name }} ({{ $service->city }})</option>
                                %endloop
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}
                                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">Compte actif</label>
                        </div>
                    </div>
                </div>

                <!-- Access Permissions -->
                <div class="bg-white shadow rounded-xl">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Permissions d'accès</h3>
                        <p class="mt-1 text-sm text-gray-500">Gérez les applications auxquelles l'utilisateur peut accéder</p>
                    </div>
                    <div class="p-6 space-y-4">
                        %loop($availableApps as $appKey => $appLabel)
                        <div class="flex items-start {{ !$loop->first ? 'border-t border-gray-200 pt-4' : '' }}">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="app_access[]" id="app_{{ $appKey }}" value="{{ $appKey }}" {{ in_array($appKey, $user->getAppAccessList()) ? 'checked' : '' }}
                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3">
                                <label for="app_{{ $appKey }}" class="text-sm font-medium text-gray-900">Accès {{ $appLabel }}</label>
                                <p class="text-sm text-gray-500">Permet à l'utilisateur d'accéder à l'application {{ $appLabel }}</p>
                            </div>
                            <div class="ml-auto">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $appKey === 'courrier' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    %if($appKey === 'courrier')
                                    <svg class="mr-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    %else
                                    <svg class="mr-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
                                    </svg>
                                    %endif
                                    {{ $appLabel }}
                                </span>
                            </div>
                        </div>
                        %endloop
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('users.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" class="px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
%endblock

%extends('layouts.app')

%block('title', 'Détails colis - BCET/COURRIER')

%block('content')
<div x-data="{ sidebarOpen: false, showStatusModal: false }" class="min-h-screen bg-gray-100">
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
                    <a href="/admin/couriers" class="text-gray-500 hover:text-gray-700 mr-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Détails du colis</h1>
                </div>
                <a href="/logout" class="text-sm text-red-600 hover:text-red-800">Déconnexion</a>
            </div>
        </div>

        <main class="flex-1 p-6">
            %if(flash('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ flash('success') }}
            </div>
            %endif

            <!-- Tracking Number Header -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 font-mono">{{ $courier->tracking_number }}</h2>
                    <span class="inline-flex items-center mt-2 px-3 py-1 rounded-full text-sm font-medium
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
                <button @click="showStatusModal = true" class="mt-4 sm:mt-0 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Changer le statut
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Sender Info -->
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Expéditeur
                    </h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Nom</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $courier->sender_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Téléphone</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $courier->sender_phone }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Adresse</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $courier->sender_address }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Receiver Info -->
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Destinataire
                    </h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Nom</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $courier->receiver_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Téléphone</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $courier->receiver_phone }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Adresse</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $courier->receiver_address }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Package Details -->
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Détails du colis
                    </h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Description</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $courier->description ?? '-' }}</dd>
                        </div>
                        <div class="flex space-x-8">
                            <div>
                                <dt class="text-sm text-gray-500">Poids</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $courier->weight ? $courier->weight . ' kg' : '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-500">Prix</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $courier->price ? number_format($courier->price, 0, ',', ' ') . ' FCFA' : '-' }}</dd>
                            </div>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Notes</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $courier->notes ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Agent Info -->
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Agent
                    </h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Nom</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $courier->agent()->first()->name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Email</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $courier->agent()->first()->email ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Date de création</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ date('d/m/Y à H:i', strtotime($courier->created_at)) }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Status History -->
                <div class="bg-white shadow rounded-xl p-6 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Historique des statuts
                    </h3>
                    <div class="flow-root">
                        <ul class="-mb-8">
                            %if(count($history) > 0)
                                %loop($history as $index => $item)
                                <li>
                                    <div class="relative pb-8">
                                        %if($index < count($history) - 1)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        %endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="h-4 w-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5">
                                                <p class="text-sm text-gray-900">
                                                    Statut changé vers <span class="font-medium">{{ \App\Models\Courier::getStatusOptions()[$item->new_status] ?? $item->new_status }}</span>
                                                </p>
                                                %if($item->comment)
                                                <p class="mt-1 text-sm text-gray-500">{{ $item->comment }}</p>
                                                %endif
                                                <p class="mt-1 text-xs text-gray-400">{{ date('d/m/Y H:i', strtotime($item->created_at)) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                %endloop
                            %else
                                <li class="text-sm text-gray-500">Aucun historique disponible</li>
                            %endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Attached Files Section -->
            <div class="mt-6 bg-white shadow rounded-xl">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        Pièces jointes
                        <span class="ml-2 text-sm text-gray-500 font-normal">({{ count($files) }} fichier(s))</span>
                    </h3>
                </div>
                
                <div class="p-6">
                    %if(count($files) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        %loop($files as $file)
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    %if($file->isImage())
                                    <a href="{{ $file->getUrl() }}" target="_blank">
                                        <img src="{{ $file->getUrl() }}" alt="{{ $file->original_name }}" class="h-16 w-16 object-cover rounded-lg">
                                    </a>
                                    %elseif($file->isPdf())
                                    <div class="h-16 w-16 bg-red-100 rounded-lg flex items-center justify-center">
                                        <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    %else
                                    <div class="h-16 w-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    %endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate" title="{{ $file->original_name }}">{{ $file->original_name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $file->getFormattedSize() }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ date('d/m/Y H:i', strtotime($file->created_at)) }}</p>
                                    <div class="mt-2 flex space-x-2">
                                        <a href="{{ $file->getUrl() }}" target="_blank" class="text-xs text-primary-600 hover:text-primary-700">Voir</a>
                                        <a href="{{ $file->getUrl() }}" download="{{ $file->original_name }}" class="text-xs text-gray-600 hover:text-gray-700">Télécharger</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        %endloop
                    </div>
                    %else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <p class="mt-2 text-sm">Aucun fichier attaché</p>
                    </div>
                    %endif
                </div>
            </div>
        </main>
    </div>

    <!-- Status Modal -->
    <div x-show="showStatusModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showStatusModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showStatusModal = false"></div>
            <div x-show="showStatusModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="/admin/couriers/{{ $courier->id }}/status" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="bg-white px-6 pt-6 pb-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Changer le statut</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau statut</label>
                                <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    <option value="pending" {{ $courier->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="received" {{ $courier->status === 'received' ? 'selected' : '' }}>Reçu</option>
                                    <option value="in_transit" {{ $courier->status === 'in_transit' ? 'selected' : '' }}>En transit</option>
                                    <option value="delivered" {{ $courier->status === 'delivered' ? 'selected' : '' }}>Livré</option>
                                    <option value="returned" {{ $courier->status === 'returned' ? 'selected' : '' }}>Retourné</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Commentaire (optionnel)</label>
                                <textarea name="comment" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="Ajouter un commentaire..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                        <button type="button" @click="showStatusModal = false" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
%endblock

%extends('layouts.app')

%block('title', 'Suivi colis ' . $courier->tracking_number . ' - BCET/COURRIER')

%block('content')
<div class="min-h-screen bg-gradient-to-br from-primary-600 to-primary-900">
    <!-- Navigation -->
    <nav class="px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="/" class="flex items-center space-x-3">
                <div class="h-10 w-10 bg-white rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-white">BCET/COURRIER</span>
            </a>
            <a href="/login" class="px-6 py-2.5 bg-white text-primary-600 rounded-lg font-medium hover:bg-gray-100 transition">
                Se connecter
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-6 py-12">
        <!-- Back Button -->
        <a href="/" class="inline-flex items-center text-white/80 hover:text-white mb-8 transition">
            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à l'accueil
        </a>

        <!-- Tracking Result Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-100 text-sm mb-1">Numéro de suivi</p>
                        <p class="text-white text-2xl font-bold font-mono">{{ $courier->tracking_number }}</p>
                    </div>
                    <div class="text-right">
                        %if($courier->status === 'delivered')
                        <span class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-full text-sm font-semibold">
                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Livré
                        </span>
                        %elseif($courier->status === 'in_transit')
                        <span class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-full text-sm font-semibold">
                            <svg class="h-4 w-4 mr-1.5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            En transit
                        </span>
                        %elseif($courier->status === 'received')
                        <span class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-full text-sm font-semibold">
                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Reçu
                        </span>
                        %elseif($courier->status === 'returned')
                        <span class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-full text-sm font-semibold">
                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                            </svg>
                            Retourné
                        </span>
                        %else
                        <span class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-full text-sm font-semibold">
                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            En attente
                        </span>
                        %endif
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Sender -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="h-5 w-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Expéditeur</h3>
                        </div>
                        <div class="ml-13 space-y-2">
                            <p class="text-gray-900 font-medium">{{ $courier->sender_name }}</p>
                            <p class="text-gray-500 text-sm">{{ $courier->sender_phone }}</p>
                            <p class="text-gray-500 text-sm">{{ $courier->sender_address }}</p>
                        </div>
                    </div>

                    <!-- Receiver -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Destinataire</h3>
                        </div>
                        <div class="ml-13 space-y-2">
                            <p class="text-gray-900 font-medium">{{ $courier->receiver_name }}</p>
                            <p class="text-gray-500 text-sm">{{ $courier->receiver_phone }}</p>
                            <p class="text-gray-500 text-sm">{{ $courier->receiver_address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Package Info -->
                %if($courier->description || $courier->weight)
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="h-10 w-10 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Détails du colis</h3>
                    </div>
                    <div class="ml-13 grid grid-cols-2 md:grid-cols-3 gap-4">
                        %if($courier->description)
                        <div>
                            <p class="text-gray-500 text-sm">Description</p>
                            <p class="text-gray-900 font-medium">{{ $courier->description }}</p>
                        </div>
                        %endif
                        %if($courier->weight)
                        <div>
                            <p class="text-gray-500 text-sm">Poids</p>
                            <p class="text-gray-900 font-medium">{{ $courier->weight }} kg</p>
                        </div>
                        %endif
                        <div>
                            <p class="text-gray-500 text-sm">Date d'enregistrement</p>
                            <p class="text-gray-900 font-medium">{{ date('d/m/Y H:i', strtotime($courier->created_at)) }}</p>
                        </div>
                    </div>
                </div>
                %endif

                <!-- Service Info for service-to-service -->
                %if($courier->type === 'service' && ($courier->originService || $courier->destinationService))
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Transfert inter-services</h3>
                    </div>
                    <div class="ml-13 flex items-center space-x-4">
                        %if($courier->originService)
                        <div class="flex-1 bg-orange-50 rounded-lg p-4">
                            <p class="text-orange-600 text-xs font-medium uppercase mb-1">Origine</p>
                            <p class="text-gray-900 font-semibold">{{ $courier->originService->name }}</p>
                            <p class="text-gray-500 text-sm">{{ $courier->originService->city }}</p>
                        </div>
                        %endif
                        <svg class="h-6 w-6 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                        %if($courier->destinationService)
                        <div class="flex-1 bg-green-50 rounded-lg p-4">
                            <p class="text-green-600 text-xs font-medium uppercase mb-1">Destination</p>
                            <p class="text-gray-900 font-semibold">{{ $courier->destinationService->name }}</p>
                            <p class="text-gray-500 text-sm">{{ $courier->destinationService->city }}</p>
                        </div>
                        %endif
                    </div>
                </div>
                %endif
            </div>

            <!-- Track Another -->
            <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
                <form action="/track" method="GET" class="flex items-center space-x-4">
                    <input type="text" name="tracking_number" 
                        class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        placeholder="Rechercher un autre colis...">
                    <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white rounded-lg font-medium hover:bg-primary-700 transition">
                        Rechercher
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="border-t border-white/10 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-6 text-center text-primary-200">
            <p>© {{ date('Y') }} BCET/COURRIER. Tous droits réservés.</p>
        </div>
    </div>
</div>
%endblock

%extends('layouts.app')

%block('title', 'BCET e-Couriers - Gestion des colis')

%block('content')
<div class="min-h-screen bg-gradient-to-br from-primary-600 to-primary-900">
    <!-- Navigation -->
    <nav class="px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="h-10 w-10 bg-white rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-white">BCET e-Couriers</span>
            </div>
            <a href="/login" class="px-6 py-2.5 bg-white text-primary-600 rounded-lg font-medium hover:bg-gray-100 transition">
                Se connecter
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                Gestion simplifiée<br>de vos colis
            </h1>
            <p class="text-xl text-primary-100 mb-10 max-w-2xl mx-auto">
                Plateforme professionnelle de gestion des colis et livraisons. 
                Suivez vos envois en temps réel et optimisez votre logistique.
            </p>
            <a href="/login" class="inline-flex items-center px-8 py-4 bg-white text-primary-600 rounded-xl font-semibold text-lg hover:bg-gray-100 transition shadow-lg">
                Commencer maintenant
                <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Features -->
    <div class="max-w-7xl mx-auto px-6 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 text-white">
                <div class="h-12 w-12 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Suivi en temps réel</h3>
                <p class="text-primary-100">
                    Suivez l'état de vos colis à chaque étape avec des numéros de suivi uniques.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 text-white">
                <div class="h-12 w-12 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Gestion des agents</h3>
                <p class="text-primary-100">
                    Gérez facilement vos agents et attribuez-leur des droits d'accès personnalisés.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 text-white">
                <div class="h-12 w-12 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Tableau de bord</h3>
                <p class="text-primary-100">
                    Visualisez vos statistiques et performances en un coup d'œil.
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="border-t border-white/10 py-8">
        <div class="max-w-7xl mx-auto px-6 text-center text-primary-200">
            <p>© {{ date('Y') }} BCET e-Couriers. Tous droits réservés.</p>
        </div>
    </div>
</div>
%endblock

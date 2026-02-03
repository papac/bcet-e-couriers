%extends('layouts.app')

%block('title', 'Connexion - BCET/COURRIER')

%block('content')
<div class="min-h-screen flex bg-gradient-to-br from-primary-600 to-primary-900">
    <!-- Left Side - Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12">
        <div class="w-full max-w-md">
            <!-- Mobile Logo (visible on small screens) -->
            <div class="lg:hidden text-center mb-8">
                <div class="mx-auto h-16 w-16 bg-white rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="h-10 w-10 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h1 class="mt-4 text-2xl font-bold text-white">BCET/COURRIER</h1>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Connexion</h2>
                <p class="text-gray-500 mb-6">Accédez à votre espace de gestion du courrier</p>
                
                %if(flash('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                        {{ flash('error') }}
                    </div>
                %endif

                %if(flash('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                    {{ flash('success') }}
                </div>
                %endif

                <form method="POST" action="{{ route('auth.login') }}" class="space-y-5">
                    {{{ csrf_field() }}}
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Adresse email
                        </label>
                        <input id="email" name="email" type="email" required autofocus
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                            placeholder="votre@email.com">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Mot de passe
                        </label>
                        <input id="password" name="password" type="password" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                            placeholder="••••••••">
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition">
                            Se connecter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-primary-200 text-sm">
                    © {{ date('Y') }} BCET/COURRIER — Usage interne
                </p>
            </div>
        </div>
    </div>

    <!-- Right Side - Description -->
    <div class="hidden lg:flex lg:w-1/2 bg-primary-800/30 backdrop-blur-sm items-center justify-center p-12">
        <div class="max-w-lg text-center">
            <!-- Logo -->
            <div class="mx-auto h-24 w-24 bg-white/10 backdrop-blur rounded-3xl flex items-center justify-center mb-8">
                <svg class="h-14 w-14 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>

            <h1 class="text-4xl font-bold text-white mb-4">BCET/COURRIER</h1>
            <p class="text-xl text-primary-100 mb-8">
                Gestion du courrier reçu
            </p>

            <div class="text-left space-y-6">
                <!-- Feature 1 -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 h-12 w-12 bg-white/10 rounded-xl flex items-center justify-center">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Recherche rapide</h3>
                        <p class="text-primary-200 text-sm">Retrouvez instantanément n'importe quel courrier grâce au numéro de référence unique.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 h-12 w-12 bg-white/10 rounded-xl flex items-center justify-center">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Multi-services</h3>
                        <p class="text-primary-200 text-sm">Gérez les courriers de plusieurs services et transférez facilement entre agences.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 h-12 w-12 bg-white/10 rounded-xl flex items-center justify-center">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Historique complet</h3>
                        <p class="text-primary-200 text-sm">Conservez l'historique de tous les courriers reçus avec leurs pièces jointes.</p>
                    </div>
                </div>
            </div>

            <!-- Badge -->
            <div class="mt-10">
                <span class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur rounded-full text-white text-sm">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Application sécurisée à usage interne
                </span>
            </div>
        </div>
    </div>
</div>
%endblock

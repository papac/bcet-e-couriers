%extends('layouts.app')

%block('title', $direction->value === 'incoming' ? 'Réception de courrier' : 'Départ de courrier' . ' - BCET/COURIERS')

%block('content')
<div x-data="{ mobileMenuOpen: false }" class="min-h-screen bg-gray-100">
    %include('partials.admin-navbar')

    <!-- Main content -->
    <main class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center space-x-3">
                <a href="{{ route('couriers.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        %if($direction->value === 'incoming')
                        <span class="inline-flex items-center">
                            <svg class="h-6 w-6 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                            Réception de courrier
                        </span>
                        %else
                        <span class="inline-flex items-center">
                            <svg class="h-6 w-6 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            Départ de courrier
                        </span>
                        %endif
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        %if($direction->value === 'incoming')
                            Enregistrer un courrier entrant (réception)
                        %else
                            Enregistrer un courrier sortant (expédition)
                        %endif
                    </p>
                </div>
            </div>
        </div>

        %if(flash('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
            {{ flash('error') }}
        </div>
        %endif

        <form action="{{ route('couriers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            {{{ csrf_field() }}}
            <input type="hidden" name="direction" value="{{ $direction->value }}">

            <!-- Sender Information -->
            <div class="bg-white shadow rounded-xl">
                <div class="px-6 py-4 border-b border-gray-200 {{ $direction->value === 'incoming' ? 'bg-green-50' : 'bg-blue-50' }}">
                    <h3 class="text-lg font-semibold {{ $direction->value === 'incoming' ? 'text-green-800' : 'text-blue-800' }}">
                        %if($direction->value === 'incoming')
                        Expéditeur (Origine)
                        %else
                        Expéditeur (Interne)
                        %endif
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sender_name" class="block text-sm font-medium text-gray-700 mb-1">Nom de l'expéditeur *</label>
                        <input type="text" name="sender_name" id="sender_name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Nom complet">
                    </div>
                    <div>
                        <label for="sender_phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                        <input type="tel" name="sender_phone" id="sender_phone" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="+225 XX XX XX XX XX">
                    </div>
                    <div class="md:col-span-2">
                        <label for="sender_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                        <textarea name="sender_address" id="sender_address" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Adresse complète"></textarea>
                    </div>
                </div>
            </div>

            <!-- Receiver Information -->
            <div class="bg-white shadow rounded-xl">
                <div class="px-6 py-4 border-b border-gray-200 {{ $direction->value === 'incoming' ? 'bg-blue-50' : 'bg-green-50' }}">
                    <h3 class="text-lg font-semibold {{ $direction->value === 'incoming' ? 'text-blue-800' : 'text-green-800' }}">
                        %if($direction->value === 'incoming')
                            Destinataire (Interne)
                        %else
                            Destinataire (Externe)
                        %endif
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="receiver_name" class="block text-sm font-medium text-gray-700 mb-1">Nom du destinataire *</label>
                        <input type="text" name="receiver_name" id="receiver_name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Nom complet">
                    </div>
                    <div>
                        <label for="receiver_phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                        <input type="tel" name="receiver_phone" id="receiver_phone" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="+225 XX XX XX XX XX">
                    </div>
                    <div class="md:col-span-2">
                        <label for="receiver_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                        <textarea name="receiver_address" id="receiver_address" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Adresse complète"></textarea>
                    </div>
                </div>
            </div>

            <!-- Service Information (Optional) -->
            <div class="bg-white shadow rounded-xl">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Services (optionnel)</h3>
                    <p class="text-sm text-gray-500">Pour le suivi inter-services</p>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="origin_service_id" class="block text-sm font-medium text-gray-700 mb-1">Service d'origine</label>
                        <select name="origin_service_id" id="origin_service_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">-- Sélectionner --</option>
                            %loop($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            %endloop
                        </select>
                    </div>
                    <div>
                        <label for="destination_service_id" class="block text-sm font-medium text-gray-700 mb-1">Service de destination</label>
                        <select name="destination_service_id" id="destination_service_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">-- Sélectionner --</option>
                            %loop($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            %endloop
                        </select>
                    </div>
                </div>
            </div>

            <!-- Courier Details -->
            <div class="bg-white shadow rounded-xl">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Détails du courrier</h3>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description / Objet</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Description du contenu du courrier"></textarea>
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes internes</label>
                        <textarea name="notes" id="notes" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Notes internes (non visibles au public)"></textarea>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="bg-white shadow rounded-xl" x-data="{ files: [] }">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Documents joints</h3>
                    <p class="text-sm text-gray-500">Ajoutez des documents liés à ce courrier (PDF, images, Word, Excel)</p>
                </div>
                <div class="p-6">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors">
                        <input type="file" name="documents[]" id="documents" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx"
                            class="hidden"
                            @change="files = Array.from($event.target.files)">
                        <label for="documents" class="cursor-pointer">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">
                                <span class="font-medium text-primary-600 hover:text-primary-500">Cliquez pour sélectionner</span>
                                ou glissez-déposez des fichiers
                            </p>
                            <p class="mt-1 text-xs text-gray-500">PDF, JPG, PNG, DOC, DOCX, XLS, XLSX jusqu'à 10MB</p>
                        </label>
                    </div>

                    <!-- Preview selected files -->
                    <div x-show="files.length > 0" class="mt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Fichiers sélectionnés:</h4>
                        <ul class="space-y-2">
                            <template x-for="(file, index) in files" :key="index">
                                <li class="flex items-center justify-between bg-gray-50 px-3 py-2 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="text-sm text-gray-700" x-text="file.name"></span>
                                        <span class="text-xs text-gray-500" x-text="(file.size / 1024 / 1024).toFixed(2) + ' MB'"></span>
                                    </div>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('couriers.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white {{ $direction->value === 'incoming' ? 'bg-green-600 hover:bg-green-700 focus:ring-green-500' : 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500' }} focus:outline-none focus:ring-2 focus:ring-offset-2">
                    %if($direction->value === 'incoming')
                        <svg class="inline-block h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        Enregistrer la réception
                    %else
                        <svg class="inline-block h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        Enregistrer le départ
                    %endif
                </button>
            </div>
        </form>
    </main>
</div>
%endblock

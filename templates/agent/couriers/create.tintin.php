%extends('layouts.app')

%block('title', 'Nouveau colis - BCET e-Couriers')

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
                <div class="flex items-center">
                    <a href="/agent/couriers" class="text-gray-500 hover:text-gray-700 mr-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Nouveau colis</h1>
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

            <form action="/agent/couriers" method="POST" enctype="multipart/form-data" class="space-y-6">
                {{ csrf_field() }}
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Sender Information -->
                    <div class="bg-white shadow rounded-xl">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Informations de l'expéditeur
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label for="sender_name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet *</label>
                                <input type="text" name="sender_name" id="sender_name" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="Nom de l'expéditeur">
                            </div>
                            <div>
                                <label for="sender_phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                                <input type="tel" name="sender_phone" id="sender_phone" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="+225 XX XX XX XX XX">
                            </div>
                            <div>
                                <label for="sender_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse *</label>
                                <textarea name="sender_address" id="sender_address" rows="3" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="Adresse complète de l'expéditeur"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Receiver Information -->
                    <div class="bg-white shadow rounded-xl">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Informations du destinataire
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label for="receiver_name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet *</label>
                                <input type="text" name="receiver_name" id="receiver_name" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="Nom du destinataire">
                            </div>
                            <div>
                                <label for="receiver_phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                                <input type="tel" name="receiver_phone" id="receiver_phone" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="+225 XX XX XX XX XX">
                            </div>
                            <div>
                                <label for="receiver_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse *</label>
                                <textarea name="receiver_address" id="receiver_address" rows="3" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="Adresse complète du destinataire"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Package Details -->
                <div class="bg-white shadow rounded-xl">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Détails du colis
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <input type="text" name="description" id="description"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="Ex: Documents, Vêtements...">
                            </div>
                            <div>
                                <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Poids (kg)</label>
                                <input type="number" name="weight" id="weight" step="0.1" min="0"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="0.0">
                            </div>
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Prix (FCFA)</label>
                                <input type="number" name="price" id="price" step="100" min="0"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="0">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea name="notes" id="notes" rows="2"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="Notes additionnelles sur le colis..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- File Attachments -->
                <div class="bg-white shadow rounded-xl" x-data="fileUpload()">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            Pièces jointes
                            <span class="ml-2 text-sm text-gray-500 font-normal">(max 10 fichiers, 5MB par fichier)</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors"
                            @dragover.prevent="dragover = true"
                            @dragleave.prevent="dragover = false"
                            @drop.prevent="handleDrop($event)"
                            :class="{ 'border-primary-500 bg-primary-50': dragover }">
                            <input type="file" name="files[]" id="files" multiple 
                                accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx"
                                class="hidden" @change="handleFiles($event)">
                            <label for="files" class="cursor-pointer">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">
                                    <span class="font-semibold text-primary-600 hover:text-primary-500">Cliquez pour sélectionner</span>
                                    ou glissez-déposez vos fichiers
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    Images (JPG, PNG, GIF), PDF, Documents Word, Excel
                                </p>
                            </label>
                        </div>

                        <!-- File Preview List -->
                        <div x-show="files.length > 0" class="mt-4 space-y-2">
                            <template x-for="(file, index) in files" :key="index">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <template x-if="isImage(file)">
                                                <img :src="getPreview(file)" class="h-10 w-10 object-cover rounded">
                                            </template>
                                            <template x-if="!isImage(file)">
                                                <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900 truncate" x-text="file.name"></p>
                                            <p class="text-xs text-gray-500" x-text="formatSize(file.size)"></p>
                                        </div>
                                    </div>
                                    <button type="button" @click="removeFile(index)" class="text-red-500 hover:text-red-700">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="/agent/couriers" class="px-6 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" class="px-8 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Enregistrer le colis
                    </button>
                </div>
            </form>
        </main>
    </div>
</div>

<script>
function fileUpload() {
    return {
        files: [],
        dragover: false,
        maxFiles: 10,
        maxSize: 5 * 1024 * 1024,
        allowedTypes: ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
        
        handleFiles(event) {
            this.addFiles(event.target.files);
        },
        
        handleDrop(event) {
            this.dragover = false;
            this.addFiles(event.dataTransfer.files);
        },
        
        addFiles(fileList) {
            for (let file of fileList) {
                if (this.files.length >= this.maxFiles) {
                    alert('Maximum ' + this.maxFiles + ' fichiers autorisés');
                    break;
                }
                
                if (file.size > this.maxSize) {
                    alert('Le fichier ' + file.name + ' est trop volumineux (max 5MB)');
                    continue;
                }
                
                if (!this.allowedTypes.includes(file.type)) {
                    alert('Type de fichier non autorisé: ' + file.name);
                    continue;
                }
                
                this.files.push(file);
            }
            this.updateFileInput();
        },
        
        removeFile(index) {
            this.files.splice(index, 1);
            this.updateFileInput();
        },
        
        updateFileInput() {
            const dataTransfer = new DataTransfer();
            this.files.forEach(file => dataTransfer.items.add(file));
            document.getElementById('files').files = dataTransfer.files;
        },
        
        isImage(file) {
            return file.type.startsWith('image/');
        },
        
        getPreview(file) {
            return URL.createObjectURL(file);
        },
        
        formatSize(bytes) {
            if (bytes >= 1048576) return (bytes / 1048576).toFixed(2) + ' MB';
            if (bytes >= 1024) return (bytes / 1024).toFixed(2) + ' KB';
            return bytes + ' bytes';
        }
    }
}
</script>
%endblock

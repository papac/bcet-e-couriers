%extends('layouts.app')

%block('title', 'Détails colis - BCET/COURRIER')

%block('content')
<div x-data="{ sidebarOpen: false, showStatusModal: false }" class="min-h-screen bg-gray-100">
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
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <a href="/agent/couriers/{{ $courier->id }}/edit" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Modifier
                    </a>
                    <button @click="showStatusModal = true" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                        Changer le statut
                    </button>
                </div>
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
                        <div>
                            <dt class="text-sm text-gray-500">Date de création</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ date('d/m/Y à H:i', strtotime($courier->created_at)) }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Status History -->
                <div class="bg-white shadow rounded-xl p-6">
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
            <div class="mt-6 bg-white shadow rounded-xl" x-data="fileUpload()">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        Pièces jointes
                        <span class="ml-2 text-sm text-gray-500 font-normal">({{ count($files) }} fichier(s))</span>
                    </h3>
                    <button type="button" @click="showUploadForm = !showUploadForm" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        + Ajouter des fichiers
                    </button>
                </div>
                
                <!-- Upload Form -->
                <div x-show="showUploadForm" x-collapse class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <form action="/agent/couriers/{{ $courier->id }}/files" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary-400 transition-colors"
                            @dragover.prevent="dragover = true"
                            @dragleave.prevent="dragover = false"
                            @drop.prevent="handleDrop($event)"
                            :class="{ 'border-primary-500 bg-primary-50': dragover }">
                            <input type="file" name="files[]" id="new_files" multiple 
                                accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx"
                                class="hidden" @change="handleFiles($event)">
                            <label for="new_files" class="cursor-pointer">
                                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mt-1 text-sm text-gray-600">
                                    <span class="font-semibold text-primary-600">Cliquez</span> ou glissez-déposez
                                </p>
                            </label>
                        </div>
                        
                        <!-- File Preview List -->
                        <div x-show="files.length > 0" class="mt-3 space-y-2">
                            <template x-for="(file, index) in files" :key="index">
                                <div class="flex items-center justify-between p-2 bg-white rounded border">
                                    <span class="text-sm text-gray-700 truncate" x-text="file.name"></span>
                                    <button type="button" @click="removeFile(index)" class="text-red-500 hover:text-red-700">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                        
                        <div x-show="files.length > 0" class="mt-3 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700">
                                Télécharger
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Files List -->
                <div class="p-6">
                    %if(count($files) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
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
                                        <form action="/agent/couriers/{{ $courier->id }}/files/{{ $file->id }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce fichier ?')">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="text-xs text-red-600 hover:text-red-700">Supprimer</button>
                                        </form>
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
            <div x-show="showStatusModal" class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showStatusModal = false"></div>
            <div x-show="showStatusModal" class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="/agent/couriers/{{ $courier->id }}/status" method="POST">
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

<script>
function fileUpload() {
    return {
        files: [],
        dragover: false,
        showUploadForm: false,
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
            this.files.loop(file => dataTransfer.items.add(file));
            document.getElementById('new_files').files = dataTransfer.files;
        }
    }
}
</script>
%endblock

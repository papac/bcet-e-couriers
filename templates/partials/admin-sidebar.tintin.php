<div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto">
    <div class="flex items-center flex-shrink-0 px-4">
        <div class="h-10 w-10 bg-white rounded-lg flex items-center justify-center">
            <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
        </div>
        <span class="ml-3 text-xl font-bold text-white">BCET e-Couriers</span>
    </div>
    <nav class="mt-8 flex-1 px-2 space-y-1">
        <a href="/admin" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->url() === '/admin' ? 'bg-primary-900 text-white' : 'text-primary-100 hover:bg-primary-700' }}">
            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>
        <a href="/admin/agents" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ str_contains(request()->url(), '/admin/agents') ? 'bg-primary-900 text-white' : 'text-primary-100 hover:bg-primary-700' }}">
            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Gestion des agents
        </a>
        <a href="/admin/couriers" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ str_contains(request()->url(), '/admin/couriers') ? 'bg-primary-900 text-white' : 'text-primary-100 hover:bg-primary-700' }}">
            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Tous les colis
        </a>
    </nav>
    <div class="px-4 py-4 border-t border-primary-700">
        <div class="flex items-center">
            <div class="h-9 w-9 rounded-full bg-primary-600 flex items-center justify-center">
                <span class="text-sm font-medium text-white">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                <p class="text-xs text-primary-300">Administrateur</p>
            </div>
        </div>
    </div>
</div>

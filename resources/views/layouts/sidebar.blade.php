<aside 
    class="bg-primary text-white w-64 flex-shrink-0 hidden md:flex flex-col min-h-screen transition-all duration-300"
    :class="{'w-20': !sidebarOpen, 'w-64': sidebarOpen}"
    x-data="{ sidebarOpen: true }"
>
    <!-- Logo -->
    <div class="h-16 flex items-center justify-center border-b border-white/10 px-4 gap-3">
        <img src="{{ asset('images/logo/logo.png') }}" alt="Logo" class="h-8 w-auto">
        <span class="font-bold text-lg whitespace-nowrap overflow-hidden transition-all duration-300" x-show="sidebarOpen">
            REHAB Mon
        </span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 py-4 flex flex-col gap-1 px-3">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-white/10 transition-colors {{ request()->routeIs('dashboard') ? 'bg-white/20' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard</span>
        </a>

        <a href="{{ route('batch.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-white/10 transition-colors {{ request()->routeIs('batch.*') ? 'bg-white/20' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-spreadsheet"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M8 13h2"/><path d="M14 13h2"/><path d="M8 17h2"/><path d="M14 17h2"/></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Batch & Import</span>
        </a>

        <a href="{{ route('peserta.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-white/10 transition-colors {{ request()->routeIs('peserta.*') ? 'bg-white/20' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Data Peserta</span>
        </a>

        <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-white/10 transition-colors {{ request()->routeIs('laporan.*') ? 'bg-white/20' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bar-chart-3"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Laporan & Export</span>
        </a>

        <div class="pt-4 mt-2 border-t border-white/10 mb-2 px-3 text-xs font-semibold text-white/50 uppercase tracking-wider" x-show="sidebarOpen">
            Pengaturan
        </div>

        <a href="{{ route('template-pesan.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-white/10 transition-colors {{ request()->routeIs('template-pesan.*') ? 'bg-white/20' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-dashed"><path d="M10 17H7l-4 4v-7"/><path d="M14 17h1"/><path d="M14 3h1"/><path d="M19 3a2 2 0 0 1 2 2"/><path d="M21 14v1a2 2 0 0 1-2 2"/><path d="M21 9v1"/><path d="M3 9v1"/><path d="M4 3h4"/><path d="M4 3a2 2 0 0 0-2 2"/></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Template Pesan</span>
        </a>
    </nav>

    <!-- Bottom Actions -->
    <div class="p-4 border-t border-white/10">
        <button @click="sidebarOpen = !sidebarOpen" class="flex items-center justify-center w-full p-2 rounded hover:bg-white/10 text-white/70 hover:text-white transition-colors">
            <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-panel-left-close"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="M9 3v18"/><path d="m16 15-3-3 3-3"/></svg>
            <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-panel-left-open"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="M9 3v18"/><path d="m14 9 3 3-3 3"/></svg>
        </button>
    </div>
</aside>

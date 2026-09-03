<header class="h-16 bg-surface border-b border-bordercolor flex items-center justify-between px-6 shrink-0 shadow-sm">
    <div class="flex items-center gap-4">
        <!-- Mobile menu button -->
        <button class="md:hidden text-textsecondary hover:text-textprimary" @click="sidebarOpen = !sidebarOpen">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
        </button>

        @isset($header)
            <h1 class="text-lg font-semibold text-textprimary">
                {{ $header }}
            </h1>
        @endisset
    </div>

    <div class="flex items-center gap-4">
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-textsecondary hover:text-textprimary transition-colors focus:outline-none">
                <span>{{ Auth::user()->name }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg>
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 border border-bordercolor z-50">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-textprimary hover:bg-appbg">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-textprimary hover:bg-appbg">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

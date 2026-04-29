<!DOCTYPE html>
<html lang="en" class="antialiased">

<head class="fn-head">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title class="fn-title">SahorOne | Control Panel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}" class="fn-link-favicon">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="stylesheet" href="{{ asset('assets/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: { primary: 'var(--brand-primary)', hover: 'var(--brand-primary-hover)', active: 'var(--brand-primary-active)', secondary: 'var(--brand-secondary)', accent: 'var(--brand-accent)' },
                        bg: { primary: 'var(--bg-primary)', secondary: 'var(--bg-secondary)', tertiary: 'var(--bg-tertiary)', muted: 'var(--bg-muted)' },
                        border: { default: 'var(--border-default)', strong: 'var(--border-strong)' },
                        text: { primary: 'var(--text-primary)', secondary: 'var(--text-secondary)', tertiary: 'var(--text-tertiary)', disabled: 'var(--text-disabled)' },
                        semantic: { success: 'var(--color-success)', warning: 'var(--color-warning)', error: 'var(--color-error)', info: 'var(--color-info)' }
                    },
                    fontFamily: { sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'], mono: ['JetBrains Mono', 'monospace'] },
                    transitionDuration: { fast: '150ms', DEFAULT: '200ms', slow: '300ms' }
                }
            }
        }
    </script>
    @stack('styles')
</head>

<body class="bg-bg-primary text-text-primary font-sans transition-colors duration-slow" x-data="{
    sidebarOpen: window.innerWidth >= 1024,
    isPageLoading: true, // Injecting loading state
    theme: localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),
    initTheme() {
        if (this.theme === 'dark') {
            document.documentElement.classList.add('dark');
            document.body.classList.add('theme-dark');
        } else {
            document.documentElement.classList.remove('dark');
            document.body.classList.remove('theme-dark');
        }
    },
    toggleTheme() {
        this.theme = this.theme === 'dark' ? 'light' : 'dark';
        localStorage.setItem('theme', this.theme);
        this.initTheme();
    }
}" x-init="
    initTheme(); 
    $watch('theme', () => initTheme());
    // 3 Second Loader Timeout
    setTimeout(() => { isPageLoading = false }, 500);
">

    <div x-show="isPageLoading" 
         x-transition.opacity.duration.500ms
         class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-bg-primary"
         style="display: flex;"> <div class="relative w-16 h-16 flex items-center justify-center mb-6">
            <div class="absolute inset-0 rounded-full border-4 border-border-default"></div>
            <div class="absolute inset-0 rounded-full border-4 border-brand-primary border-t-transparent animate-spin"></div>
            <img src="{{ asset('favicon.png') }}" class="w-6 h-6 animate-pulse" alt="Sahor One">
        </div>
        
        <h2 class="text-h3 font-bold text-text-primary tracking-tight mb-2">SahorOne</h2>
        <p class="text-caption text-text-tertiary animate-pulse uppercase tracking-widest font-semibold">Initializing Workspace...</p>
    </div>

    <div class="flex h-screen w-full overflow-hidden bg-bg-primary">

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity 
             class="fixed inset-0 bg-black/50 z-30 lg:hidden" x-cloak></div>

        <x-Partials.sidebar />

        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300 ease-in-out h-screen overflow-y-auto relative z-10">

            <header class="bg-bg-primary border-b border-border-default h-16 flex items-center justify-between px-6 sticky top-0 z-20 transition-colors duration-slow">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-text-secondary hover:text-brand-primary transition-colors duration-fast mr-4 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary/20 rounded-md">
                        <svg x-show="sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        <svg x-show="!sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    </button>
                    <h1 class="text-h4 font-semibold text-text-primary">Admin Console</h1>
                </div>

                <div class="flex items-center space-x-3">
                    <button @click="toggleTheme()" class="p-2 text-text-secondary hover:text-brand-primary hover:bg-bg-secondary rounded-md transition-all duration-fast">
                        <svg x-show="theme === 'light'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" /></svg>
                        <svg x-show="theme === 'dark'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" /></svg>
                    </button>

                    <div x-data="{ showNotifications: false }" class="relative">
                        <button @click="showNotifications = !showNotifications" class="relative p-2 text-text-secondary hover:text-brand-primary hover:bg-bg-secondary rounded-md transition-all duration-fast">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <span class="absolute top-1.5 right-1.5 block h-2 w-2 rounded-full bg-semantic-error ring-2 ring-bg-primary"></span>
                        </button>
                        <div x-show="showNotifications" @click.outside="showNotifications = false" x-transition:enter="transition ease-out duration-fast" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute right-0 mt-2 w-80 rounded-lg shadow-lg bg-bg-secondary border border-border-default z-50 overflow-hidden" style="display: none;">
                            <div class="p-4 bg-bg-secondary border-b border-border-default flex justify-between items-center">
                                <h3 class="text-caption font-semibold text-text-primary uppercase tracking-wide">Notifications</h3>
                                <button class="text-text-tertiary hover:text-brand-primary transition-colors text-xs font-medium">Mark all read</button>
                            </div>
                            <div class="max-h-64 overflow-y-auto bg-bg-primary p-6 text-center">
                                <i data-lucide="inbox" class="w-8 h-8 mx-auto text-text-tertiary mb-2"></i>
                                <p class="text-body-sm text-text-secondary">You're all caught up.</p>
                            </div>
                            <a href="#" class="block p-3 text-center text-caption font-medium text-brand-primary bg-bg-secondary hover:bg-bg-tertiary border-t border-border-default">View History</a>
                        </div>
                    </div>

                    <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2 p-1 rounded-md hover:bg-bg-secondary transition-colors">
                            <img class="w-8 h-8 rounded-full object-cover border border-border-strong" src="https://ui-avatars.com/api/?name=Super+Admin&background=5B6AF0&color=fff&bold=true" alt="Profile">
                            <i data-lucide="chevron-down" class="w-4 h-4 text-text-tertiary"></i>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-fast" x-transition:enter-start="opacity-0 scale-95 transform -translate-y-2" x-transition:enter-end="opacity-100 scale-100 transform translate-y-0" x-transition:leave="transition ease-in duration-fast" x-transition:leave-start="opacity-100 scale-100 transform translate-y-0" x-transition:leave-end="opacity-0 scale-95 transform -translate-y-2" class="absolute right-0 mt-2 w-64 rounded-lg shadow-lg bg-bg-secondary border border-border-default z-50 overflow-hidden" style="display: none;">
                            <div class="px-4 py-3 bg-bg-tertiary border-b border-border-default">
                                <p class="text-body-sm font-semibold text-text-primary truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                                <p class="text-caption text-text-secondary truncate">{{ auth()->user()->email ?? 'admin@sahorone.com' }}</p>
                            </div>
                            <div class="py-2 bg-bg-secondary">
                                <div class="px-4 py-1.5 flex justify-between items-center">
                                    <span class="text-caption text-text-secondary">Access Level</span>
                                    <span class="font-mono text-[10px] text-brand-primary bg-brand-primary/10 px-2 py-0.5 rounded-sm uppercase font-semibold border border-brand-primary/20">{{ auth()->user()->roles->first()->name ?? 'SUPER_ADMIN' }}</span>
                                </div>
                                <div class="h-px bg-border-default my-1"></div>
                                <a href="#" class="flex items-center px-4 py-2 text-body-sm text-text-primary hover:bg-bg-tertiary hover:text-brand-primary transition-colors">
                                    <i data-lucide="settings" class="w-4 h-4 mr-3 text-text-tertiary"></i> Preferences
                                </a>
                                <div class="h-px bg-border-default my-1"></div>
                                <button @click="logout" class="w-full flex items-center px-4 py-2 text-body-sm text-semantic-error hover:bg-semantic-error/5 transition-colors font-medium text-left">
                                    <i data-lucide="log-out" class="w-4 h-4 mr-3 text-semantic-error"></i> Sign out securely
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-6 lg:p-8 flex-1 bg-bg-primary relative z-10">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        function logout(event) {
            const logoutBtn = event.currentTarget;
            logoutBtn.disabled = true;
            logoutBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 mr-3 animate-spin"></i> Terminating session...';
            lucide.createIcons();

            const token = localStorage.getItem("token");
            if (!token) {
                localStorage.clear();
                window.location.href = "/auth/login";
                return;
            }

            fetch("/api/auth/logout", {
                method: "POST",
                headers: {
                    "Authorization": "Bearer " + token,
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(() => {
                localStorage.removeItem("token");
                localStorage.removeItem("user");
                window.location.href = "/auth/login";
            }).catch(() => {
                localStorage.clear();
                window.location.href = "/auth/login";
            });
        }
        document.addEventListener('alpine:initialized', () => lucide.createIcons());
    </script>
    @stack('scripts')
</body>
</html>
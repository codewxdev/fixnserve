<!DOCTYPE html>
<html lang="en">

<head class="fn-head">
    <meta charset="UTF-8" class="fn-meta-charset">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" class="fn-meta-viewport">
    <title class="fn-title">SahorOne | Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com" class="fn-script-tailwind"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet"
        class="fn-link-font">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" class="fn-script-alpine"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" class="fn-link-fontawesome" />
    <link rel="stylesheet" href="{{ asset('assets/responsive.css') }}" class="fn-link-responsive">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    {{-- <style class="fn-style-custom">
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        .pro-card {
            transition: all 0.3s ease-in-out;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }

        .pro-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        /* Sidebar Transition Logic */
        .fn-main-content-area {
            transition-property: margin-left;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
    </style> --}}
    @stack('styles')
</head>

<body class="antialiased fn-body theme-bg-body transition-colors duration-300" x-data="{
    sidebarOpen: window.innerWidth >= 1024,
    currentTheme: localStorage.getItem('s1_theme') || 'default',
    setTheme(theme) {
        this.currentTheme = theme;
        localStorage.setItem('s1_theme', theme);
    }
}"
    :class="{
        'theme-saas': currentTheme === 'saas',
        'theme-cyberpunk': currentTheme === 'cyberpunk',
        'theme-fintech': currentTheme === 'fintech',
        'theme-midnight': currentTheme === 'midnight',
        'theme-crimson': currentTheme === 'crimson',
        'theme-solar': currentTheme === 'solar',
        'theme-obsidian': currentTheme === 'obsidian',
        'theme-royal': currentTheme === 'royal',
        'theme-forest': currentTheme === 'forest'
    }">

    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="fn-app-wrapper">

        <x-partials.sidebar class="fn-sidebar-component" />

        <div x-bind:class="{ 'ml-72': sidebarOpen, 'ml-20': !sidebarOpen }"
            class="fn-main-content-area min-h-screen flex flex-col">

            <header
                class="bg-white shadow-sm border-b border-gray-200 h-16 flex items-center justify-between px-6 sticky top-0 z-20 fn-header-top-nav">

                <div class="flex items-center fn-header-left-group">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="text-slate-600 hover:text-blue-500 transition-colors mr-4 focus:outline-none fn-btn-sidebar-toggle">
                        <svg x-show="sidebarOpen" class="w-6 h-6 fn-icon-menu-open" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                        <svg x-show="!sidebarOpen" class="w-6 h-6 fn-icon-menu-closed" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <h1 class="text-xl font-semibold text-slate-800 fn-header-title">Admin Panel</h1>
                </div>

                <div class="flex items-center space-x-4">
                    <div x-data="{ showThemeMenu: false }" class="relative">
                        <button @click="showThemeMenu = !showThemeMenu"
                            class="relative p-2 text-slate-500 hover:text-blue-600 transition-colors focus:outline-none"
                            title="Change Theme">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01">
                                </path>
                            </svg>
                        </button>

                        <div x-show="showThemeMenu" @click.outside="showThemeMenu = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            class="absolute right-0 mt-2 w-48 rounded-xl shadow-2xl theme-bg-card border theme-border z-50 overflow-hidden py-1"
                            style="display: none;">

                            <div
                                class="px-4 py-2 text-xs font-bold uppercase theme-text-muted opacity-70 tracking-wider">
                                Select Theme</div>

                            <button @click="setTheme('default'); showThemeMenu = false"
                                class="w-full text-left px-4 py-2 text-sm theme-text-main hover:bg-white/5 flex items-center justify-between group transition-colors">
                                <span>Default (Dark)</span>
                                <span x-show="currentTheme === 'default'" class="text-blue-500 font-bold">✓</span>
                            </button>

                            <button @click="setTheme('saas'); showThemeMenu = false"
                                class="w-full text-left px-4 py-2 text-sm theme-text-main hover:bg-white/5 flex items-center justify-between group transition-colors">
                                <span>Clean SaaS (Light)</span>
                                <span x-show="currentTheme === 'saas'" class="text-blue-500 font-bold">✓</span>
                            </button>

                            <button @click="setTheme('cyberpunk'); showThemeMenu = false"
                                class="w-full text-left px-4 py-2 text-sm theme-text-main hover:bg-white/5 flex items-center justify-between group transition-colors">
                                <span>Cyberpunk Neon</span>
                                <span x-show="currentTheme === 'cyberpunk'" class="text-blue-500 font-bold">✓</span>
                            </button>

                            <button @click="setTheme('fintech'); showThemeMenu = false"
                                class="w-full text-left px-4 py-2 text-sm theme-text-main hover:bg-white/5 flex items-center justify-between group transition-colors">
                                <span>Fintech Emerald</span>
                                <span x-show="currentTheme === 'fintech'" class="text-blue-500 font-bold">✓</span>
                            </button>

                            <button @click="setTheme('midnight'); showThemeMenu = false"
                                class="w-full text-left px-4 py-2 text-sm theme-text-main hover:bg-white/5 flex items-center justify-between group transition-colors">
                                <span>Midnight Pro</span>
                                <span x-show="currentTheme === 'midnight'" class="text-blue-500 font-bold">✓</span>
                            </button>

                            <button @click="setTheme('crimson'); showThemeMenu = false"
                                class="w-full text-left px-4 py-2 text-sm theme-text-main hover:bg-white/5 flex items-center justify-between group transition-colors">
                                <span>Crimson Ops</span>
                                <span x-show="currentTheme === 'crimson'" class="text-blue-500 font-bold">✓</span>
                            </button>

                            <button @click="setTheme('solar'); showThemeMenu = false"
                                class="w-full text-left px-4 py-2 text-sm theme-text-main hover:bg-white/5 flex items-center justify-between group transition-colors">
                                <span>Solar Light (Warm)</span>
                                <span x-show="currentTheme === 'solar'" class="text-blue-500 font-bold">✓</span>
                            </button>

                            <button @click="setTheme('obsidian'); showThemeMenu = false"
                                class="w-full text-left px-4 py-2 text-sm theme-text-main hover:bg-white/5 flex items-center justify-between group transition-colors">
                                <span>Obsidian Gold (Luxury)</span>
                                <span x-show="currentTheme === 'obsidian'" class="text-blue-500 font-bold">✓</span>
                            </button>

                            <button @click="setTheme('royal'); showThemeMenu = false"
                                class="w-full text-left px-4 py-2 text-sm theme-text-main hover:bg-white/5 flex items-center justify-between group transition-colors">
                                <span>Royal Twilight</span>
                                <span x-show="currentTheme === 'royal'" class="text-blue-500 font-bold">✓</span>
                            </button>

                            <button @click="setTheme('forest'); showThemeMenu = false"
                                class="w-full text-left px-4 py-2 text-sm theme-text-main hover:bg-white/5 flex items-center justify-between group transition-colors">
                                <span>Deep Forest</span>
                                <span x-show="currentTheme === 'forest'" class="text-blue-500 font-bold">✓</span>
                            </button>
                        </div>
                    </div>
                    <div x-data="{ showNotifications: false }" class="relative">
                        <button @click="showNotifications = !showNotifications"
                            class="relative p-2 text-slate-500 hover:text-blue-600 transition-colors focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-2.81A3 3 0 0018 11.237V9c0-1.368-.592-2.735-1.353-3.794m-9.792 0C7.592 5.265 8 6.632 8 8v3.237a3 3 0 00-.6 1.745L4 17h5m-1.892-4.276a1 1 0 011.784 0M12 21a2 2 0 002-2v-1.764c0-.92-.38-1.777-1.002-2.398M12 21v-2a4 4 0 00-4-4">
                                </path>
                            </svg>
                            <span
                                class="absolute top-2 right-2 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
                        </button>

                        <div x-show="showNotifications" @click.outside="showNotifications = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute right-0 mt-2 w-72 rounded-xl shadow-2xl bg-white border border-gray-100 z-50 overflow-hidden">
                            <div class="p-4 bg-slate-50 border-b border-gray-100">
                                <h3 class="text-sm font-semibold text-slate-800">Notifications</h3>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                <div class="p-4 text-center">
                                    <p class="text-xs text-slate-500">You have no new notifications</p>
                                </div>
                            </div>
                            <a href="#"
                                class="block p-3 text-center text-xs font-medium text-blue-600 bg-slate-50 hover:bg-blue-50 transition-colors border-t border-gray-100">
                                View All Notifications
                            </a>
                        </div>
                    </div>
                    <div x-data="{ open: false }" @click.outside="open = false"
                        class="relative fn-profile-dropdown-container">
                        <button @click="open = !open"
                            class="flex items-center space-x-2 focus:outline-none fn-btn-profile-trigger">
                            <span class="text-slate-600 font-medium hidden sm:inline fn-profile-name">Super
                                Admin</span>
                            <img class="w-10 h-10 rounded-full object-cover border-2 border-blue-400 fn-profile-image"
                                src="https://placehold.co/150x150/3b82f6/ffffff?text=SA" alt="Admin Profile">
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-60 rounded-xl shadow-2xl bg-white border border-gray-100 z-50 overflow-hidden fn-profile-dropdown-menu">

                            <div class="p-4 bg-blue-50 border-b border-blue-100 fn-dropdown-header"
                                x-data="{ user: JSON.parse(localStorage.getItem('user')) }">
                                <p class="text-sm font-semibold text-slate-800 fn-dropdown-header-role"
                                    x-text="user?.name">
                                    Super Admin</p>
                                <p class="text-xs text-slate-500 fn-dropdown-header-email" x-text="user?.email">
                                    superadmin@fixnserve.com</p>
                            </div>

                            <div class="py-1 fn-dropdown-body" x-data="{ user: JSON.parse(localStorage.getItem('user')) }">
                                <div
                                    class="px-4 py-2 text-sm text-slate-600 flex justify-between items-center border-b border-gray-100 fn-dropdown-detail-role">
                                    <span class="fn-dropdown-detail-label">Role:</span>
                                    <span
                                        class="font-medium text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full text-xs fn-dropdown-detail-role-value"
                                        x-text="user?.roles[0].name"> </span>
                                </div>
                                <div
                                    class="px-4 py-2 text-sm text-slate-600 flex justify-between items-center fn-dropdown-detail-id">
                                    <span class="fn-dropdown-detail-label">User ID:</span>
                                    <span class="font-mono text-xs text-slate-500 fn-dropdown-detail-id-value"
                                        x-text="user?.id">#009</span>
                                </div>

                                <hr class="border-gray-100 my-1 fn-dropdown-divider-1">
                                <a href="#"
                                    class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-gray-50 transition-colors fn-dropdown-link-profile">
                                    <svg class="w-4 h-4 mr-2 text-blue-500 fn-icon-profile" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    Profile Settings
                                </a>
                                <hr class="border-gray-100 my-1 fn-dropdown-divider-2">

                                <button @click="logout"
                                    class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors font-medium text-left fn-btn-logout">
                                    <svg class="w-4 h-4 mr-2 text-red-500 fn-icon-logout" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-6 lg:p-8 fn-main-page-content flex-1">
                @yield('content')
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/apexcharts" class="fn-script-apexcharts"></script>

    <script class="fn-script-logout">
        function logout() {
            const logoutBtn = event.target;
            logoutBtn.disabled = true;
            logoutBtn.innerText = "Logging out...";
            const token = localStorage.getItem("token");
            console.log("Attempting to logout with token:", token);
            if (!token) {
                localStorage.clear();
                window.location.href = "/auth/login";
                return;
            }
            fetch("http://127.0.0.1:8000/api/auth/logout", {
                    method: "POST",
                    headers: {
                        "Authorization": "Bearer " + token,
                        "Content-Type": "application/json"
                    }
                })
                 
                .then(response => response.json())
                .then(data => {
                     
                    localStorage.removeItem("token");
                    localStorage.removeItem("user");
                    // window.location.href = "/auth/login";
                })
                .catch(error => {
                    console.error("Logout Error:", error);
                    localStorage.removeItem("token");
                    localStorage.removeItem("user");
                    // window.location.href = "/auth/login";
                });
        }
    </script>

    @stack('scripts')
</body>

</html>

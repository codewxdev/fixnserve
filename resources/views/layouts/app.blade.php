 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>FixnServe | Admin Dashboard</title>
     <!-- Tailwind CSS (assumes it's built/linked via Vite) -->
     <script src="https://cdn.tailwindcss.com"></script>
     <!-- Inter Font -->
     <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
     <!-- ApexCharts Library -->
     <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
     <!-- Alpine.js -->
     <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

     <!-- Custom Pro Styles (linked to dashboard.css content above) -->
     <style>
         /* Include the contents of resources/css/dashboard.css here for a single-file demonstration */
         /* Start: resources/css/dashboard.css */
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

         body {
             font-family: 'Inter', sans-serif;
             background-color: #f8fafc;
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

         .sidebar {
             transition: width 0.3s ease-in-out;
             background-color: #1e293b;
             box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
         }

         .nav-active {
             background-color: #334155;
             border-left: 4px solid #3b82f6;
         }

         #dashboard-chart {
             background-color: white;
             padding: 1.5rem;
             border-radius: 1rem;
             box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
         }

         /* End: resources/css/dashboard.css */
     </style>
     {{-- Note: In a real Laravel project, you would use: <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">   --}}
 </head>

 <body class="antialiased">

     <!-- Alpine.js state for sidebar -->
     <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }">
         <!--Sidebar-->
         <x-partials.sidebar/>

         <!-- Main Content Area -->
         <div x-bind:class="{ 'ml-64': sidebarOpen, 'ml-20': !sidebarOpen }" class="transition-all duration-300">

             <!-- Header/Top Nav -->
             <header
                 class="bg-white shadow-sm border-b border-gray-200 h-16 flex items-center justify-between px-6 sticky top-0 z-20">

                 <div class="flex items-center">
                     <!-- Sidebar Toggle Button -->
                     <button @click="sidebarOpen = !sidebarOpen"
                         class="text-slate-600 hover:text-blue-500 transition-colors mr-4 focus:outline-none">
                         <svg x-show="sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M4 6h16M4 12h16M4 18h7"></path>
                         </svg>
                         <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                         </svg>
                     </button>
                     <h1 class="text-xl font-semibold text-slate-800">Admin Panel</h1>
                 </div>

                 <!-- User Profile/Notifications -->
                 <div class="flex items-center space-x-4">
                     <span class="text-slate-600 font-medium hidden sm:inline">Super Admin</span>
                     <img class="w-10 h-10 rounded-full object-cover border-2 border-blue-400"
                         src="https://placehold.co/150x150/3b82f6/ffffff?text=SA" alt="Admin Profile">
                 </div>
             </header>

             <!-- Page Content -->
             <main class="p-6 lg:p-8">
                 @yield('content')
             </main>
         </div>
     </div>

     <!-- Main JS file (Chart initialization goes here) -->
     {{-- Note: In a real Laravel project, you would use: <script src="{{ mix('js/app.js') }}"></script>  --}}
     <script>
         // Placeholder for main JS logic and Alpine init
     </script>
     @yield('scripts')

 </body>

 </html>

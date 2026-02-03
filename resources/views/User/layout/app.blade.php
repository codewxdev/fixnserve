<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Hide scrollbar for horizontal nav */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .nav-item.active {
            color: #4F46E5; /* Indigo-600 */
            border-bottom: 2px solid #4F46E5;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-900">

    <header class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                        Aura<span class="text-gray-900">Partner</span>
                    </span>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden md:flex items-center bg-gray-100 rounded-full px-3 py-1">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wide">Online</span>
                    </div>

                    <button class="relative p-2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full border border-white"></span>
                    </button>

                    <div class="flex items-center gap-2 cursor-pointer">
                        <img class="h-9 w-9 rounded-full object-cover border border-gray-200" 
                             src="https://ui-avatars.com/api/?name=Ali+Raza&background=random" alt="User">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex space-x-8 overflow-x-auto no-scrollbar h-14 items-center" aria-label="Tabs">
                
                <a href="#" class="nav-item active flex items-center whitespace-nowrap py-4 px-1 text-sm font-bold border-b-2 border-transparent hover:text-indigo-600 transition">
                    <i class="fas fa-home mr-2"></i> Overview
                </a>

                <a href="#" class="nav-item flex items-center whitespace-nowrap py-4 px-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-indigo-600 hover:border-gray-300 transition">
                    <i class="fas fa-briefcase mr-2"></i> My Jobs
                    <span class="ml-2 bg-indigo-100 text-indigo-600 py-0.5 px-2 rounded-full text-xs">2</span>
                </a>

                <a href="#" class="nav-item flex items-center whitespace-nowrap py-4 px-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-indigo-600 hover:border-gray-300 transition">
                    <i class="fas fa-wallet mr-2"></i> Earnings & Wallet
                </a>

                <a href="#" class="nav-item flex items-center whitespace-nowrap py-4 px-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-indigo-600 hover:border-gray-300 transition">
                    <i class="fas fa-layer-group mr-2"></i> Services & Gigs
                </a>

                <a href="#" class="nav-item flex items-center whitespace-nowrap py-4 px-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-indigo-600 hover:border-gray-300 transition">
                    <i class="fas fa-user-check mr-2"></i> Verification (KYC)
                </a>
            </nav>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

</body>
</html>
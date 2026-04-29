<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Workspace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .nav-item.active {
            color: #059669; /* Emerald-600 */
            border-bottom: 2px solid #059669;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-900">

    <header class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-2">
                    <div class="bg-emerald-600 text-white p-1.5 rounded-lg">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-gray-900">
                        Aura<span class="text-emerald-600">Expert</span>
                    </span>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden md:flex items-center bg-red-50 text-red-600 border border-red-100 rounded-full px-3 py-1 text-xs font-bold animate-pulse">
                        <i class="fas fa-video mr-2"></i> Next Session: 15m
                    </div>

                    <button class="relative p-2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-1 right-1 h-2 w-2 bg-emerald-500 rounded-full border border-white"></span>
                    </button>

                    <div class="flex items-center gap-2 cursor-pointer">
                        <img class="h-9 w-9 rounded-full object-cover border border-gray-200" 
                             src="https://ui-avatars.com/api/?name=Dr+Sarah&background=10b981&color=fff" alt="User">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex space-x-8 overflow-x-auto no-scrollbar h-14 items-center">
                
                <a href="#" class="nav-item active flex items-center whitespace-nowrap py-4 px-1 text-sm font-bold border-b-2 border-transparent hover:text-emerald-600 transition">
                    <i class="fas fa-chart-pie mr-2"></i> Overview
                </a>

                <a href="#" class="nav-item flex items-center whitespace-nowrap py-4 px-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-emerald-600 transition">
                    <i class="fas fa-calendar-check mr-2"></i> Appointments
                    <span class="ml-2 bg-emerald-100 text-emerald-600 py-0.5 px-2 rounded-full text-xs">4</span>
                </a>

                <a href="#" class="nav-item flex items-center whitespace-nowrap py-4 px-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-emerald-600 transition">
                    <i class="fas fa-briefcase mr-2"></i> My Services
                </a>

                <a href="#" class="nav-item flex items-center whitespace-nowrap py-4 px-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-emerald-600 transition">
                    <i class="fas fa-wallet mr-2"></i> Finances
                </a>

                <a href="#" class="nav-item flex items-center whitespace-nowrap py-4 px-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-emerald-600 transition">
                    <i class="fas fa-file-alt mr-2"></i> Portfolio & CV
                </a>
            </nav>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <div class="bg-gradient-to-r from-emerald-900 to-teal-800 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-10 -mt-10 w-48 h-48 bg-white opacity-5 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h1 class="text-2xl font-bold font-serif tracking-wide">Welcome, Dr. Sarah.</h1>
                    <p class="text-emerald-100 text-sm mt-1">You have <span class="text-white font-bold underline">4 consultations</span> scheduled for today.</p>
                </div>
                
                <div class="flex gap-4">
                    <button class="bg-white text-emerald-900 px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-emerald-50 transition flex items-center gap-2">
                        <i class="fas fa-plus-circle"></i> Create Custom Offer
                    </button>
                    <div class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-lg border border-white/10 text-center">
                        <p class="text-[10px] text-emerald-200 uppercase">Profile Views</p>
                        <p class="text-lg font-bold">1.2k</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800"><i class="fas fa-video text-emerald-600 mr-2"></i>Upcoming Consultations</h3>
                    <a href="#" class="text-xs font-bold text-emerald-600 hover:underline">View Calendar</a>
                </div>
                
                <div class="divide-y divide-gray-100">
                    <div class="p-5 bg-emerald-50/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="h-12 w-12 rounded-xl bg-white border border-gray-200 text-emerald-600 flex flex-col items-center justify-center shrink-0 shadow-sm">
                                <span class="text-xs font-bold uppercase">Today</span>
                                <span class="text-lg font-bold leading-none">10:00</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Legal Consultation - Corporate Tax</h4>
                                <p class="text-sm text-gray-500 mb-1">Client: <span class="font-medium text-gray-700">Mr. Ahmed Khan</span></p>
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-100 text-blue-700">
                                      <i class="fas fa-video mr-1"></i> Zoom Meeting
                                    </span>
                                    <span class="text-xs text-red-500 font-bold animate-pulse">Starts in 15 mins</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 self-end sm:self-center">
                            <button class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-md flex items-center gap-2">
                                <i class="fas fa-video"></i> Join Room
                            </button>
                        </div>
                    </div>

                    <div class="p-5 hover:bg-gray-50 transition flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="h-12 w-12 rounded-xl bg-gray-50 border border-gray-200 text-gray-500 flex flex-col items-center justify-center shrink-0">
                                <span class="text-xs font-bold uppercase">Today</span>
                                <span class="text-lg font-bold leading-none">02:30</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Architecture Review - Villa Project</h4>
                                <p class="text-sm text-gray-500 mb-1">Client: <span class="font-medium text-gray-700">Estate Developers LLC</span></p>
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-purple-100 text-purple-700">
                                      <i class="fas fa-file-alt mr-1"></i> Document Review
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 self-end sm:self-center">
                             <button class="px-3 py-2 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50">Reschedule</button>
                             <button class="px-3 py-2 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50">Details</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">New Client Inquiries</h3>
                    <span class="text-xs text-gray-400">Showing last 3</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Client</th>
                                <th class="px-6 py-3">Topic</th>
                                <th class="px-6 py-3 text-center">Budget</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">Fatima Ali</td>
                                <td class="px-6 py-4">Family Law Advice</td>
                                <td class="px-6 py-4 text-center"><span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-bold">$150 Fixed</span></td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-emerald-600 hover:text-emerald-800 font-medium">Reply</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="space-y-6">

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800">Net Income</h3>
                    <span class="text-xs text-gray-400">This Month</span>
                </div>
                <div class="text-center py-2">
                    <h2 class="text-4xl font-extrabold text-gray-900">$5,240<span class="text-lg text-gray-400 font-medium">.00</span></h2>
                </div>
                
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div class="bg-gray-50 p-2 rounded-lg text-center">
                        <p class="text-xs text-gray-500">Pending Clearance</p>
                        <p class="font-bold text-gray-800">$450.00</p>
                    </div>
                    <div class="bg-gray-50 p-2 rounded-lg text-center">
                        <p class="text-xs text-gray-500">Avg. Hourly</p>
                        <p class="font-bold text-gray-800">$85.00</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="font-bold text-gray-800 mb-4">Consultation Status</h3>
                
                <div class="flex items-center justify-between py-3 border-b border-gray-50">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Accepting New Clients</p>
                        <p class="text-xs text-gray-500">Visible in search results</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>

                 <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Instant Booking</p>
                        <p class="text-xs text-gray-500">Allow auto-confirm</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <a href="#" class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl hover:shadow-md transition text-center group">
                    <div class="h-10 w-10 mx-auto bg-white text-emerald-600 rounded-full flex items-center justify-center shadow-sm">
                        <i class="fas fa-file-upload"></i>
                    </div>
                    <p class="text-xs font-bold text-gray-700 mt-3">Upload Portfolio</p>
                </a>
                <a href="#" class="p-4 bg-white border border-gray-200 rounded-xl hover:shadow-md transition text-center group">
                    <div class="h-10 w-10 mx-auto bg-gray-100 text-gray-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-cog"></i>
                    </div>
                    <p class="text-xs font-bold text-gray-700 mt-3">Settings</p>
                </a>
            </div>

        </div>
    </div>
    </main>

</body>
</html>
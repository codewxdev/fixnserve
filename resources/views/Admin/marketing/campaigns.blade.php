@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Campaign Manager</h1>
            <p class="text-slate-500 mt-1">Push Notifications, SMS Blasts & Email Marketing.</p>
        </div>
        <div class="flex gap-3">
             <button class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg shadow-sm flex items-center gap-2 transition-all">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Scheduled
            </button>
            <button class="px-5 py-2.5 bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white font-medium rounded-lg shadow-lg shadow-pink-500/30 flex items-center gap-2 transition-all transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                Blast Campaign
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden group hover:shadow-md transition-shadow">
            <div class="h-40 bg-slate-100 relative overflow-hidden">
                 <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white/50">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                 </div>
                 <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-blue-600 shadow-sm">
                    Running
                 </div>
            </div>
            
            <div class="p-5">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Push Notification</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-[10px] text-slate-400">Target: All Users</span>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Weekend Special Sale</h3>
                <p class="text-sm text-slate-500 line-clamp-2 mb-4">Get 20% off on all Mart items this weekend. Order now and get free delivery!</p>
                
                <div class="grid grid-cols-3 gap-2 py-4 border-t border-slate-100">
                    <div class="text-center">
                        <span class="block text-lg font-bold text-slate-800">12k</span>
                        <span class="text-[10px] text-slate-400 uppercase">Sent</span>
                    </div>
                    <div class="text-center border-l border-slate-100">
                        <span class="block text-lg font-bold text-blue-600">45%</span>
                        <span class="text-[10px] text-slate-400 uppercase">Open Rate</span>
                    </div>
                    <div class="text-center border-l border-slate-100">
                        <span class="block text-lg font-bold text-green-600">1.2%</span>
                        <span class="text-[10px] text-slate-400 uppercase">Conversion</span>
                    </div>
                </div>

                <div class="mt-2 flex gap-2">
                    <button class="flex-1 py-2 text-sm font-medium text-slate-600 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">View Report</button>
                    <button class="px-3 py-2 text-slate-400 hover:text-red-500 bg-slate-50 rounded-lg hover:bg-red-50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden opacity-90">
             <div class="h-40 bg-slate-800 relative overflow-hidden flex items-center justify-center">
                <span class="text-slate-500 font-bold text-2xl">SMS</span>
                <div class="absolute top-3 right-3 bg-slate-600/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-white shadow-sm">
                    Completed
                 </div>
            </div>
            
            <div class="p-5">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">SMS Campaign</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-[10px] text-slate-400">Target: Inactive Users</span>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">We Miss You!</h3>
                <p class="text-sm text-slate-500 line-clamp-2 mb-4">It's been a while. Here is a voucher for your next service booking.</p>
                
                 <div class="grid grid-cols-3 gap-2 py-4 border-t border-slate-100">
                    <div class="text-center">
                        <span class="block text-lg font-bold text-slate-800">500</span>
                        <span class="text-[10px] text-slate-400 uppercase">Sent</span>
                    </div>
                    <div class="text-center border-l border-slate-100">
                        <span class="block text-lg font-bold text-slate-500">98%</span>
                        <span class="text-[10px] text-slate-400 uppercase">Delivered</span>
                    </div>
                    <div class="text-center border-l border-slate-100">
                        <span class="block text-lg font-bold text-green-600">12</span>
                        <span class="text-[10px] text-slate-400 uppercase">Sales</span>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="w-full py-2 text-sm font-medium text-slate-600 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">Duplicate Campaign</button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@extends('layouts.app')

@section('head')
{{-- Font Awesome CDN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>
@endsection

@section('content')
<div class="min-h-screen theme-bg-body theme-text-main p-6 space-y-8" x-data="{ 
    openVendorId: null, 
    isAddVendorModalOpen: false, 
    currentTab: 'overview',
    searchTerm: '',
    categoryFilter: '',
    statusFilter: '',
    isSubmitting: false,
    riders: {{ $riders->toJson() }},

    get filteredriders() {
        return this.riders.filter(v => {
            const search = this.searchTerm.toLowerCase();
            const nameMatch = v.name ? v.name.toLowerCase().includes(search) : false;
            const ownerMatch = v.owner ? v.owner.toLowerCase().includes(search) : false;
            const contactMatch = v.contact ? v.contact.toLowerCase().includes(search) : false;
            
            const matchesSearch = nameMatch || ownerMatch || contactMatch;
            const matchesCategory = this.categoryFilter === '' || this.categoryFilter === 'NaN' || v.category === this.categoryFilter;
            const matchesStatus = this.statusFilter === '' || (v.status && v.status.toLowerCase() === this.statusFilter.toLowerCase());
                                  
            return matchesSearch && matchesStatus;
        });
    },

    get activeVendor() {
        const r = this.riders.find(v => v.id === this.openVendorId) || {};
        return {
            ...r,
            assigned_to: r.assigned_to || 'Central Pool (Unassigned)',
            address: r.address_details || { 
                current: r.address || 'House #12, Street 4, Sector G-10/2', 
                permanent: 'Village ABC, District XYZ', 
                city: r.city || 'Islamabad' 
            },
            wallet: r.wallet || { 
                balance: 5400, 
                pending: 1200, 
                withdrawn: 85000 
            },
            payment_methods: r.payment_methods || ['JazzCash', 'EasyPaisa', 'Bank Alfalah'],
            portfolio_items: [] 
        };
    },

    formatMoney(amount) {
        if(!amount || amount === 'NaN') return 'PKR 0';
        return 'PKR ' + Number(amount).toLocaleString();
    },

    async submitForm(e) {
        this.isSubmitting = true;
        const formData = new FormData(e.target);
        const actionUrl = e.target.action;

        try {
            const response = await fetch(actionUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const result = await response.json();

            if (response.ok) {
                alert('Rider Added Successfully!');
                location.reload(); 
            } else {
                let errorMsg = result.message || 'Validation failed';
                if(result.errors) {
                    errorMsg = Object.values(result.errors).flat().join('\n');
                }
                alert(errorMsg);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Server connection failed.');
        } finally {
            this.isSubmitting = false;
        }
    }
}" x-cloak>

    {{-- 1. HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold theme-text-main tracking-tight">Rider Management</h1>
            <p class="text-sm theme-text-muted">Manage Logistics, Riders, and Payouts</p>
        </div>
        <div class="flex gap-3">
             <button class="inline-flex items-center justify-center px-4 py-2 theme-bg-card border theme-border rounded-lg text-sm font-medium theme-text-muted hover:bg-white/5 transition shadow-sm">
                <i class="fa-solid fa-download mr-2"></i> Export
            </button>
            <button @click="isAddVendorModalOpen = true" 
                class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 focus:outline-none transition shadow-lg"
                style="background-color: rgb(var(--brand-primary)); box-shadow: 0 4px 10px rgba(var(--brand-primary), 0.3);">
                <i class="fa-solid fa-motorcycle mr-2"></i> Onboard Rider
            </button>
        </div>
    </div>

    {{-- 2. ANALYTICS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Card 1 --}}
        <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-indigo-500/10 group-hover:bg-indigo-500/20 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Total Riders</p>
                    <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-indigo-500 transition-colors" x-text="riders.length"></h3>
                </div>
                <div class="p-3 bg-indigo-500/10 text-indigo-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-helmet-safety text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs theme-text-muted">
                <span class="text-indigo-500 font-bold bg-indigo-500/10 px-1.5 py-0.5 rounded mr-2 border border-indigo-500/20"><i class="fa-solid fa-arrow-up"></i> Fleet</span>
                <span>Active Personnel</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-400 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        {{-- Card 2 --}}
        <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-emerald-500/10 group-hover:bg-emerald-500/20 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Completed Orders</p>
                    <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-emerald-500 transition-colors">NaN</h3>
                </div>
                <div class="p-3 bg-emerald-500/10 text-emerald-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-check-double text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs theme-text-muted">
                <span class="text-emerald-500 font-bold bg-emerald-500/10 px-1.5 py-0.5 rounded mr-2 border border-emerald-500/20"><i class="fa-solid fa-box-open"></i> Delivered</span>
                <span>Successful Drops</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        {{-- Card 3 --}}
        <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-amber-500/10 group-hover:bg-amber-500/20 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Pending Verifications</p>
                    <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-amber-500 transition-colors">NaN</h3>
                </div>
                <div class="p-3 bg-amber-500/10 text-amber-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-id-card-clip text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs theme-text-muted">
                <span class="text-amber-500 font-bold bg-amber-500/10 px-1.5 py-0.5 rounded mr-2 border border-amber-500/20"><i class="fa-solid fa-user-clock"></i> KYC</span>
                <span>Documents Review</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        {{-- Card 4 --}}
        <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-rose-500/10 group-hover:bg-rose-500/20 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Rider Earnings</p>
                    <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-rose-500 transition-colors">NaN</h3>
                </div>
                <div class="p-3 bg-rose-500/10 text-rose-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-wallet text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs theme-text-muted">
                <span class="text-rose-500 font-bold bg-rose-500/10 px-1.5 py-0.5 rounded mr-2 border border-rose-500/20"><i class="fa-solid fa-coins"></i> Payouts</span>
                <span>Total Disbursed</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-rose-400 to-red-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>
    </div>

    {{-- 3. MAIN CONTENT --}}
    <div class="theme-bg-card border theme-border rounded-xl shadow-sm overflow-hidden">
        
        {{-- Filter Bar --}}
        <div class="p-4 border-b theme-border flex flex-wrap gap-4 items-center justify-between" style="background-color: rgba(var(--bg-body), 0.5);">
            <div class="relative flex-1 max-w-md min-w-[200px]">
                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 theme-text-muted"></i>
                <input type="text" x-model="searchTerm" placeholder="Search Rider Name, Email..." 
                    class="w-full pl-10 pr-4 py-2 text-sm theme-bg-body border theme-border rounded-lg focus:ring-2 focus:ring-blue-500 theme-text-main placeholder-gray-500">
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y theme-border" style="border-color: rgb(var(--border-color));">
                <thead class="theme-bg-body">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium theme-text-muted uppercase tracking-wider">Rider Details</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium theme-text-muted uppercase tracking-wider">Assigned To</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium theme-text-muted uppercase tracking-wider">Operational Stats</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium theme-text-muted uppercase tracking-wider">Wallet & Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium theme-text-muted uppercase tracking-wider">Manage</th>
                    </tr>
                </thead>
                <tbody class="divide-y theme-border theme-bg-card" style="border-color: rgb(var(--border-color));">
                    <template x-for="rider in filteredriders" :key="rider.id">
                        <tr class="hover:bg-white/5 transition duration-150 group">
                            
                            {{-- Rider Info --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="relative flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-sm"
                                             :class="`bg-${rider.color}-500`" 
                                             x-text="rider.logo"></div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium theme-text-main" x-text="rider.name"></div>
                                        <div class="text-xs theme-text-muted" x-text="rider.contact"></div>
                                        <div class="text-xs theme-text-muted opacity-70 mt-0.5" x-text="rider.city"></div>
                                    </div>
                                </div>
                            </td>

                            {{-- NEW COLUMN DATA: ASSIGNED TO --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-md bg-blue-500/10 text-blue-500 border border-blue-500/20">
                                    <i class="fa-solid fa-store mr-1.5 mt-0.5"></i> 
                                    <span x-text="rider.assigned_to || 'General Pool'"></span>
                                </span>
                            </td>

                            {{-- Operational Stats --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm theme-text-main font-semibold" x-text="rider.stats.orders + ' Delivered'"></div>
                                <div class="text-xs theme-text-muted mt-1"><i class="fa-solid fa-chart-simple mr-1"></i> Revenue: <span x-text="rider.stats.revenue"></span></div>
                            </td>

                            {{-- Wallet & Status --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm theme-text-main font-bold" x-text="formatMoney(rider.wallet.balance)"></div>
                                <div class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                        :class="{
                                            'bg-green-500/10 text-green-500 border border-green-500/20': rider.status.toLowerCase() === 'active',
                                            'bg-red-500/10 text-red-500 border border-red-500/20': rider.status.toLowerCase() === 'deactive' || rider.status.toLowerCase() === 'ban',
                                            'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20': rider.status.toLowerCase() === 'suspend'
                                        }"
                                        x-text="rider.status">
                                    </span>
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center gap-2">
                                    <button @click="openVendorId = rider.id" class="text-white p-2 rounded hover:opacity-80 transition" 
                                        style="background-color: rgba(var(--brand-primary), 0.1); color: rgb(var(--brand-primary));"
                                        title="View Details">
                                        View Details
                                    </button>
                                    
                                    {{-- Dropdown --}}
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="theme-text-muted hover:text-white p-2 rounded-full hover:bg-white/10">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                        <div x-show="open" class="absolute right-0 mt-2 w-48 theme-bg-card rounded-md shadow-lg py-1 z-50 border theme-border" style="display: none;">
                                            <button class="w-full text-left px-4 py-2 text-sm text-green-500 hover:bg-white/5 flex items-center">
                                                <i class="fa-solid fa-check-circle mr-2"></i> Approve
                                            </button>
                                            <button class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-white/5 flex items-center">
                                                <i class="fa-solid fa-ban mr-2"></i> Reject
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            
            {{-- Empty State --}}
            <div x-show="filteredriders.length === 0" class="p-10 text-center theme-text-muted">
                <i class="fa-solid fa-motorcycle text-4xl mb-3 opacity-30"></i>
                <h3 class="text-sm font-medium theme-text-main">No riders found</h3>
            </div>
        </div>
        
        {{-- Footer --}}
        <div class="px-6 py-4 border-t theme-border flex justify-center theme-bg-body">
            <span class="text-xs font-medium theme-text-muted">Showing <span x-text="filteredriders.length"></span> riders</span>
        </div>
    </div>

    {{-- 4. UNIFIED SLIDE-OVER --}}
    {{-- Main Container --}}
    <div x-show="openVendorId !== null" 
         class="fixed inset-0 overflow-hidden z-50" 
         style="display: none;"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" 
             @click="openVendorId = null"></div>

        {{-- Panel Container --}}
        <div class="fixed inset-y-0 right-0 max-w-2xl w-full flex pointer-events-none">
            
            {{-- Sliding Panel --}}
            <div class="w-full h-full theme-bg-card shadow-2xl pointer-events-auto flex flex-col"
                 x-show="openVendorId !== null"
                 x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full">
                
                {{-- Header --}}
                <div class="theme-bg-card px-6 py-6 border-b theme-border shrink-0">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center space-x-4">
                            <div class="h-16 w-16 rounded-xl flex items-center justify-center text-white text-3xl font-bold shadow-inner" style="background: linear-gradient(135deg, rgb(var(--brand-primary)), rgb(var(--brand-secondary)));" x-text="activeVendor.logo"></div>
                            <div>
                                <h2 class="text-xl font-bold theme-text-main" x-text="activeVendor.name"></h2>
                                <p class="theme-text-muted text-sm flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot"></i> <span x-text="activeVendor.city"></span>
                                </p>
                            </div>
                        </div>
                        <button @click="openVendorId = null" class="theme-text-muted hover:text-white transition"><i class="fa-solid fa-times text-xl"></i></button>
                    </div>
                    
                    {{-- Tabs --}}
                    <div class="flex space-x-6 mt-8 text-sm font-medium overflow-x-auto scrollbar-hide border-b theme-border">
                        <template x-for="tab in ['overview', 'wallet', 'payment-methods', 'documents', 'orders']">
                            <button @click="currentTab = tab" 
                                :class="currentTab === tab ? 'border-b-2 font-bold' : 'border-transparent text-gray-500 hover:text-gray-300'"
                                class="pb-3 capitalize transition whitespace-nowrap"
                                :style="currentTab === tab ? 'border-color: rgb(var(--brand-primary)); color: rgb(var(--brand-primary));' : ''"
                                x-text="tab.replace('-', ' ')">
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Content --}}
                <div class="flex-1 overflow-y-auto p-6 theme-bg-body scroll-smooth">
                    
                    {{-- TAB: OVERVIEW --}}
                    <div x-show="currentTab === 'overview'" class="space-y-6">
                        <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                            <h3 class="font-bold theme-text-main mb-4 flex items-center"><i class="fa-solid fa-motorcycle mr-2" style="color: rgb(var(--brand-primary));"></i> Rider Profile</h3>
                            <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                                <div><p class="theme-text-muted text-xs uppercase">Email</p><p class="font-medium theme-text-main" x-text="activeVendor.contact"></p></div>
                                <div><p class="theme-text-muted text-xs uppercase">Phone</p><p class="font-medium theme-text-main" x-text="activeVendor.phone"></p></div>
                                <div><p class="theme-text-muted text-xs uppercase">City</p><p class="font-medium theme-text-main" x-text="activeVendor.city"></p></div>
                                
                                <div>
                                    <p class="theme-text-muted text-xs uppercase">Assigned Mart</p>
                                    <p class="font-medium font-bold" style="color: rgb(var(--brand-primary));" x-text="activeVendor.assigned_to"></p>
                                </div>
                                
                                <div class="col-span-2 border-t theme-border pt-2 mt-2">
                                    <p class="theme-text-muted text-xs uppercase mb-1">Status</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium theme-bg-body theme-text-main border theme-border" x-text="activeVendor.status"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Address Section --}}
                        <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                            <h3 class="font-bold theme-text-main mb-4 flex items-center"><i class="fa-solid fa-map-marker-alt mr-2" style="color: rgb(var(--brand-primary));"></i> Address Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="col-span-2">
                                    <p class="text-xs theme-text-muted uppercase">Current Address</p>
                                    <p class="font-medium theme-text-main mt-1" x-text="activeVendor.address.current"></p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-xs theme-text-muted uppercase">Permanent Address</p>
                                    <p class="font-medium theme-text-main mt-1" x-text="activeVendor.address.permanent"></p>
                                </div>
                                <div>
                                    <p class="text-xs theme-text-muted uppercase">City / State</p>
                                    <p class="font-medium theme-text-main mt-1" x-text="activeVendor.address.city"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: WALLET --}}
                    <div x-show="currentTab === 'wallet'" class="space-y-6">
                        {{-- Balance Card --}}
                        <div class="rounded-2xl p-6 text-white shadow-lg" style="background: linear-gradient(135deg, rgb(var(--brand-primary)), rgb(var(--brand-secondary)));">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-white/80 text-xs font-bold uppercase tracking-wider">Total Balance</p>
                                    <h2 class="text-3xl font-bold mt-1" x-text="formatMoney(activeVendor.wallet.balance)"></h2>
                                </div>
                                <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                    <i class="fa-solid fa-wallet text-2xl"></i>
                                </div>
                            </div>
                            <div class="mt-6 flex gap-4">
                                <div class="bg-black/10 rounded-lg p-3 flex-1">
                                    <p class="text-xs text-white/80 mb-1">Pending</p>
                                    <p class="font-semibold" x-text="formatMoney(activeVendor.wallet.pending)"></p>
                                </div>
                                <div class="bg-black/10 rounded-lg p-3 flex-1">
                                    <p class="text-xs text-white/80 mb-1">Withdrawn</p>
                                    <p class="font-semibold" x-text="formatMoney(activeVendor.wallet.withdrawn)"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Transactions List --}}
                        <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                            <h3 class="font-bold theme-text-main mb-4">Recent Transactions</h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center border-b theme-border pb-3 last:border-0">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-green-500/10 text-green-500 flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-arrow-down"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium theme-text-main">Delivery Fee</p>
                                            <p class="text-xs theme-text-muted">Order #ORD-115</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-green-500">+PKR 350</span>
                                </div>
                                <div class="flex justify-between items-center border-b theme-border pb-3 last:border-0">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-red-500/10 text-red-500 flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-arrow-up"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium theme-text-main">Fuel Advance</p>
                                            <p class="text-xs theme-text-muted">Deduction</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold theme-text-main">-PKR 1,000</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: PAYMENT METHODS --}}
                    <div x-show="currentTab === 'payment-methods'" class="space-y-4">
                        <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                            <h3 class="font-bold theme-text-main mb-4">Linked Payment Methods</h3>
                            <div class="space-y-3">
                                <template x-if="activeVendor.payment_methods.length > 0">
                                    <template x-for="method in activeVendor.payment_methods">
                                        <div class="flex items-center p-3 border theme-border rounded-lg hover:bg-white/5 transition">
                                            <div class="h-10 w-10 bg-indigo-500/10 text-indigo-500 rounded-full flex items-center justify-center mr-3">
                                                <i class="fa-solid fa-credit-card"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium theme-text-main" x-text="method"></p>
                                                <p class="text-xs theme-text-muted">Verified</p>
                                            </div>
                                        </div>
                                    </template>
                                </template>
                                <template x-if="activeVendor.payment_methods.length === 0">
                                    <div class="text-center py-4 theme-text-muted italic">No payment methods linked.</div>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: KYC DOCUMENTS --}}
                    <div x-show="currentTab === 'documents'" class="space-y-4">
                        <div class="theme-bg-card p-6 rounded-xl shadow-sm border theme-border">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="font-bold theme-text-main">Submitted Compliance Docs</h3>
                                <span class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 text-xs font-bold px-2 py-1 rounded">Review Needed</span>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 theme-bg-card border theme-border rounded-lg hover:shadow-sm transition">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-10 w-10 bg-indigo-500/10 text-indigo-500 rounded-lg flex items-center justify-center text-lg"><i class="fa-solid fa-id-card"></i></div>
                                        <div>
                                            <p class="text-sm font-semibold theme-text-main">Driving License</p>
                                            <span class="text-[10px] theme-text-muted uppercase">PDF</span>
                                        </div>
                                    </div>
                                    <button class="px-3 py-1.5 theme-bg-body hover:bg-white/10 text-indigo-500 text-xs font-bold rounded transition">View</button>
                                </div>
                                <div class="flex items-center justify-between p-3 theme-bg-card border theme-border rounded-lg hover:shadow-sm transition">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-10 w-10 bg-indigo-500/10 text-indigo-500 rounded-lg flex items-center justify-center text-lg"><i class="fa-solid fa-passport"></i></div>
                                        <div>
                                            <p class="text-sm font-semibold theme-text-main">CNIC / ID Card</p>
                                            <span class="text-[10px] theme-text-muted uppercase">JPG</span>
                                        </div>
                                    </div>
                                    <button class="px-3 py-1.5 theme-bg-body hover:bg-white/10 text-indigo-500 text-xs font-bold rounded transition">View</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: ORDERS --}}
                    <div x-show="currentTab === 'orders'" class="space-y-4">
                         <div class="theme-bg-card p-10 rounded-xl border theme-border text-center">
                            <i class="fa-solid fa-route text-4xl theme-text-muted opacity-30 mb-3"></i>
                            <p class="theme-text-muted">Delivery history not available.</p>
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="p-4 theme-bg-card border-t theme-border flex justify-end gap-3 shrink-0">
                    <button class="px-5 py-2.5 rounded-lg border theme-border text-red-500 font-medium hover:bg-white/5 transition">Reject</button>
                    <button class="px-5 py-2.5 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 shadow-md transition">Approve</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. ADD RIDER MODAL --}}
    <div x-show="isAddVendorModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="fixed inset-0 bg-black/80 transition-opacity backdrop-blur-sm" @click="!isSubmitting && (isAddVendorModalOpen = false)"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative theme-bg-card rounded-2xl shadow-2xl max-w-2xl w-full transform transition-all border theme-border">

                <div class="p-6 border-b theme-border flex justify-between items-center">
                    <h3 class="text-xl font-bold theme-text-main"><i class="fa-solid fa-motorcycle mr-2" style="color: rgb(var(--brand-primary));"></i> Onboard New Rider</h3>
                    <button @click="isAddVendorModalOpen = false" :disabled="isSubmitting" class="theme-text-muted hover:text-white">
                        <i class="fa-solid fa-times text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('store.rider') }}" @submit.prevent="submitForm($event)">
                    @csrf
                    <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto" :class="isSubmitting ? 'opacity-50 pointer-events-none' : ''">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium theme-text-muted mb-1">Full Name</label>
                                <input type="text" name="name" required class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main placeholder-gray-500" placeholder="John Doe">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium theme-text-muted mb-1">Email Address</label>
                                <input type="email" name="email" required class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main placeholder-gray-500" placeholder="john@example.com">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium theme-text-muted mb-1">Phone Number</label>
                                <input type="text" name="phone" class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main placeholder-gray-500" placeholder="+92 300...">
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-medium theme-text-muted mb-1">Password</label>
                                <input type="password" name="password" required class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main" placeholder="Min 8 characters">
                            </div>

                            <div>
                                <label class="block text-sm font-medium theme-text-muted mb-1">City</label>
                                <input type="text" name="city" class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main" placeholder="Islamabad">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium theme-text-muted mb-1">Address</label>
                                <input type="text" name="address" class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main" placeholder="St 1, Sector G-10">
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t theme-border flex justify-end gap-3 theme-bg-body rounded-b-2xl">
                        <button type="button" @click="isAddVendorModalOpen = false" :disabled="isSubmitting" class="px-4 py-2 theme-bg-card border theme-border rounded-lg theme-text-main hover:bg-white/5 font-medium">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-white rounded-lg hover:opacity-90 font-medium flex items-center shadow-md disabled:opacity-50" 
                            style="background-color: rgb(var(--brand-primary));"
                            :disabled="isSubmitting">
                            <i x-show="isSubmitting" class="fa-solid fa-spinner fa-spin mr-2"></i>
                            <span x-text="isSubmitting ? 'Saving...' : 'Save Rider'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
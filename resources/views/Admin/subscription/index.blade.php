@extends('layouts.app')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Tab Navigation Styles */
        .tab-active {
            border-bottom: 2px solid #4f46e5;
            color: #4f46e5;
            font-weight: 600;
        }

        .tab-inactive {
            border-bottom: 2px solid transparent;
            color: #6b7280;
        }

        .tab-inactive:hover {
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }

        /* Module Selector Card Styles */
        .module-select-active {
            background-color: #eef2ff;
            border-color: #6366f1;
            color: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .module-select-inactive {
            background-color: #ffffff;
            border-color: #e5e7eb;
            color: #6b7280;
        }

        .module-select-inactive:hover {
            border-color: #cbd5e1;
            background-color: #f8fafc;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>

    <div class="min-h-screen bg-gray-50/50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if (isset($errors) && $errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Subscription Master</h2>
                    <p class="text-gray-500 text-sm mt-1">Manage plans for all active modules.</p>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Select Module to Manage</h3>

                {{-- 1. Yahan icons ki list define karein --}}
                @php
                    $icons = [
                        'fa-rocket',
                        'fa-users',
                        'fa-cogs',
                        'fa-chart-line',
                        'fa-shopping-cart',
                        'fa-envelope',
                        'fa-lock',
                        'fa-database',
                    ];
                @endphp

                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    @foreach ($apps as $index => $app)
                        {{-- 2. Icon select karein (Modulo operator use karein taake agar apps zyada hon to icons repeat hon) --}}
                        @php
                            $currentIcon = $icons[$index % count($icons)];
                        @endphp

                        <button onclick="selectModule('{{ $app->id }}', '{{ $app->name }}', '{{ $app->app_key }}')"
                            id="mod-btn-{{ $app->id }}"
                            class="{{ $index === 0 ? 'module-select-active' : 'module-select-inactive' }} flex flex-col items-center p-4 rounded-xl border-2 transition-all cursor-pointer mod-btn"
                            data-target="plan-list-{{ $app->id }}">
                            <div
                                class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-2">
                                {{-- 3. Dynamic Icon yahan lagayen --}}
                                <i class="fas {{ $currentIcon }}"></i>
                            </div>
                            <span class="font-bold text-sm">{{ $app->name }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in">

                {{-- Form Section --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden relative">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                            <h3 class="font-semibold text-gray-800">
                                <span id="form-title">Create New Plan</span> for <span id="form-module-name"
                                    class="text-indigo-600 font-bold">{{ $apps->first()->name ?? 'Module' }}</span>
                            </h3>
                            {{-- Cancel Edit Button (Hidden by default) --}}
                            <button id="cancel-edit-btn" onclick="resetForm()"
                                class="hidden text-xs text-red-500 hover:text-red-700 underline">
                                Cancel Edit
                            </button>
                        </div>

                        {{-- Form ID diya taake JS select kar sake --}}
                        <form id="plan-form" action="{{ route('subscriptions.store') }}" method="POST"
                            class="p-6 space-y-5">
                            @csrf
                            {{-- Hidden Method Field for PUT request --}}
                            <div id="method-field"></div>

                            <input type="hidden" name="app_id" id="input-app-id" value="{{ $apps->first()->id ?? '' }}">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Plan Name</label>
                                    <input type="text" id="input-name" name="name" required
                                        class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500"
                                        placeholder="e.g. Gold Package">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tier / Tagline</label>
                                    <input type="text" id="input-tier" name="tier" required
                                        class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500"
                                        placeholder="e.g. Recommended">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span></div>
                                        <input type="number" step="0.01" id="input-price" name="price" required
                                            class="w-full rounded-lg border-gray-300 border pl-7 pr-3 py-2 text-sm"
                                            placeholder="0.00">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Billing Cycle</label>
                                    <select id="input-billing" name="billing_cycle"
                                        class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm">
                                        <option value="monthly">Monthly</option>
                                        <option value="yearly">Yearly</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Plan Features</label>
                                <div class="bg-gray-50 p-4 rounded-lg border border-dashed border-gray-200 mb-3">
                                    <div id="features-list" class="space-y-3">
                                        {{-- Default Empty Row --}}
                                        <div class="feature-row flex gap-2 items-center">
                                            <input type="text" name="features[0][key]"
                                                class="w-1/2 rounded border-gray-300 text-sm py-2 px-3"
                                                placeholder="Key (e.g. max_jobs)">
                                            <input type="text" name="features[0][value]"
                                                class="w-1/2 rounded border-gray-300 text-sm py-2 px-3"
                                                placeholder="Value (e.g. 10)">
                                            <button type="button" onclick="removeRow(this)"
                                                class="text-gray-300 hover:text-red-500 p-2"><i
                                                    class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                    <button type="button" onclick="addFeatureRow()"
                                        class="mt-3 text-sm text-indigo-600 font-medium hover:underline">+ Add another
                                        feature</button>
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                <button type="button" onclick="resetForm()"
                                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Reset</button>
                                <button type="submit" id="submit-btn"
                                    class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm transition-colors">Save
                                    Plan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="flex justify-between items-end mb-4">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Live Plans</h3>
                    </div>

{{-- Is container ke andar dhundein --}}
<div id="live-plans-container" class="space-y-4">
    @foreach ($apps as $app)
        <div id="plan-list-{{ $app->id }}" class="app-plans-group {{ $loop->first ? '' : 'hidden' }}">

            @if ($app->plans->isEmpty())
                <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-200 mt-2">
                    <i class="fas fa-box-open text-gray-300 text-3xl mb-3"></i>
                    <p class="text-sm text-gray-500">No active plans for {{ $app->name }}.</p>
                </div>
            @else
                @foreach ($app->plans as $plan)
                    
                    {{-- Purana card yahan se start ho raha hoga, usy hata kar niche wala paste krdein --}}
                    <div class="bg-white p-5 mb-3 rounded-xl border border-gray-200 shadow-sm relative group hover:border-indigo-400 transition-all">
                        
                        {{-- 1. Action Buttons (Top Right) --}}
                        <div class="absolute top-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button onclick="editPlan({{ json_encode($plan) }}, {{ json_encode($plan->entitlements) }})" 
                                    class="h-8 w-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors" title="Edit">
                                <i class="fas fa-pencil-alt text-xs"></i>
                            </button>

                            <form action="{{ route('subscriptions.delete', $plan->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this plan?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="h-8 w-8 rounded-full bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition-colors" title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>

                        {{-- 2. Tier Badge --}}
                        <div class="absolute top-0 left-0 bg-indigo-50 text-indigo-600 text-[10px] font-bold px-3 py-1 rounded-br-lg rounded-tl-lg uppercase border-b border-r border-indigo-100">
                            {{ $plan->tier }}
                        </div>

                        <h4 class="font-bold text-gray-800 mt-4">{{ $plan->name }}</h4>
                        
                        <div class="text-2xl font-bold text-gray-900 my-2">
                            ${{ number_format($plan->price, 0) }}
                            <span class="text-sm text-gray-500 font-normal">/{{ $plan->billing_cycle }}</span>
                        </div>

                        @if ($plan->entitlements->count() > 0)
                            <div class="border-t border-gray-100 pt-2 mt-2">
                                <ul class="text-xs text-gray-500 space-y-1">
                                    @foreach ($plan->entitlements as $entitlement)
                                        <li class="flex justify-between">
                                            <span>{{ ucfirst(str_replace('_', ' ', $entitlement->feature_key)) }}</span>
                                            <span class="font-bold text-gray-700">{{ $entitlement->feature_value }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    {{-- Card end --}}

                @endforeach
            @endif
        </div>
    @endforeach
</div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        // --- MODULE SELECTION LOGIC ---
        function selectModule(appId, appName, appKey) {
            // 1. Update Buttons Visual
            document.querySelectorAll('.mod-btn').forEach(btn => {
                btn.classList.remove('module-select-active');
                btn.classList.add('module-select-inactive');
            });
            const activeBtn = document.getElementById('mod-btn-' + appId);
            activeBtn.classList.remove('module-select-inactive');
            activeBtn.classList.add('module-select-active');

            // 2. Update Form Data
            document.getElementById('form-module-name').innerText = appName;
            document.getElementById('input-app-id').value = appId;

            // 3. Show Relevant Plans List
            document.querySelectorAll('.app-plans-group').forEach(group => {
                group.classList.add('hidden');
            });
            document.getElementById('plan-list-' + appId).classList.remove('hidden');
        }

        // --- DYNAMIC FEATURES ROW ---
        let featureIndex = 1;

        function addFeatureRow() {
            const container = document.getElementById('features-list');
            const div = document.createElement('div');
            div.className = 'flex gap-2 items-center';
            div.innerHTML = `
            <input type="text" name="features[${featureIndex}][key]" class="w-1/2 rounded border-gray-300 text-sm py-2 px-3" placeholder="Key (e.g. max_jobs)">
            <input type="text" name="features[${featureIndex}][value]" class="w-1/2 rounded border-gray-300 text-sm py-2 px-3" placeholder="Value (e.g. 10)">
            <button type="button" onclick="removeRow(this)" class="text-red-500 hover:bg-red-50 p-2 rounded"><i class="fas fa-trash"></i></button>
        `;
            container.appendChild(div);
            featureIndex++;
        }

        function removeRow(btn) {
            btn.parentElement.remove();
        }
    </script> --}}

    <script>
    // --- MODULE SELECTION LOGIC ---
    function selectModule(appId, appName, appKey) {
        resetForm(); // Module change hone par form reset karein
        
        // Visual updates
        document.querySelectorAll('.mod-btn').forEach(btn => {
            btn.classList.remove('module-select-active');
            btn.classList.add('module-select-inactive');
        });
        document.getElementById('mod-btn-' + appId).classList.remove('module-select-inactive');
        document.getElementById('mod-btn-' + appId).classList.add('module-select-active');

        // Form updates
        document.getElementById('form-module-name').innerText = appName;
        document.getElementById('input-app-id').value = appId;

        // Show/Hide Lists
        document.querySelectorAll('.app-plans-group').forEach(group => group.classList.add('hidden'));
        const list = document.getElementById('plan-list-' + appId);
        if(list) list.classList.remove('hidden');
    }

    // --- EDIT PLAN LOGIC ---
    function editPlan(plan, entitlements) {
        // 1. Scroll to form
        document.getElementById('plan-form').scrollIntoView({ behavior: 'smooth' });

        // 2. Change Form to Edit Mode
        const form = document.getElementById('plan-form');
        form.action = `/subscriptions/update/${plan.id}`; // Update URL
        
        // Add Hidden Method PUT
        document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';

        // 3. Fill Values
        document.getElementById('form-title').innerText = "Edit Plan";
        document.getElementById('submit-btn').innerText = "Update Plan";
        document.getElementById('cancel-edit-btn').classList.remove('hidden');

        document.getElementById('input-name').value = plan.name;
        document.getElementById('input-tier').value = plan.tier;
        document.getElementById('input-price').value = plan.price;
        document.getElementById('input-billing').value = plan.billing_cycle;
        
        // Ensure app_id stays correct (though usually same module)
        document.getElementById('input-app-id').value = plan.app_id;

        // 4. Populate Features
        const container = document.getElementById('features-list');
        container.innerHTML = ''; // Clear existing
        
        entitlements.forEach((ent, index) => {
            addFeatureRow(ent.feature_key, ent.feature_value);
        });

        if(entitlements.length === 0) {
            addFeatureRow(); // Add one empty row if none exist
        }
    }

    // --- RESET FORM LOGIC ---
    function resetForm() {
        const form = document.getElementById('plan-form');
        form.reset();
        
        // Reset URL to Store
        form.action = "{{ route('subscriptions.store') }}";
        
        // Remove PUT method
        document.getElementById('method-field').innerHTML = '';
        
        // Reset UI
        document.getElementById('form-title').innerText = "Create New Plan";
        document.getElementById('submit-btn').innerText = "Save Plan";
        document.getElementById('cancel-edit-btn').classList.add('hidden');
        
        // Reset Features to 1 empty row
        document.getElementById('features-list').innerHTML = '';
        featureIndex = 0; // Reset index
        addFeatureRow();
        
        // Restore App ID (reset clears hidden fields too sometimes)
        // Note: Logic to keep current app_id active would be good here, 
        // but selectModule handles the main switch.
    }

    // --- DYNAMIC FEATURES ROW ---
    let featureIndex = 0;

    function addFeatureRow(key = '', value = '') {
        const container = document.getElementById('features-list');
        const div = document.createElement('div');
        div.className = 'feature-row flex gap-2 items-center';
        div.innerHTML = `
            <input type="text" name="features[${featureIndex}][key]" value="${key}" class="w-1/2 rounded border-gray-300 text-sm py-2 px-3" placeholder="Key (e.g. max_jobs)">
            <input type="text" name="features[${featureIndex}][value]" value="${value}" class="w-1/2 rounded border-gray-300 text-sm py-2 px-3" placeholder="Value (e.g. 10)">
            <button type="button" onclick="removeRow(this)" class="text-gray-400 hover:text-red-500 p-2 rounded"><i class="fas fa-trash"></i></button>
        `;
        container.appendChild(div);
        featureIndex++;
    }

    function removeRow(btn) {
        btn.parentElement.remove();
    }
</script>
@endsection

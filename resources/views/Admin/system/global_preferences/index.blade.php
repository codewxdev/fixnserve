@extends('layouts.app')

@section('content')
    <div class="w-full px-4 py-8 mx-auto theme-bg-body min-h-screen transition-colors duration-300">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold m-0 theme-text-main">Global Platform Preferences</h2>
                <p class="theme-text-muted mt-1">Manage core behavioral rules, branding, and global defaults.</p>
            </div>
            <div class="flex gap-3">
                <button type="button"
                    class="px-4 py-2 text-sm font-medium theme-bg-card theme-text-main border rounded-lg hover:opacity-80 transition-all shadow-sm">
                    Cancel
                </button>
                <button type="button" 
                    class="flex items-center px-5 py-2 text-sm font-medium text-white rounded-lg hover:opacity-90 transition-all shadow-md"
                    id="btnPublish" onclick="confirmPublish()" style="background-color: rgb(var(--brand-primary))">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.5 2a3.5 3.5 0 101.665 6.58L8.585 15H4a2 2 0 100 4h12a2 2 0 100-4h-4.585l1.42-6.42A3.5 3.5 0 1014.5 2h-9z"
                            clip-rule="evenodd" />
                    </svg>
                    Validate & Publish
                </button>
            </div>
        </div>

        <form id="preferencesForm">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">
                    <div class="theme-card theme-bg-card rounded-xl shadow-sm overflow-hidden overflow-hidden">
                        <div class="px-6 py-4 border-b theme-border">
                            <h5 class="text-lg font-bold flex items-center theme-text-main">
                                <span class="mr-2" style="color: rgb(var(--brand-primary))">🎨</span> Branding & Identity
                            </h5>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium mb-2 theme-text-main">Platform Name</label>
                                    <input type="text"
                                        class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none focus:ring-2 theme-text-main"
                                        style="--tw-ring-color: rgb(var(--brand-primary))" value="SahorOne Platform"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2 theme-text-main">Company Legal Name</label>
                                    <input type="text"
                                        class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none focus:ring-2 theme-text-main"
                                        style="--tw-ring-color: rgb(var(--brand-primary))" value="SahorOne Technologies LLC"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="theme-card theme-bg-card rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b theme-border">
                            <h5 class="text-lg font-bold flex items-center theme-text-main">
                                <span class="mr-2" style="color: rgb(var(--brand-primary))">🌍</span> Regional & Currency
                                Defaults
                            </h5>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @php $fields = ['Default Country', 'Default Timezone', 'Global Base Currency', 'Rounding Rules']; @endphp
                                @foreach ($fields as $field)
                                    <div>
                                        <label
                                            class="block text-sm font-medium mb-2 theme-text-main">{{ $field }}</label>
                                        <select
                                            class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none theme-text-main appearance-none">
                                            <option class="bg-slate-800">Option Value</option>
                                        </select>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="theme-card theme-bg-card rounded-xl shadow-sm overflow-hidden border-t-4"
                        style="border-top-color: rgb(var(--brand-secondary))">
                        <div class="px-6 py-4 border-b theme-border">
                            <h5 class="text-lg font-bold flex items-center theme-text-main">
                                <span class="mr-2">⚙️</span> Platform Master Switches
                            </h5>
                        </div>
                        <div class="p-6 space-y-6">
                            <label class="flex items-start cursor-pointer group">
                                <div class="relative flex-shrink-0 mt-1">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"
                                        style="--peer-checked-bg: rgb(var(--brand-primary))">
                                        <div
                                            class="absolute inset-0 rounded-full transition-colors peer-checked:bg-[rgb(var(--brand-primary))]">
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-bold block theme-text-main">Allow New User Onboarding</span>
                                    <span class="theme-text-muted">Disable to stop all new signups globally.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="theme-card theme-bg-card rounded-xl shadow-sm overflow-hidden border-t-4"
                        style="border-top-color: rgb(var(--brand-primary))">
                        <div class="px-6 py-4 border-b theme-border">
                            <h5 class="text-lg font-bold flex items-center theme-text-main">
                                <span class="mr-2">🛡️</span> Publishing & Audit
                            </h5>
                        </div>
                        <div class="p-6 space-y-4">
                            <label class="block text-sm font-bold theme-text-main">Reason for Change <span
                                    class="text-red-500">*</span></label>
                            <textarea class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none theme-text-main"
                                rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="validationModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto flex items-center justify-center p-4">
            <div class="theme-bg-card w-full max-w-lg rounded-xl shadow-2xl border theme-border transform transition-all">
                <div class="px-6 py-4 border-b theme-border flex justify-between items-center">
                    <h3 class="text-lg font-bold theme-text-main">Config Impact Analysis</h3>
                    <button onclick="closeModal()" class="theme-text-muted hover:theme-text-main">✕</button>
                </div>
                <div class="p-6">
                    <div class="p-4 rounded-md mb-4"
                        style="background-color: rgba(var(--brand-primary), 0.1); border-left: 4px solid rgb(var(--brand-primary))">
                        <p class="text-sm theme-text-main"><strong>System Impact:</strong> Changes will affect localization
                            caching.</p>
                    </div>
                    <p class="theme-text-muted">Are you sure you want to publish? Snapshot will be created.</p>
                </div>
                <div class="px-6 py-4 border-t theme-border flex justify-end gap-3 bg-black/5">
                    <button onclick="closeModal()" class="px-4 py-2 theme-text-main">Cancel</button>
                    <button id="confirmBtn" onclick="submitChanges()" class="px-4 py-2 text-white rounded-lg"
                        style="background-color: rgb(var(--brand-primary))">Confirm & Apply</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Pure JS Modal Handling (No Bootstrap JS required)
        const modal = document.getElementById('validationModal');

        function openModal() {
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        function confirmPublish() {
            const form = document.getElementById('preferencesForm');
            if (form.checkValidity()) {
                openModal();
            } else {
                form.reportValidity();
            }
        }

        function submitChanges() {
            const btn = document.getElementById('confirmBtn');
            // SVG Spinner replacing the text
            btn.innerHTML =
                `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Applying...`;
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');

            setTimeout(() => {
                alert('Settings Synced and Audit Log Created Successfully!');
                closeModal();
                window.location.reload();
            }, 1500);
        }
    </script>
@endpush

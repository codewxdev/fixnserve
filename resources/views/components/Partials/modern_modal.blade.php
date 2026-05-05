<div id="addRoleModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all scale-100 p-6 space-y-6">
        <div class="flex justify-between items-center">
            <h3 class="text-xl font-bold text-slate-900">New Role</h3>
            <button type="button" onclick="document.getElementById('addRoleModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="addRoleForm" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Role Name</label>
                <input type="text" id="role_name" required class="w-full px-4 py-3 rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-shadow placeholder-slate-400" placeholder="e.g. Marketing Manager">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('addRoleModal').classList.add('hidden')" class="px-5 py-2.5 rounded-xl text-slate-700 bg-slate-100 hover:bg-slate-200 font-medium transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 font-bold shadow-lg shadow-indigo-200 transition-all">Create Role</button>
            </div>
        </form>
    </div>
</div>
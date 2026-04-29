<div id="slide-over-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-70 z-40 hidden transition-opacity duration-300 ease-in-out"></div>
<div id="details-slide-over" class="slide-over-panel fixed top-0 right-0 h-full w-full sm:w-4/5 lg:w-3/5 xl:w-2/5 bg-white shadow-2xl z-50 overflow-y-auto">
    <div class="flex flex-col h-full">
        <div class="sticky top-0 bg-white p-6 border-b border-gray-200 flex justify-between items-center shadow-sm z-10">
            <h3 id="slide-over-title" class="text-xl font-bold text-gray-900 truncate">Provider Details</h3>
            <button id="slide-over-close" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-50 transition duration-150">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div id="slide-over-content" class="p-6 flex-grow space-y-6">
            <div class="text-center py-10 text-gray-500">
                Click a "View" button to load provider details.
            </div>
        </div>

        <div class="sticky bottom-0 bg-gray-50 p-4 border-t border-gray-200 flex justify-end space-x-3">
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg shadow-md hover:bg-red-700 transition duration-150">
                <i class="fas fa-ban mr-1"></i> Block Provider
            </button>
            <button class="px-4 py-2 border border-blue-500 text-blue-600 rounded-lg shadow-sm hover:bg-blue-50 transition duration-150">
                <i class="fas fa-history mr-1"></i> Full Audit History
            </button>
        </div>
    </div>
</div>
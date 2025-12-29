@extends('layouts.app')

@section('content')
    <section class="mb-10 pl-5 pr-5">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-slate-800">Key Performance Indicators</h3>
            <button class="text-sm text-indigo-600 font-medium hover:underline">View Full Report</button>
        </div>

       <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <div
        class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center gap-3 mb-4">
            <div
                class="p-2.5 rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            </div>
            <span class="text-sm font-semibold text-slate-500">Total Customers</span>
        </div>

        <h4 class="text-3xl font-bold text-slate-900">128,450</h4>

        <div class="flex items-center mt-2 gap-2">
            <span
                class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                +12.4%
            </span>
            <svg class="w-16 h-8 text-emerald-500 ml-auto opacity-70" viewBox="0 0 100 40" fill="none"
                stroke="currentColor" stroke-width="3">
                <path d="M0 35 Q 20 30, 40 20 T 100 5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </div>

    <div
        class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center gap-3 mb-4">
            <div
                class="p-2.5 rounded-xl bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
            </div>
            <span class="text-sm font-semibold text-slate-500">Home Service Providers</span>
        </div>

        <h4 class="text-3xl font-bold text-slate-900">4,320</h4>

        <div class="flex items-center mt-2 gap-2">
            <span
                class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                +9.1%
            </span>
            <svg class="w-16 h-8 text-purple-400 ml-auto opacity-70" viewBox="0 0 100 40" fill="none"
                stroke="currentColor" stroke-width="3">
                <path d="M0 30 Q 30 35, 60 15 T 100 10" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </div>

    <div
        class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center gap-3 mb-4">
            <div
                class="p-2.5 rounded-xl bg-cyan-50 text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
            <span class="text-sm font-semibold text-slate-500">Active Professionals</span>
        </div>

        <h4 class="text-3xl font-bold text-slate-900">2,180</h4>

        <div class="flex items-center mt-2 gap-2">
            <span
                class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                +7.6%
            </span>
            <svg class="w-16 h-8 text-cyan-400 ml-auto opacity-70" viewBox="0 0 100 40" fill="none"
                stroke="currentColor" stroke-width="3">
                <path d="M0 25 Q 25 35, 50 15 T 100 5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </div>

    <div
        class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center gap-3 mb-4">
            <div
                class="p-2.5 rounded-xl bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-5 h-5" viewBox="0 0 32 32" fill="currentColor">
                    <path
                        d="M26,10.75h-.209a1.86727,1.86727,0,0,0-.418.05078,9.41231,9.41231,0,0,0-18.74561.00012A1.86471,1.86471,0,0,0,6.209,10.75H6A3.7541,3.7541,0,0,0,2.25,14.5v1A3.7541,3.7541,0,0,0,6,19.25h.209A1.87643,1.87643,0,0,0,8.0835,17.376V11.6665a7.91675,7.91675,0,0,1,15.83349,0v4.667H22.419a9.14951,9.14951,0,0,0,.27734-2.19825C22.69629,9.78711,19.69238,6.25,16,6.25c-3.69189,0-6.6958,3.53711-6.6958,7.88525A8.43533,8.43533,0,0,0,11.97412,20.436L8.86621,21.4707a6.68324,6.68324,0,0,0-4.10058,3.86573L4.064,27.09082A1.93924,1.93924,0,0,0,5.86475,29.75h20.271a1.93873,1.93873,0,0,0,1.79981-2.65918l-.70117-1.75391a6.68153,6.68153,0,0,0-4.10059-3.86621L20.02637,20.436a7.69243,7.69243,0,0,0,1.87842-2.60254h2.07543A1.8728,1.8728,0,0,0,25.791,19.25H26a3.75442,3.75442,0,0,0,3.75-3.75v-1A3.75442,3.75442,0,0,0,26,10.75ZM6.5835,17.376a.37479.37479,0,0,1-.37452.374H6A2.25246,2.25246,0,0,1,3.75,15.5v-1A2.25246,2.25246,0,0,1,6,12.25h.209a.37479.37479,0,0,1,.37452.374v4.752Zm12.29931,2.064a1.3774,1.3774,0,0,0-.48437,1.3125,1.31474,1.31474,0,0,0,.89062,1.019l3.37012,1.12207a5.18575,5.18575,0,0,1,3.18262,3l.70117,1.75391a.43906.43906,0,0,1-.40723.60254H5.86475a.43921.43921,0,0,1-.40821-.602L6.1582,25.894a5.18808,5.18808,0,0,1,3.18213-3.00049l3.3711-1.12207a1.31582,1.31582,0,0,0,.89013-1.019,1.3774,1.3774,0,0,0-.48437-1.3125,6.86926,6.86926,0,0,1-2.313-5.30469c0-3.521,2.331-6.38525,5.1958-6.38525,2.86523,0,5.19629,2.86426,5.19629,6.38525a7.65733,7.65733,0,0,1-.32373,2.19825H17.51807a1.62388,1.62388,0,1,0,.62768,1.5h2.083A5.94062,5.94062,0,0,1,18.88281,19.43994ZM28.25,15.5A2.25278,2.25278,0,0,1,26,17.75h-.209a.37468.37468,0,0,1-.374-.374V12.624a.37468.37468,0,0,1,.374-.374H26a2.25278,2.25278,0,0,1,2.25,2.25Z">
                    </path>
                </svg>
            </div>
            <span class="text-sm font-semibold text-slate-500">Active Consultants</span>
        </div>

        <h4 class="text-3xl font-bold text-slate-900">1,060</h4>

        <div class="flex items-center mt-2 gap-2">
            <span
                class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                +6.2%
            </span>
            <svg class="w-16 h-8 text-amber-400 ml-auto opacity-70" viewBox="0 0 100 40" fill="none"
                stroke="currentColor" stroke-width="3">
                <path d="M0 35 Q 20 30, 40 20 T 100 5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </div>

    <div
        class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center gap-3 mb-4">
            <div
                class="p-2.5 rounded-xl bg-orange-50 text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
            <span class="text-sm font-semibold text-slate-500">Active Mart Vendors</span>
        </div>

        <h4 class="text-3xl font-bold text-slate-900">980</h4>

        <div class="flex items-center mt-2 gap-2">
            <span
                class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                +8.9%
            </span>
            <svg class="w-16 h-8 text-orange-400 ml-auto opacity-70" viewBox="0 0 100 40" fill="none"
                stroke="currentColor" stroke-width="3">
                <path d="M0 30 Q 30 35, 60 15 T 100 10" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </div>

    <div
        class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center gap-3 mb-4">
            <div
                class="p-2.5 rounded-xl bg-rose-50 text-rose-600 group-hover:bg-rose-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-5 h-5" viewBox="0 0 512.077 512.077" fill="currentColor">
                    <path
                        d="m235.245 69.459c-1.153-3.979-5.312-6.268-9.292-5.116-3.979 1.153-6.269 5.312-5.116 9.291 3.809 13.142 14.719 22.938 27.781 25.671.507 3.649 3.631 6.461 7.42 6.461s6.913-2.812 7.42-6.461c13.063-2.733 23.974-12.529 27.782-25.671 1.152-3.979-1.138-8.138-5.116-9.291-3.974-1.151-8.138 1.137-9.292 5.116-1.938 6.688-6.997 11.893-13.294 14.242v-21.393h2.852c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-2.852v-4.459c2.539-1.202 4.3-3.78 4.3-6.775 0-4.142-3.357-7.5-7.5-7.5h-8.599c-4.143 0-7.5 3.358-7.5 7.5 0 2.995 1.76 5.573 4.299 6.775v4.459h-2.851c-4.143 0-7.5 3.358-7.5 7.5s3.357 7.5 7.5 7.5h2.851v21.393c-6.297-2.349-11.355-7.555-13.293-14.242z">
                    </path>
                    <path
                        d="m411.096 348.524 2.312-5.983c2.888-7.478-.825-15.864-8.3-18.752l-52.701-20.366c-7.455-2.88-15.868.841-18.752 8.299l-1.575 4.076-30.05-11.638-.016-18.557c16.524-12.14 27.973-30.78 30.57-52.12 18.004-2.026 32.826-16.348 32.826-33.996 0-10.383-4.617-20.596-11.991-27.516 6.432-11.542 2.954-23.583-4.72-34.406v-8.099c23.761-11 36.88-24.692 39.01-40.743 2.232-16.827-7.921-34.624-29.363-51.465-3.259-2.558-7.973-1.992-10.531 1.266-2.559 3.257-1.991 7.972 1.266 10.531 16.797 13.191 25.234 26.579 23.759 37.695-1.246 9.392-9.77 18.393-24.817 26.331-2.231-6.58-9.376-10.188-16.02-8.019-.001 0-.001 0-.001 0-39.067 12.757-112.803 12.762-151.887 0-6.509-2.127-13.713 1.279-16.019 8.012-13.352-7.057-25.681-17.124-24.957-30.057.61-10.917 10.054-23.711 26.592-36.024 45.74-34.054 99.568-43.036 154.857-15.639 3.714 1.84 8.211.32 10.051-3.39 1.839-3.712.32-8.211-3.391-10.05-36.361-18.017-73.87-23.403-112.921-11.742-36.28 10.835-88.24 41.58-90.165 76.008-1.055 18.858 12.153 34.748 39.254 47.283v8.103c-7.824 11.034-11.219 23.29-4.457 34.883-7.458 6.95-12.253 17.124-12.253 27.04 0 17.622 14.786 31.965 32.818 33.995 2.537 21.057 13.65 39.776 30.52 52.036v18.55c-.937.476-.813.384-30.051 11.719l-1.571-4.066c-2.883-7.458-11.3-11.181-18.752-8.298l-52.701 20.365c-7.477 2.889-11.188 11.275-8.3 18.752l2.322 6.007c-14.918 10.971-23.96 28.736-23.96 47.792v98.848c0 9.312 7.576 16.887 16.888 16.887h324.241c9.312 0 16.888-7.576 16.888-16.887v-98.805c-.001-19.113-9.04-36.903-23.952-47.86zm-63.629-30.928 51.77 20.005c-.701 1.814-5.49 14.206-6.038 15.624l-51.77-20.005c.64-1.657.847-2.193 6.038-15.624zm-25.536 10.358-30.59 27.86c-.411.372-1.038.346-1.413-.066l-2.559-2.81s-.001 0-.001-.001l-11.917-13.084c-.337-.371-.366-1.018.065-1.413l21.927-19.97zm-56.513-.604c-1.303 1.187-2.483 2.726-3.235 4.082h-12.288c-.673-1.22-1.849-2.819-3.235-4.082l-21.886-19.934c.18-.934.271-1.906.271-2.908v-10.506c9.395 3.982 20.436 6.352 32.007 6.352 10.637 0 20.767-2.201 29.971-6.159l.009 10.375c.002.961.1 1.909.287 2.834zm77.895-144.332c4.32 4.109 7.097 10.318 7.097 16.47 0 9.282-8.016 16.82-17.244 18.741v-29.176c3.85-1.858 7.227-3.87 10.14-6.031.002-.001.005-.003.007-.004zm-164.897-62.771c41.734 12.499 113.433 12.535 155.283 0v14.923c-40.584 16.83-114.452 16.888-155.283 0 0-13.181 0-9.396 0-14.923zm.533 97.982c-9.356-1.947-17.243-9.566-17.243-18.742 0-5.831 2.994-12.026 7.513-16.155 2.818 2.044 6.064 3.951 9.73 5.72zm-7.745-54.754c-1.618-3.858-.812-8.576 2.392-14.068 43.204 17.552 118.875 18.42 164.924 0 6.856 11.752 2.222 18.912-10.39 25.37-13.919 7.099-34.57 10.887-50.018 12.767-39.869 4.851-99.386-6.143-106.908-24.069zm22.745 60.765v-29.423c37.76 11.605 84.904 12.083 124.217 0 0 35.003.013 28.635-.035 30.814-1.064 33.893-28.298 59.724-61.08 59.724-39.296-.001-63.102-30.906-63.102-61.115zm-29.339 93.356c1.388 3.592 4.648 12.029 6.038 15.624l-51.77 20.005c-.31-.803-5.728-14.82-6.038-15.624zm60.809 179.481h-76.214v-89.231c0-4.142-3.357-7.5-7.5-7.5s-7.5 3.358-7.5 7.5v89.231h-40.287c-1.041 0-1.888-.847-1.888-1.887v-98.848c0-13.066 5.647-25.306 15.132-33.547 3.961 5.042 10.749 6.883 16.657 4.602l52.701-20.365c2.588-1 4.963-2.796 6.626-5.164l27.488 25.035c5.156 4.695 12.735 5.438 18.617 2.127l5.438 7.167zm11.206-157.224c-.001.001-11.898 13.063-11.898 13.064l-2.578 2.831c-.37.408-.999.443-1.413.066l-30.6-27.87 23.343-9.05c.348-.135.728-.282 1.131-.446l21.95 19.992c.41.375.424 1.02.065 1.413zm11.09 10.101c.006-.007.011-.015.018-.021.894-.984 1.796-2.276 2.419-3.5h11.774c.623 1.224 1.525 2.516 2.419 3.5.006.007.011.015.018.021 5.858 6.431 4.327 4.751 7.716 8.472l-6.073 8.006h-19.896l-6.091-8.028zm172.332 145.235c0 1.041-.847 1.887-1.888 1.887h-40.287v-89.231c0-4.142-3.357-7.5-7.5-7.5s-7.5 3.358-7.5 7.5v89.231h-76.176l-3.137-40.896c-.317-4.129-3.93-7.218-8.052-6.904-4.13.317-7.222 3.921-6.904 8.052l3.048 39.749h-31.188l8.87-115.645h13.45l3.136 40.896c.318 4.13 3.949 7.225 8.052 6.904 4.13-.317 7.222-3.921 6.905-8.052l-3.45-44.984 5.425-7.152c5.896 3.297 13.454 2.537 18.591-2.141l27.496-25.042c1.549 2.205 3.858 4.102 6.618 5.17l52.702 20.366c5.946 2.295 12.731.415 16.674-4.623 9.475 8.234 15.115 20.495 15.115 33.61z">
                    </path>
                </svg>
            </div>
            <span class="text-sm font-semibold text-slate-500">Active Captains</span>
        </div>

        <h4 class="text-3xl font-bold text-slate-900">1,540</h4>

        <div class="flex items-center mt-2 gap-2">
            <span
                class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                +10.3%
            </span>
            <svg class="w-16 h-8 text-rose-400 ml-auto opacity-70" viewBox="0 0 100 40" fill="none"
                stroke="currentColor" stroke-width="3">
                <path d="M0 35 Q 25 35, 50 10 T 100 5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </div>

    <div
        class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center gap-3 mb-4">
            <div
                class="p-2.5 rounded-xl bg-teal-50 text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
            <span class="text-sm font-semibold text-slate-500">Total GMV</span>
        </div>

        <h4 class="text-3xl font-bold text-slate-900">$4.85M</h4>

        <div class="flex items-center mt-2 gap-2">
            <span
                class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                +15.8%
            </span>
            <svg class="w-16 h-8 text-teal-400 ml-auto opacity-70" viewBox="0 0 100 40" fill="none"
                stroke="currentColor" stroke-width="3">
                <path d="M0 35 Q 25 35, 50 10 T 100 5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </div>

    <div
        class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center gap-3 mb-4">
            <div
                class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                    </path>
                </svg>
            </div>
            <span class="text-sm font-semibold text-slate-500">Platform Revenue</span>
        </div>

        <h4 class="text-3xl font-bold text-slate-900">$612,000</h4>

        <div class="flex items-center mt-2 gap-2">
            <span
                class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                +18.2%
            </span>
            <svg class="w-16 h-8 text-indigo-400 ml-auto opacity-70" viewBox="0 0 100 40" fill="none"
                stroke="currentColor" stroke-width="3">
                <path d="M0 30 L 20 25 L 40 32 L 60 15 L 80 20 L 100 5" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>
    </div>

</div>
    </section>
    <section class="mb-10 pl-5 pr-5">
        <h3 class="text-2xl font-semibold text-slate-800 mb-5">Analytics & Trends</h3>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-2">Orders by Module</h4>
                <p class="text-sm text-slate-500 mb-4">Distribution of service and commerce activity by vertical.</p>
                <div id="orders-by-module-chart" class="h-80"></div>
            </div>
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-2">GMV Growth Trend</h4>
                <p class="text-sm text-slate-500 mb-4">Consistent month-over-month transaction growth (Last 6 Months).</p>
                <div id="gmv-growth-trend-chart" class="h-80"></div>
            </div>
        </div>

        <div class="mb-8">
            <h4 class="text-xl font-semibold text-slate-800 mb-4">Live Operations Snapshot</h4>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div
                    class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex flex-col items-center justify-center text-center">
                    <span class="text-3xl font-bold text-blue-600">1,280</span>
                    <span class="text-xs font-semibold text-slate-500 mt-1">Active Service Jobs</span>
                </div>
                <div
                    class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex flex-col items-center justify-center text-center">
                    <span class="text-3xl font-bold text-amber-500">460</span>
                    <span class="text-xs font-semibold text-slate-500 mt-1">Ongoing Consultations</span>
                </div>
                <div
                    class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex flex-col items-center justify-center text-center">
                    <span class="text-3xl font-bold text-rose-500">890</span>
                    <span class="text-xs font-semibold text-slate-500 mt-1">Active Deliveries</span>
                </div>
                <div
                    class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex flex-col items-center justify-center text-center">
                    <span class="text-3xl font-bold text-purple-600">74</span>
                    <span class="text-xs font-semibold text-slate-500 mt-1">Pending Approvals</span>
                </div>
                <div
                    class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex flex-col items-center justify-center text-center">
                    <span class="text-3xl font-bold text-red-500">39</span>
                    <span class="text-xs font-semibold text-slate-500 mt-1">Open Support Tickets</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Monthly Revenue Trends</h4>
                <div id="monthly-revenue-bar-chart" class="h-80"></div>
            </div>
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Service Coverage by Category</h4>
                <div id="provider-category-coverage-chart" class="h-80"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Yearly Growth Overview</h4>
                <div id="yearly-revenue-overview-chart" class="h-80"></div>
            </div>
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Revenue Per Service Category</h4>
                <div id="revenue-per-category-chart" class="h-80"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 mb-8">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Fleet Logistics Efficiency</h4>
                <div id="rider-delivery-performance-chart" class="h-80"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Successful vs Failed Deliveries</h4>
                <div id="successful-failed-deliveries-chart" class="h-80"></div>
            </div>
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Geospatial Demand Heatmap</h4>
                <div id="rider-activity-heatmap" class="h-80"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 mb-8">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Monthly Service Volume</h4>
                <div id="monthly-service-volume-chart" class="h-80"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Category Performance Comparison</h4>
                <div id="category-performance-comparison-chart" class="h-80"></div>
            </div>
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Job Status Distribution</h4>
                <div id="orders-status-chart" class="h-80"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Partner Onboarding Funnel</h4>
                <div id="provider-conversion-funnel-chart" class="h-80"></div>
            </div>
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Top Performing Partners</h4>
                <div id="top-providers-chart" class="h-80"></div>
            </div>
        </div>
    </section>

    <section class="mb-10 pl-5">
        <h3 class="text-2xl font-semibold text-slate-800 mb-5">Operational Activity & Queues</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xl font-semibold text-slate-800">Active Jobs (15)</h4>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View Dispatch</a>
                </div>
                <div class="h-96 overflow-y-auto space-y-3 pr-2">
                    <div class="border-b border-l-4 border-indigo-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2940 - HVAC Maintenance</p>
                        <p class="text-xs text-slate-500">Client: Metro Plaza HQ | Tech: John S.</p>
                        <span class="text-xs text-orange-500 font-semibold">En Route (Est. 15m)</span>
                    </div>
                    <div class="border-b border-l-4 border-indigo-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2941 - Emergency Plumbing</p>
                        <p class="text-xs text-slate-500">Client: Sunset Villas | Provider: ProFix Corp</p>
                        <span class="text-xs text-green-500 font-semibold">In Progress (08:15 AM)</span>
                    </div>
                    <div class="border-b border-l-4 border-indigo-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2942 - Sanitization Service</p>
                        <p class="text-xs text-slate-500">Client: Apex Gym | Rider: Pending</p>
                        <span class="text-xs text-blue-500 font-semibold">Assigning Partner...</span>
                    </div>
                    <div class="text-center pt-4 text-slate-400 text-sm">... 12 more active jobs ...</div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xl font-semibold text-slate-800">Pending Verification (45)</h4>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Review All</a>
                </div>
                <div class="h-96 overflow-y-auto space-y-3 pr-2">
                    <div class="border-b border-l-4 border-red-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Partner: Urban Electricians Ltd</p>
                        <p class="text-xs text-slate-500">Doc: Business License & Tax ID</p>
                        <span class="text-xs text-red-500 font-semibold">Action Required - 3 Days</span>
                    </div>
                    <div class="border-b border-l-4 border-yellow-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Rider: Alex Johnson (Fleet)</p>
                        <p class="text-xs text-slate-500">Doc: Background Check Report</p>
                        <span class="text-xs text-yellow-600 font-semibold">In Queue - 4 Hours</span>
                    </div>
                    <div class="border-b border-l-4 border-red-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Provider: ProFix Services</p>
                        <p class="text-xs text-slate-500">Doc: Liability Insurance</p>
                        <span class="text-xs text-red-500 font-semibold">Expired - Reupload</span>
                    </div>
                    <div class="text-center pt-4 text-slate-400 text-sm">... 42 more pending verifications ...</div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xl font-semibold text-slate-800">Payout Requests (12)</h4>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Process Batch</a>
                </div>
                <div class="h-96 overflow-y-auto space-y-3 pr-2">
                    <div class="border-b border-l-4 border-amber-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Vendor: GreenThumb Inc - **$500**</p>
                        <p class="text-xs text-slate-500">Ledger: $1,200 | Method: Direct Deposit</p>
                        <span class="text-xs text-amber-600 font-semibold">2 Days Pending</span>
                    </div>
                    <div class="border-b border-l-4 border-amber-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Rider: Michael A. - **$50**</p>
                        <p class="text-xs text-slate-500">Ledger: $80 | Method: Instant Pay</p>
                        <span class="text-xs text-amber-600 font-semibold">Requested Today</span>
                    </div>
                    <div class="text-center pt-4 text-slate-400 text-sm">... 10 more payouts pending ...</div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xl font-semibold text-slate-800">Dispute & Refunds (8)</h4>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Resolution Center</a>
                </div>
                <div class="h-96 overflow-y-auto space-y-3 pr-2">
                    <div class="border-b border-l-4 border-pink-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2930 - **$45.00**</p>
                        <p class="text-xs text-slate-500">Reason: Provider No-Show | Status: Pending</p>
                        <span class="text-xs text-pink-600 font-semibold">User: Sarah K.</span>
                    </div>
                    <div class="border-b border-l-4 border-pink-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2935 - **$100.00**</p>
                        <p class="text-xs text-slate-500">Reason: Damage Claim | Status: Investigation</p>
                        <span class="text-xs text-pink-600 font-semibold">Provider: ProFix Corp</span>
                    </div>
                    <div class="text-center pt-4 text-slate-400 text-sm">... 6 more open disputes ...</div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xl font-semibold text-slate-800">SLA Breaches (3)</h4>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Acknowledge All</a>
                </div>
                <div class="h-96 overflow-y-auto space-y-3 pr-2">
                    <div class="border-b border-l-4 border-red-600 pl-3 py-2">
                        <p class="text-sm text-red-600 font-medium truncate">**CRITICAL**: Order #ORD-2938</p>
                        <p class="text-xs text-slate-500">Issue: Max Dispatch Time Exceeded</p>
                        <span class="text-xs text-red-600 font-semibold">15 mins overdue</span>
                    </div>
                    <div class="border-b border-l-4 border-orange-500 pl-3 py-2">
                        <p class="text-sm text-orange-600 font-medium truncate">**HIGH**: Support Ticket #SR-120</p>
                        <p class="text-xs text-slate-500">Issue: Resolution Time Limit Near</p>
                        <span class="text-xs text-orange-600 font-semibold">Breach in 10 mins</span>
                    </div>
                    <div class="text-center pt-4 text-slate-400 text-sm">... 1 more SLA alert ...</div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xl font-semibold text-slate-800">Online Fleet (210)</h4>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Live Map</a>
                </div>
                <div class="h-96 overflow-y-auto space-y-3 pr-2">
                    <div class="border-b border-l-4 border-lime-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Rider: J. Smith (ID: R-001)</p>
                        <p class="text-xs text-slate-500">Ping: 10s ago | Zone: North Downtown</p>
                        <span class="text-xs text-green-600 font-semibold">Idle</span>
                    </div>
                    <div class="border-b border-l-4 border-lime-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Rider: K. Doe (ID: R-002)</p>
                        <p class="text-xs text-slate-500">Ping: 5m ago | Status: Delivering</p>
                        <span class="text-xs text-blue-600 font-semibold">Arriving at Order #2940</span>
                    </div>
                    <div class="text-center pt-4 text-slate-400 text-sm">... 208 more riders online ...</div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('charts/dashboard-charts.js') }}"></script>
@endpush

@push('styles')
    <style>
        #orders-status-chart {
            text-align: -webkit-center;
        }
    </style>
@endpush

@extends('layouts.app')

@section('head')
    {{-- Font Awesome CDN Link for Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<div class="space-y-6 px-4 sm:px-6 lg:px-8">
    <header class="flex items-center justify-between pt-4">
        <div class="flex flex-col">
            <nav class="flex" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-2 text-sm text-gray-500">
                    {{-- Icon: layout-dashboard -> fa-tachometer-alt --}}
                    <li><a href="#" class="hover:text-gray-700 flex items-center"><i class="fa-solid fa-tachometer-alt w-4 h-4 mr-1"></i> Dashboard</a></li>
                    <li class="text-gray-400">/</li>
                    {{-- Icon: user-check -> fa-user-check --}}
                    <li><span class="text-indigo-600 font-medium flex items-center"><i class="fa-solid fa-user-check w-4 h-4 mr-1"></i> Consultant Management</span></li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 mt-2">Consultant Management</h1>
            <p class="text-lg text-gray-500">Manage expert consultants, schedules, sessions, and recordings.</p>
        </div>
        <div>
            {{-- Icon: user-plus -> fa-user-plus --}}
            <button type="button" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-indigo-700 transition duration-150">
                <i class="fa-solid fa-user-plus w-4 h-4 mr-2"></i> Add Consultant
            </button>
        </div>
    </header>

    <section id="analytics-summary">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-8">
            @php
                $widgets = [
                    // Icon: users -> fa-users
                    ['title' => 'Total Consultants', 'value' => '1,450', 'icon' => 'users', 'color' => 'indigo'],
                    // Icon: user-check -> fa-user-check
                    ['title' => 'Active Consultants', 'value' => '980', 'icon' => 'user-check', 'color' => 'green'],
                    // Icon: calendar-check -> fa-calendar-check
                    ['title' => "Today's Consultations", 'value' => '45', 'icon' => 'calendar-check', 'color' => 'blue'],
                    // Icon: check-circle -> fa-check-circle
                    ['title' => 'Completed Sessions', 'value' => '12,400', 'icon' => 'check-circle', 'color' => 'teal'],
                    // Icon: clock -> fa-clock
                    ['title' => 'Hours Consulted This Week', 'value' => '245.5', 'icon' => 'clock', 'color' => 'cyan'],
                    // Icon: alert-triangle -> fa-exclamation-triangle
                    ['title' => 'No-show Cases', 'value' => '14', 'icon' => 'exclamation-triangle', 'color' => 'orange'],
                    // Icon: rotate-ccw -> fa-undo
                    ['title' => 'Pending Refunds', 'value' => '$1,200', 'icon' => 'undo', 'color' => 'red'],
                    // Icon: shield-check -> fa-shield-alt
                    ['title' => 'Verified Consultants', 'value' => '1,100', 'icon' => 'shield-alt', 'color' => 'purple'],
                ];
            @endphp
            @foreach ($widgets as $widget)
            <div class="bg-white p-5 rounded-xl shadow-lg border-t-4 border-{{ $widget['color'] }}-500 transition duration-300 hover:shadow-xl transform hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-500 truncate">{{ $widget['title'] }}</p>
                    {{-- Dynamic Icon Replacement: lucide:icon -> fa-solid:fa-icon --}}
                    <i class="fa-solid fa-{{ $widget['icon'] }} w-5 h-5 text-{{ $widget['color'] }}-500"></i>
                </div>
                <div class="mt-1">
                    <p class="text-2xl font-bold text-gray-900">{{ $widget['value'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    
    <section id="sticky-filters" class="sticky top-0 z-10 bg-white pt-4 -mt-4 shadow-sm rounded-lg">
        <div class="flex space-x-4 p-4 bg-white rounded-lg border border-gray-100 shadow-sm">
            <div class="relative flex-grow">
                {{-- Icon: search -> fa-search --}}
                <i class="fa-solid fa-search w-4 h-4 absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" placeholder="Search consultant (name, email)..." class="pl-10 pr-4 py-2 w-full rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 text-sm">
            </div>
            <select class="rounded-lg px-3 border border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option>All Expertise</option>
                <option>Finance</option>
                <option>Technology</option>
                <option>Health</option>
            </select>
            <select class="rounded-lg px-3 border border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option>All Ratings</option>
                <option>4.5+ Stars</option>
            </select>
            <button class="flex items-center rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 transition duration-150">
                {{-- Icon: clock -> fa-clock --}}
                <i class="fa-solid fa-clock w-4 h-4 mr-1"></i> Availability
            </button>
            <button class="flex items-center rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 transition duration-150">
                {{-- Icon: refresh-cw -> fa-sync-alt --}}
                <i class="fa-solid fa-sync-alt w-4 h-4"></i>
            </button>
        </div>
    </section>

    <section id="consultant-list">
        <div class="flow-root mt-6">
            <div class="rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="min-w-full">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky z-5">
                            <tr>
                                <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900">Basic Info</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Consultation Controls</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Performance</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Media/Recordings</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-6"><span class="">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach (range(1, 5) as $i)
                            <tr class="hover:bg-indigo-50/50 transition duration-150 cursor-pointer group" onclick="document.getElementById('consultant-detail-slideover').style.display='block'">
                                <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=Consultant+{{$i}}&background=random&color=fff" alt="">
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">Consultant Name {{$i}}</div>
                                            <div class="text-gray-500 text-xs mt-1">Expertise: **Financial Tech**</div>
                                            <div class="flex space-x-1 mt-1">
                                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800">FinTech</span>
                                                <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">Investments</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div class="space-y-1">
                                        {{-- Icon: calendar -> fa-calendar-alt --}}
                                        <div class="font-medium text-gray-900 flex items-center"><i class="fa-solid fa-calendar-alt w-4 h-4 mr-1 text-indigo-500"></i> Next: **2 hours**</div>
                                        <div class="text-gray-500">Rate: **$150/hr**</div>
                                        {{-- Icon: check -> fa-check --}}
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800"><i class="fa-solid fa-check w-3 h-3 mr-1"></i> Available</span>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div class="space-y-1">
                                        {{-- Icon: star -> fa-star --}}
                                        <div class="font-medium text-gray-900 flex items-center">
                                            <i class="fa-solid fa-star w-4 h-4 mr-1 text-yellow-400 fill-yellow-400"></i> **4.8** (120 reviews)
                                        </div>
                                        <div>Total Sessions: **340**</div>
                                        {{-- Icon: slash -> fa-slash --}}
                                        <div class="text-xs text-red-500 flex items-center"><i class="fa-solid fa-slash w-3 h-3 mr-1"></i> No-show: **3**</div>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div class="flex items-center space-x-3">
                                        {{-- Icon: video -> fa-video --}}
                                        <i class="fa-solid fa-video w-5 h-5 text-indigo-500 cursor-pointer hover:text-indigo-700 transition" title="Last Video Session"></i>
                                        {{-- Icon: mic -> fa-microphone --}}
                                        <i class="fa-solid fa-microphone w-5 h-5 text-gray-500 cursor-pointer hover:text-gray-700 transition" title="Last Audio Session"></i>
                                        {{-- Icon: cloud-download -> fa-cloud-download-alt --}}
                                        <i class="fa-solid fa-cloud-download-alt w-5 h-5 text-green-500 cursor-pointer hover:text-green-700 transition" title="Download Recent"></i>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <button class="text-indigo-600 hover:text-indigo-900 transition duration-150 p-2 rounded-full hover:bg-indigo-100" title="Manage Slots">
                                            {{-- Icon: calendar-plus -> fa-calendar-plus --}}
                                            <i class="fa-solid fa-calendar-plus w-5 h-5"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 transition duration-150 p-2 rounded-full hover:bg-red-100" title="Suspend Consultant">
                                            {{-- Icon: gavel -> fa-gavel --}}
                                            <i class="fa-solid fa-gavel w-5 h-5"></i>
                                        </button>
                                        <button class="text-gray-600 hover:text-gray-900 transition duration-150 p-2 rounded-full hover:bg-gray-100" title="Edit Consultant">
                                            {{-- Icon: settings -> fa-cog --}}
                                            <i class="fa-solid fa-cog w-5 h-5"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</div>

<div id="consultant-detail-slideover" class="relative z-20" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" style="display: none;">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeSlideOver()"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div class="pointer-events-auto w-screen max-w-2xl transform transition ease-in-out duration-500 sm:duration-700">
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                        
                        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-6 z-10">
                            <div class="flex items-start justify-between">
                                <h2 class="text-2xl font-bold text-gray-900" id="slide-over-title">Jane Doe - Consultant Profile</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500" onclick="closeSlideOver()">
                                        {{-- Icon: x -> fa-times --}}
                                        <i class="fa-solid fa-times h-6 w-6"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center space-x-2">
                                {{-- Icon: shield-check -> fa-shield-alt --}}
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-0.5 text-sm font-medium text-green-800"><i class="fa-solid fa-shield-alt w-4 h-4 mr-1"></i> **Verified**</span>
                                <span class="text-sm text-gray-500">ID: CNTR-7890</span>
                            </div>
                        </div>

                        <div class="relative flex-1 px-6 py-6">
                            <div class="space-y-8">
                                
                                <section>
                                    {{-- Icon: user -> fa-user --}}
                                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4 flex items-center"><i class="fa-solid fa-user w-5 h-5 mr-2 text-indigo-500"></i> Profile Overview</h3>
                                    <p class="text-sm text-gray-600 mb-4">"A senior FinTech consultant with 10+ years in wealth management and blockchain technology."</p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div><div class="text-sm font-medium text-gray-500">Category</div><div class="font-bold text-gray-900">Finance & Markets</div></div>
                                        <div><div class="text-sm font-medium text-gray-500">Rating</div><div class="font-bold text-gray-900 flex items-center">{{-- Icon: star -> fa-star --}}<i class="fa-solid fa-star w-4 h-4 mr-1 text-yellow-400 fill-yellow-400"></i> 4.8</div></div>
                                    </div>
                                    <div class="mt-4"></div>
                                </section>

                                <section>
                                    {{-- Icon: calendar -> fa-calendar-alt --}}
                                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4 flex items-center"><i class="fa-solid fa-calendar-alt w-5 h-5 mr-2 text-indigo-500"></i> Schedule Management</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Weekly Availability Calendar</p>
                                        <div class="text-xs text-gray-500">[Placeholder for a compact, color-coded availability grid]</div>
                                        <button class="mt-3 text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">{{-- Icon: plus -> fa-plus --}}<i class="fa-solid fa-plus w-4 h-4 mr-1"></i> Add/Edit Slots (Modal Trigger)</button>
                                    </div>
                                    {{-- Icon: alert-triangle -> fa-exclamation-triangle --}}
                                    <p class="text-xs text-orange-500 mt-2 flex items-center"><i class="fa-solid fa-exclamation-triangle w-4 h-4 mr-1"></i> **Warning:** Slot conflict detected on Tuesday, 3 PM.</p>
                                </section>
                                
                                <section>
                                    {{-- Icon: video -> fa-video --}}
                                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4 flex items-center"><i class="fa-solid fa-video w-5 h-5 mr-2 text-indigo-500"></i> Session Recordings</h3>
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg border">
                                            <div class="flex items-center space-x-3">
                                                {{-- Icon: film -> fa-film --}}
                                                <i class="fa-solid fa-film w-6 h-6 text-gray-500"></i>
                                                <span class="text-sm font-medium text-gray-800">2025-12-04 - FinTech Strategy (Video)</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                {{-- Icon: play-circle -> fa-play-circle --}}
                                                <button class="text-indigo-600 hover:text-indigo-800 text-sm"><i class="fa-solid fa-play-circle w-5 h-5"></i></button>
                                                {{-- Icon: download -> fa-download --}}
                                                <button class="text-green-600 hover:text-green-800 text-sm"><i class="fa-solid fa-download w-5 h-5"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <section>
                                    {{-- Icon: slash -> fa-slash --}}
                                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4 flex items-center"><i class="fa-solid fa-slash w-5 h-5 mr-2 text-orange-500"></i> No-Show & Refund Rules</h3>
                                    <div class="bg-yellow-50 p-4 rounded-lg mb-4">
                                        <p class="font-medium text-sm text-yellow-800">No-Show Log Timeline (Last 5)</p>
                                        <ul class="text-xs text-gray-600 mt-2 list-disc list-inside space-y-1">
                                            <li>2025-11-15: Client NS. Penalty Applied: $50.</li>
                                            <li>2025-10-01: Consultant NS. Refund Triggered.</li>
                                        </ul>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-white border rounded-lg shadow-sm">
                                        <div class="space-y-1">
                                            {{-- Icon: rotate-ccw -> fa-undo --}}
                                            <p class="font-medium text-gray-900 flex items-center"><i class="fa-solid fa-undo w-4 h-4 mr-2 text-red-600"></i> **Auto-Refund Rule**</p>
                                            <p class="text-xs text-gray-500">Trigger 50% refund if session duration < 10 mins.</p>
                                        </div>
                                        <label for="refund-toggle" class="relative inline-flex cursor-pointer items-center">
                                            <input type="checkbox" id="refund-toggle" class="sr-only peer" checked>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                        </label>
                                    </div>
                                </section>


                                <section>
                                    {{-- Icon: wallet -> fa-wallet --}}
                                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4 flex items-center"><i class="fa-solid fa-wallet w-5 h-5 mr-2 text-indigo-500"></i> Earnings & Wallet</h3>
                                    <div class="grid grid-cols-3 gap-4 text-center mb-4">
                                        <div class="bg-indigo-50 p-3 rounded-lg">Total Revenue: **$15,000**</div>
                                        <div class="bg-indigo-50 p-3 rounded-lg">Last Withdrawal: **$2,500**</div>
                                        <div class="bg-indigo-50 p-3 rounded-lg">Current Wallet: **$1,500**</div>
                                    </div>
                                    <p class="text-xs text-gray-500">[Placeholder for Session count vs. Earnings graph] </p>
                                </section>

                                <section>
                                    {{-- Icon: gavel -> fa-gavel --}}
                                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4 flex items-center"><i class="fa-solid fa-gavel w-5 h-5 mr-2 text-red-500"></i> Admin Tools</h3>
                                    <div class="space-y-3">
                                        {{-- Icon: ban -> fa-ban --}}
                                        <button class="w-full justify-center flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 transition"><i class="fa-solid fa-ban w-4 h-4 mr-2"></i> Suspend Consultant Account</button>
                                        {{-- Icon: lock -> fa-lock --}}
                                        <button class="w-full justify-center flex items-center rounded-md bg-yellow-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-400 transition"><i class="fa-solid fa-lock w-4 h-4 mr-2"></i> Require Re-verification (KYC)</button>
                                    </div>
                                </section>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Simple JavaScript function to toggle the slide-over panel visibility
    function closeSlideOver() {
        document.getElementById('consultant-detail-slideover').style.display = 'none';
    }
</script>
@endpush
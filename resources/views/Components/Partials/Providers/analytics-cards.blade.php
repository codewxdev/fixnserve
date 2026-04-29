
@php
    $stats = [
        ['title' => 'Total Providers', 'value' => '12,450', 'icon' => 'fas fa-users', 'color' => 'blue'],
        ['title' => 'Active Providers', 'value' => '9,870', 'icon' => 'fas fa-user-check', 'color' => 'green'],
        ['title' => 'Pending KYC', 'value' => '45', 'icon' => 'fas fa-hourglass-half', 'color' => 'yellow'],
        ['title' => 'Suspended', 'value' => '12', 'icon' => 'fas fa-gavel', 'color' => 'red'],
        ['title' => 'Online Now', 'value' => '3,100', 'icon' => 'fas fa-circle', 'color' => 'teal'],
        ['title' => "Today's Earnings", 'value' => '$45,120', 'icon' => 'fas fa-dollar-sign', 'color' => 'purple'],
    ];
@endphp
@foreach ($stats as $stat)
<div class="col-span-1">
    <div class="bg-white p-5 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition duration-200 ease-in-out transform hover:scale-[1.02]">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-500">{{ $stat['title'] }}</p>
            <i class="{{ $stat['icon'] }} text-2xl text-{{ $stat['color'] }}-500 opacity-70"></i>
        </div>
        <p class="text-xl font-bold text-gray-900 mt-1">{{ $stat['value'] }}</p>
    </div>
</div>
@endforeach

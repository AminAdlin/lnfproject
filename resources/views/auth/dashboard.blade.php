<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-blue-700 text-white px-6 py-4 flex justify-between items-center shadow">
        <h1 class="text-xl font-bold">🔍 UTM Lost & Found</h1>
        <div class="flex items-center gap-4">
            <span class="text-sm">Hello, {{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-white text-blue-700 text-sm px-3 py-1 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-8">

        {{-- Welcome Banner --}}
        <div class="bg-blue-600 text-white rounded-xl p-6 mb-8 shadow">
            <h2 class="text-2xl font-bold mb-1">Welcome back, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-sm text-blue-100">Stay updated on the latest lost and found activities at UTM.</p>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <a href="/report-lost" class="bg-white rounded-xl shadow p-6 flex items-center gap-4 hover:shadow-md transition">
                <div class="bg-red-100 text-red-600 rounded-full p-3 text-2xl">📋</div>
                <div>
                    <h3 class="font-semibold text-gray-800">Report Lost Item</h3>
                    <p class="text-sm text-gray-500">Submit a report for your lost item</p>
                </div>
            </a>
            <a href="/post-found" class="bg-white rounded-xl shadow p-6 flex items-center gap-4 hover:shadow-md transition">
                <div class="bg-green-100 text-green-600 rounded-full p-3 text-2xl">📦</div>
                <div>
                    <h3 class="font-semibold text-gray-800">Post Found Item</h3>
                    <p class="text-sm text-gray-500">Upload a found item to notify others</p>
                </div>
            </a>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow p-5 text-center">
                <p class="text-3xl font-bold text-blue-600">{{ $totalLost }}</p>
                <p class="text-sm text-gray-500 mt-1">Active Lost Reports</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5 text-center">
                <p class="text-3xl font-bold text-green-600">{{ $totalFound }}</p>
                <p class="text-sm text-gray-500 mt-1">Found Items Posted</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5 text-center">
                <p class="text-3xl font-bold text-yellow-500">{{ $totalClaimed }}</p>
                <p class="text-sm text-gray-500 mt-1">Items Claimed</p>
            </div>
        </div>

        {{-- Recent Activities --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">📢 Recent Activities</h3>

            @if($recentItems->count() > 0)
                <ul class="divide-y divide-gray-100">
                    @foreach($recentItems as $item)
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $item->title }}</p>
                                <p class="text-xs text-gray-400">{{ $item->location }} • {{ $item->created_at->diffForHumans() }}</p>
                            </div>
                            @if($item->type === 'lost')
                                <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full">Lost</span>
                            @else
                                <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded-full">Found</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-400 text-center py-6">No recent activities yet.</p>
            @endif
        </div>

    </div>

</body>
</html>
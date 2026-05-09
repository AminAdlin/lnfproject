<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - UTM FoundIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 50%, #b91c1c 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(127, 29, 29, 0.15);
        }
        .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- Navbar --}}
    <nav class="gradient-bg text-white px-8 py-4 flex justify-between items-center shadow-lg sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="bg-white rounded-full p-2 shadow">
                <span class="text-red-800 text-xl">🔍</span>
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-wide">UTM FoundIt</h1>
                <p class="text-red-200 text-xs">Lost & Found System</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="/notifications" class="glass rounded-full px-4 py-1.5 text-sm hover:bg-white hover:text-red-800 transition relative">
                🔔
                @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 bg-white text-red-800 text-xs font-bold rounded-full w-4 h-4 flex items-center justify-center">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
            <a href="/my-claims" class="glass rounded-full px-4 py-1.5 text-sm hover:bg-white hover:text-red-800 transition">
                🔐 My Claims
            </a>
            <div class="glass rounded-full px-4 py-1.5 text-sm">
                👤 {{ auth()->user()->name }}
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-white text-red-800 text-sm px-4 py-1.5 rounded-full font-semibold hover:bg-red-50 transition shadow">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-8">

        @if (session('status'))
            <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 p-4 rounded-2xl flex items-center gap-2">
                ✅ {{ session('status') }}
            </div>
        @endif

        {{-- Welcome Banner --}}
        <div class="gradient-bg text-white rounded-3xl p-8 mb-8 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-20 translate-x-20"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-5 rounded-full translate-y-10 -translate-x-10"></div>
            <div class="relative z-10">
                <p class="text-red-200 text-sm font-medium mb-1">{{ now()->format('l, d F Y') }}</p>
                <h2 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-red-200 text-sm">Stay updated on the latest lost and found activities at UTM.</p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
            <a href="/report-lost" class="card-hover bg-white rounded-2xl shadow p-6 flex items-center gap-5 border border-red-50">
                <div class="bg-gradient-to-br from-red-100 to-red-200 text-red-800 rounded-2xl p-4 text-3xl shadow-inner">
                    📋
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-lg">Report Lost Item</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Submit an announcement for your lost item</p>
                </div>
                <span class="text-red-300 text-2xl">→</span>
            </a>
            <a href="/post-found" class="card-hover bg-white rounded-2xl shadow p-6 flex items-center gap-5 border border-red-50">
                <div class="bg-gradient-to-br from-red-100 to-red-200 text-red-800 rounded-2xl p-4 text-3xl shadow-inner">
                    📦
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-lg">Post Found Item</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Upload details of an item you found</p>
                </div>
                <span class="text-red-300 text-2xl">→</span>
            </a>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="card-hover bg-white rounded-2xl shadow p-6 border border-red-50">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-red-100 rounded-xl p-3 text-2xl">🔴</div>
                    <span class="text-xs text-red-400 bg-red-50 px-2 py-1 rounded-full">Active</span>
                </div>
                <p class="text-4xl font-bold text-red-800 mb-1">{{ $totalLost }}</p>
                <p class="text-sm text-gray-500">Active Lost Reports</p>
            </div>
            <div class="card-hover bg-white rounded-2xl shadow p-6 border border-red-50">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-green-100 rounded-xl p-3 text-2xl">🟢</div>
                    <span class="text-xs text-green-500 bg-green-50 px-2 py-1 rounded-full">Posted</span>
                </div>
                <p class="text-4xl font-bold text-red-800 mb-1">{{ $totalFound }}</p>
                <p class="text-sm text-gray-500">Found Items Posted</p>
            </div>
            <div class="card-hover bg-white rounded-2xl shadow p-6 border border-red-50">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-yellow-100 rounded-xl p-3 text-2xl">✅</div>
                    <span class="text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">Resolved</span>
                </div>
                <p class="text-4xl font-bold text-red-800 mb-1">{{ $totalClaimed }}</p>
                <p class="text-sm text-gray-500">Items Claimed/Returned</p>
            </div>
        </div>

        {{-- Recent Activities --}}
        <div class="bg-white rounded-2xl shadow p-6 border border-red-50">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">📢 Recent Activities</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Latest lost and found updates</p>
                </div>
                <a href="/items" class="text-sm text-white bg-red-800 hover:bg-red-900 px-4 py-2 rounded-full transition font-medium">
                    View all →
                </a>
            </div>

            @if(isset($recentItems) && count($recentItems) > 0)
                <ul class="space-y-3">
                    @foreach($recentItems as $item)
                        <li class="flex justify-between items-center p-4 bg-gray-50 rounded-xl hover:bg-red-50 transition">
                            <div class="flex items-center gap-4">
                                <div class="text-2xl">
                                    {{ $item->type === 'lost' ? '📋' : '📦' }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $item->title }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">📍 {{ $item->location }} • 🕐 {{ $item->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @if($item->type === 'lost')
                                <span class="text-xs bg-red-100 text-red-800 px-3 py-1 rounded-full font-medium">Lost</span>
                            @else
                                <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium">Found</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center py-12">
                    <p class="text-5xl mb-3">📭</p>
                    <p class="text-gray-400 text-sm">No recent activities yet.</p>
                    <p class="text-gray-300 text-xs mt-1">Post a lost or found item to get started!</p>
                </div>
            @endif
        </div>

    </div>

</body>
</html>
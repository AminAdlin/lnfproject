
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Claims - UTM FoundIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg { background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 50%, #b91c1c 100%); }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(127, 29, 29, 0.15); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="gradient-bg text-white px-8 py-4 flex justify-between items-center shadow-lg sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <img src="/images/logo.png" alt="UTM FoundIt Logo" class="h-10 w-10 object-contain rounded-full bg-white p-1 shadow">
            <div>
                <h1 class="text-xl font-bold tracking-wide">UTM FoundIt</h1>
                <p class="text-red-200 text-xs">Lost & Found System</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="/items" class="glass rounded-full px-4 py-1.5 text-sm hover:bg-white hover:text-red-800 transition">📋 All Items</a>
            <a href="/dashboard" class="glass rounded-full px-4 py-1.5 text-sm hover:bg-white hover:text-red-800 transition">🏠 Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-white text-red-800 text-sm px-4 py-1.5 rounded-full font-semibold hover:bg-red-50 transition shadow">Logout</button>
            </form>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-8">

        {{-- Header Banner --}}
        <div class="gradient-bg text-white rounded-3xl p-8 mb-8 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-20 translate-x-20"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-5 rounded-full translate-y-10 -translate-x-10"></div>
            <div class="relative z-10">
                <h2 class="text-3xl font-bold mb-1">My Claims 🔐</h2>
                <p class="text-red-200 text-sm">Track all your item claim requests</p>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 p-4 rounded-2xl">✅ {{ session('status') }}</div>
        @endif

        @if($claims->count() > 0)
            <div class="space-y-4">
                @foreach($claims as $claim)
                    <div class="card-hover bg-white rounded-2xl shadow border border-red-50 p-5">
                        <div class="flex justify-between items-start">
                            <div class="flex gap-4">
                                <div class="bg-gradient-to-br from-red-100 to-red-200 text-red-800 rounded-2xl p-4 text-3xl shadow-inner">📦</div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg">{{ $claim->item->title }}</h3>
                                    <p class="text-xs text-gray-400 mt-0.5">📍 {{ $claim->item->location }}</p>
                                    <p class="text-xs text-gray-400">📅 Claimed {{ $claim->created_at->diffForHumans() }}</p>
                                    <p class="text-xs text-gray-400 mt-1">🚚 {{ $claim->delivery_method === 'self_pickup' ? 'Self Pickup' : 'Delivery' }}</p>
                                </div>
                            </div>
                            <div>
                                @if($claim->status === 'pending')
                                    <span class="text-xs bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full font-medium">⏳ Pending</span>
                                @elseif($claim->status === 'approved')
                                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium">✅ Approved</span>
                                @else
                                    <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full font-medium">❌ Rejected</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-24 bg-white rounded-2xl shadow border border-red-50">
                <p class="text-6xl mb-4">🔐</p>
                <p class="text-gray-500 font-medium text-lg">No claims yet</p>
                <p class="text-gray-300 text-sm mt-1 mb-6">Browse found items and submit a claim</p>
                <a href="/items" class="bg-red-800 hover:bg-red-900 text-white text-sm font-semibold py-2 px-6 rounded-xl transition">Browse Items</a>
            </div>
        @endif

    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Claims - UTM FoundIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background-color: #f1f1f1;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(127,29,29,0.04) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(153,27,27,0.04) 0%, transparent 50%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23991b1b' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .navbar-texture {
            background: linear-gradient(135deg, #6b1414 0%, #7f1d1d 30%, #991b1b 60%, #b91c1c 100%);
            box-shadow: 0 4px 20px rgba(127,29,29,0.4);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .banner-texture {
            background-image:
                url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E"),
                linear-gradient(135deg, #6b1414 0%, #7f1d1d 30%, #991b1b 60%, #b91c1c 100%);
        }
        .card-texture {
            background: white;
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23991b1b' fill-opacity='0.015' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(127,29,29,0.08);
        }
        .card-texture:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(127,29,29,0.15); border-color: rgba(127,29,29,0.15); }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.25); }
        .nav-pill { transition: all 0.2s ease; }
        .nav-pill:hover { background: white; color: #7f1d1d; transform: scale(1.05); }
        .claim-item { transition: all 0.2s ease; border: 1px solid transparent; }
        .claim-item:hover { background: linear-gradient(135deg, #fef2f2, #fff5f5); border-color: rgba(127,29,29,0.1); transform: translateX(4px); }
    </style>
</head>
<body class="min-h-screen">

    <nav class="navbar-texture text-white px-8 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="bg-white rounded-2xl p-1.5 shadow-lg">
                <img src="/images/logo.png" alt="UTM FoundIt Logo" class="h-9 w-9 object-contain">
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-wide">UTM FoundIt</h1>
                <p class="text-red-200 text-xs tracking-wider">LOST & FOUND SYSTEM</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="/items" class="nav-pill glass rounded-full px-4 py-2 text-sm flex items-center gap-1.5">📋 <span class="hidden md:inline">All Items</span></a>
            <a href="/dashboard" class="nav-pill glass rounded-full px-4 py-2 text-sm flex items-center gap-1.5">🏠 <span class="hidden md:inline">Dashboard</span></a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-white text-red-800 text-sm px-5 py-2 rounded-full font-bold hover:bg-red-50 transition shadow-lg">Logout</button>
            </form>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-8">

        {{-- Banner --}}
        <div class="banner-texture text-white rounded-3xl p-8 mb-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full -translate-y-40 translate-x-40"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full translate-y-20 -translate-x-20"></div>
            <div class="absolute top-4 left-1/2 w-2 h-2 bg-white opacity-20 rounded-full"></div>
            <div class="absolute bottom-8 right-1/3 w-2 h-2 bg-white opacity-20 rounded-full"></div>
            <div class="relative z-10">
                <p class="text-red-200 text-xs font-bold uppercase tracking-widest mb-2">Claim Management</p>
                <h2 class="text-3xl font-extrabold mb-1 drop-shadow-lg">My Claims 🔐</h2>
                <p class="text-red-200 text-sm">Track all your item claim requests</p>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 p-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <span class="text-xl">✅</span>
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        @endif

        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Your Claims</p>

        @if($claims->count() > 0)
            <div class="space-y-3">
                @foreach($claims as $claim)
                    <div class="claim-item card-texture rounded-2xl shadow-md p-5">
                        <div class="flex justify-between items-start">
                            <div class="flex gap-4">
                                <div class="bg-gradient-to-br from-red-100 to-red-200 text-red-800 rounded-2xl p-4 text-3xl shadow-inner flex-shrink-0">📦</div>
                                <div>
                                    <h3 class="font-extrabold text-gray-800 text-lg">{{ $claim->item->title }}</h3>
                                    <div class="flex items-center gap-3 mt-1 flex-wrap">
                                        <p class="text-xs text-gray-400">📍 {{ $claim->item->location }}</p>
                                        <span class="text-gray-200 text-xs">•</span>
                                        <p class="text-xs text-gray-400">📅 {{ $claim->created_at->diffForHumans() }}</p>
                                        <span class="text-gray-200 text-xs">•</span>
                                        <p class="text-xs text-gray-400">🚚 {{ $claim->delivery_method === 'self_pickup' ? 'Self Pickup' : 'Delivery' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                @if($claim->status === 'pending')
                                    <span class="text-xs bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-full font-bold border border-yellow-200 uppercase tracking-wider">⏳ Pending</span>
                                @elseif($claim->status === 'approved')
                                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1.5 rounded-full font-bold border border-green-200 uppercase tracking-wider">✅ Approved</span>
                                @else
                                    <span class="text-xs bg-red-100 text-red-700 px-3 py-1.5 rounded-full font-bold border border-red-200 uppercase tracking-wider">❌ Rejected</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-24 card-texture rounded-2xl shadow-md">
                <div class="w-20 h-20 bg-gradient-to-br from-red-50 to-red-100 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
                    <span class="text-4xl">🔐</span>
                </div>
                <p class="text-gray-600 font-bold text-lg">No claims yet</p>
                <p class="text-gray-400 text-sm mt-1 mb-6">Browse found items and submit a claim</p>
                <a href="/items" class="bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white text-sm font-bold py-2.5 px-6 rounded-xl transition shadow-md">
                    Browse Items
                </a>
            </div>
        @endif

    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Items - UTM FoundIt</title>
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
        .item-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid rgba(127,29,29,0.08); }
        .item-card:hover { transform: translateY(-6px); box-shadow: 0 25px 50px rgba(127,29,29,0.15); border-color: rgba(127,29,29,0.2); }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.25); }
        .nav-pill { transition: all 0.2s ease; }
        .nav-pill:hover { background: white; color: #7f1d1d; transform: scale(1.05); }
        .section-divider { height: 1px; background: linear-gradient(90deg, transparent, rgba(127,29,29,0.15), transparent); margin: 2rem 0; }
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
            <a href="/my-claims" class="nav-pill glass rounded-full px-4 py-2 text-sm flex items-center gap-1.5">🔐 <span class="hidden md:inline">My Claims</span></a>
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
            <div class="relative z-10 flex justify-between items-center">
                <div>
                    <p class="text-red-200 text-xs font-bold uppercase tracking-widest mb-2">Browse Items</p>
                    <h2 class="text-3xl font-extrabold mb-1 drop-shadow-lg">All Items 📋</h2>
                    <p class="text-red-200 text-sm">Browse all lost and found items at UTM</p>
                </div>
                <div class="flex gap-3">
                    <a href="/report-lost" class="glass rounded-2xl px-5 py-2.5 text-sm font-bold hover:bg-white hover:text-red-800 transition">+ Report Lost</a>
                    <a href="/post-found" class="bg-white text-red-800 rounded-2xl px-5 py-2.5 text-sm font-bold hover:bg-red-50 transition shadow-lg">+ Post Found</a>
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 p-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <span class="text-xl">✅</span>
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 text-sm text-red-700 bg-red-50 border border-red-200 p-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <span class="text-xl">❌</span>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Filter & Search --}}
        <div class="card-texture rounded-2xl shadow-md p-5 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-center">
                <div class="flex gap-1 bg-gray-100 rounded-xl p-1">
                    <a href="/items" class="px-5 py-2 rounded-lg text-sm font-bold transition {{ request('type') == null ? 'bg-gradient-to-r from-red-800 to-red-600 text-white shadow' : 'text-gray-500 hover:text-red-800' }}">All</a>
                    <a href="/items?type=lost" class="px-5 py-2 rounded-lg text-sm font-bold transition {{ request('type') == 'lost' ? 'bg-gradient-to-r from-red-800 to-red-600 text-white shadow' : 'text-gray-500 hover:text-red-800' }}">🔴 Lost</a>
                    <a href="/items?type=found" class="px-5 py-2 rounded-lg text-sm font-bold transition {{ request('type') == 'found' ? 'bg-gradient-to-r from-red-800 to-red-600 text-white shadow' : 'text-gray-500 hover:text-red-800' }}">🟢 Found</a>
                </div>
                <form method="GET" action="/items" class="flex-1 flex gap-2">
                    @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="🔎 Search by name, location, category..."
                        class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm font-medium" />
                    <button type="submit" class="bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white font-bold py-2.5 px-6 rounded-xl transition shadow-md text-sm">Search</button>
                </form>
            </div>
        </div>

        {{-- Items Grid --}}
        @if($items->count() > 0)
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">{{ $items->count() }} Items Found</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($items as $item)
                    <div class="item-card bg-white rounded-2xl overflow-hidden shadow-md"
                         style="background-image: url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23991b1b\' fill-opacity=\'0.015\' fill-rule=\'evenodd\'%3E%3Cpath d=\'M0 40L40 0H20L0 20M40 40V20L20 40\'/%3E%3C/g%3E%3C/svg%3E');">

                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover" />
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center text-5xl">
                                {{ $item->type === 'lost' ? '📋' : '📦' }}
                            </div>
                        @endif

                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-extrabold text-gray-800 text-lg leading-tight">{{ $item->title }}</h3>
                                @if($item->type === 'lost')
                                    <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full font-bold border border-red-200 ml-2 shrink-0 uppercase tracking-wider">Lost</span>
                                @else
                                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold border border-green-200 ml-2 shrink-0 uppercase tracking-wider">Found</span>
                                @endif
                            </div>

                            <div class="space-y-1.5 mb-4">
                                <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">📂</span> {{ $item->category }}</p>
                                <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">📍</span> {{ $item->location }}</p>
                                <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">📅</span> {{ $item->date_reported }}</p>
                                <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">📞</span> {{ $item->contact }}</p>
                                <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">👤</span> {{ $item->user->name }}</p>
                            </div>

                            <p class="text-sm text-gray-600 mb-4 leading-relaxed">{{ Str::limit($item->description, 80) }}</p>

                            {{-- I Found This --}}
                            @if($item->type === 'lost' && auth()->id() !== $item->user_id && $item->status === 'active')
                                <a href="/items/{{ $item->id }}/found-this"
                                    class="block w-full text-center bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white text-sm font-bold py-2.5 px-4 rounded-xl transition mb-2 shadow-md">
                                    🙋 I Found This!
                                </a>
                            @endif

                            {{-- Claim --}}
                            @if($item->type === 'found' && auth()->id() !== $item->user_id && $item->status === 'active')
                                <a href="/items/{{ $item->id }}/claim"
                                    class="block w-full text-center bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white text-sm font-bold py-2.5 px-4 rounded-xl transition mb-2 shadow-md">
                                    🔐 Claim This Item
                                </a>
                            @endif

                            {{-- Status --}}
                            @if($item->status === 'returned')
                                <div class="w-full text-center text-sm text-gray-400 py-2.5 bg-gray-50 rounded-xl border border-gray-100 mb-2 font-semibold">✅ Case Closed</div>
                            @elseif($item->status === 'claimed')
                                <div class="w-full text-center text-sm text-yellow-600 py-2.5 bg-yellow-50 rounded-xl border border-yellow-100 mb-2 font-semibold">⏳ Claimed — Pending Review</div>
                            @elseif($item->type === 'found' && auth()->id() === $item->user_id && $item->status === 'active')
                                <form method="POST" action="/items/{{ $item->id }}/returned">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Mark this item as returned? This will close the case.')"
                                        class="w-full bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white text-sm font-bold py-2.5 px-4 rounded-xl transition mb-2 shadow-md">
                                        ✅ Mark as Returned
                                    </button>
                                </form>
                            @endif

                            {{-- Delete --}}
                            @if(auth()->id() === $item->user_id)
                                <form method="POST" action="/items/{{ $item->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this post?')"
                                        class="w-full bg-gray-50 hover:bg-red-50 text-red-800 border border-gray-200 hover:border-red-200 text-sm font-bold py-2.5 px-4 rounded-xl transition mt-2">
                                        🗑️ Delete Post
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-24 card-texture rounded-2xl shadow-md">
                <div class="w-20 h-20 bg-gradient-to-br from-red-50 to-red-100 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
                    <span class="text-4xl">📭</span>
                </div>
                <p class="text-gray-600 font-bold text-lg">No items found</p>
                <p class="text-gray-400 text-sm mt-1 mb-6">Try a different search or post a new item</p>
                <div class="flex justify-center gap-3">
                    <a href="/report-lost" class="bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white text-sm font-bold py-2.5 px-6 rounded-xl transition shadow-md">+ Report Lost</a>
                    <a href="/post-found" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold py-2.5 px-6 rounded-xl transition border border-gray-200">+ Post Found</a>
                </div>
            </div>
        @endif

    </div>

</body>
</html>
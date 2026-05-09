<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Items - UTM FoundIt</title>
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
            <a href="/my-claims" class="glass rounded-full px-4 py-1.5 text-sm hover:bg-white hover:text-red-800 transition">
                🔐 My Claims
            </a>
            <a href="/dashboard" class="glass rounded-full px-4 py-1.5 text-sm hover:bg-white hover:text-red-800 transition">
                🏠 Dashboard
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-white text-red-800 text-sm px-4 py-1.5 rounded-full font-semibold hover:bg-red-50 transition shadow">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-8">

        {{-- Header --}}
        <div class="gradient-bg text-white rounded-3xl p-8 mb-8 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-20 translate-x-20"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-5 rounded-full translate-y-10 -translate-x-10"></div>
            <div class="relative z-10 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-1">All Items 📋</h2>
                    <p class="text-red-200 text-sm">Browse all lost and found items at UTM</p>
                </div>
                <div class="flex gap-3">
                    <a href="/report-lost" class="glass rounded-2xl px-5 py-2.5 text-sm font-semibold hover:bg-white hover:text-red-800 transition">
                        + Report Lost
                    </a>
                    <a href="/post-found" class="bg-white text-red-800 rounded-2xl px-5 py-2.5 text-sm font-semibold hover:bg-red-50 transition shadow">
                        + Post Found
                    </a>
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 p-4 rounded-2xl flex items-center gap-2">
                ✅ {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 text-sm text-red-700 bg-red-50 border border-red-200 p-4 rounded-2xl flex items-center gap-2">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- Filter & Search --}}
        <div class="bg-white rounded-2xl shadow p-5 mb-8 border border-red-50">
            <div class="flex flex-col md:flex-row gap-4 items-center">
                <div class="flex gap-2 bg-gray-100 rounded-xl p-1">
                    <a href="/items"
                        class="px-5 py-2 rounded-lg text-sm font-semibold transition {{ request('type') == null ? 'bg-red-800 text-white shadow' : 'text-gray-500 hover:text-red-800' }}">
                        All
                    </a>
                    <a href="/items?type=lost"
                        class="px-5 py-2 rounded-lg text-sm font-semibold transition {{ request('type') == 'lost' ? 'bg-red-800 text-white shadow' : 'text-gray-500 hover:text-red-800' }}">
                        🔴 Lost
                    </a>
                    <a href="/items?type=found"
                        class="px-5 py-2 rounded-lg text-sm font-semibold transition {{ request('type') == 'found' ? 'bg-red-800 text-white shadow' : 'text-gray-500 hover:text-red-800' }}">
                        🟢 Found
                    </a>
                </div>

                <form method="GET" action="/items" class="flex-1 flex gap-2">
                    @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="🔎 Search by name, location, category..."
                        class="flex-1 px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm" />
                    <button type="submit"
                        class="bg-red-800 hover:bg-red-900 text-white font-semibold py-2 px-5 rounded-xl transition text-sm">
                        Search
                    </button>
                </form>
            </div>
        </div>

        {{-- Items Grid --}}
        @if($items->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($items as $item)
                    <div class="card-hover bg-white rounded-2xl shadow border border-red-50 overflow-hidden">

                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}"
                                alt="{{ $item->title }}"
                                class="w-full h-48 object-cover" />
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center text-5xl">
                                {{ $item->type === 'lost' ? '📋' : '📦' }}
                            </div>
                        @endif

                        <div class="p-5">

                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold text-gray-800 text-lg leading-tight">{{ $item->title }}</h3>
                                @if($item->type === 'lost')
                                    <span class="text-xs bg-red-100 text-red-800 px-3 py-1 rounded-full font-medium ml-2 shrink-0">Lost</span>
                                @else
                                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium ml-2 shrink-0">Found</span>
                                @endif
                            </div>

                            <div class="space-y-1.5 mb-4">
                                <p class="text-xs text-gray-500 flex items-center gap-1.5">
                                    <span class="bg-gray-100 rounded px-1.5 py-0.5">📂</span> {{ $item->category }}
                                </p>
                                <p class="text-xs text-gray-500 flex items-center gap-1.5">
                                    <span class="bg-gray-100 rounded px-1.5 py-0.5">📍</span> {{ $item->location }}
                                </p>
                                <p class="text-xs text-gray-500 flex items-center gap-1.5">
                                    <span class="bg-gray-100 rounded px-1.5 py-0.5">📅</span> {{ $item->date_reported }}
                                </p>
                                <p class="text-xs text-gray-500 flex items-center gap-1.5">
                                    <span class="bg-gray-100 rounded px-1.5 py-0.5">📞</span> {{ $item->contact }}
                                </p>
                                <p class="text-xs text-gray-500 flex items-center gap-1.5">
                                    <span class="bg-gray-100 rounded px-1.5 py-0.5">👤</span> {{ $item->user->name }}
                                </p>
                            </div>

                            <p class="text-sm text-gray-600 mb-4 leading-relaxed">{{ Str::limit($item->description, 80) }}</p>

                            {{-- I Found This button --}}
                            @if($item->type === 'lost' && auth()->id() !== $item->user_id && $item->status === 'active')
                                <a href="/items/{{ $item->id }}/found-this"
                                    class="block w-full text-center bg-red-800 hover:bg-red-900 text-white text-sm font-semibold py-2.5 px-4 rounded-xl transition mb-2">
                                    🙋 I Found This!
                                </a>
                            @endif

                            {{-- Claim button --}}
                            @if($item->type === 'found' && auth()->id() !== $item->user_id && $item->status === 'active')
                                <a href="/items/{{ $item->id }}/claim"
                                    class="block w-full text-center bg-red-800 hover:bg-red-900 text-white text-sm font-semibold py-2.5 px-4 rounded-xl transition mb-2">
                                    🔐 Claim This Item
                                </a>
                            @endif

                            {{-- Status --}}
                            @if($item->status === 'returned')
                                <div class="w-full text-center text-sm text-gray-400 py-2.5 bg-gray-50 rounded-xl border border-gray-100 mb-2">
                                    ✅ Case Closed
                                </div>
                            @elseif($item->status === 'claimed')
                                <div class="w-full text-center text-sm text-yellow-600 py-2.5 bg-yellow-50 rounded-xl border border-yellow-100 mb-2">
                                    ⏳ Claimed — Pending Review
                                </div>
                            @elseif($item->type === 'found' && auth()->id() === $item->user_id && $item->status === 'active')
                                <form method="POST" action="/items/{{ $item->id }}/returned">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Mark this item as returned? This will close the case.')"
                                        class="w-full bg-red-800 hover:bg-red-900 text-white text-sm font-semibold py-2.5 px-4 rounded-xl transition mb-2">
                                        ✅ Mark as Returned
                                    </button>
                                </form>
                            @endif

                            {{-- Delete button --}}
                            @if(auth()->id() === $item->user_id && $item->status !== 'returned')
                                <form method="POST" action="/items/{{ $item->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this post?')"
                                        class="w-full bg-gray-50 hover:bg-red-50 text-red-800 border border-gray-200 hover:border-red-200 text-sm font-semibold py-2.5 px-4 rounded-xl transition mt-2">
                                        🗑️ Delete Post
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-24 bg-white rounded-2xl shadow border border-red-50">
                <p class="text-6xl mb-4">📭</p>
                <p class="text-gray-500 font-medium text-lg">No items found</p>
                <p class="text-gray-300 text-sm mt-1 mb-6">Try a different search or post a new item</p>
                <div class="flex justify-center gap-3">
                    <a href="/report-lost" class="bg-red-800 hover:bg-red-900 text-white text-sm font-semibold py-2 px-6 rounded-xl transition">
                        + Report Lost
                    </a>
                    <a href="/post-found" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold py-2 px-6 rounded-xl transition">
                        + Post Found
                    </a>
                </div>
            </div>
        @endif

    </div>

</body>
</html>
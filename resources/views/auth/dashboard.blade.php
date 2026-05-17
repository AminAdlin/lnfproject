<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - UTM FoundIt</title>
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

        .gradient-bg {
            background: linear-gradient(135deg, #6b1414 0%, #7f1d1d 30%, #991b1b 60%, #b91c1c 100%);
        }

        .navbar-texture {
            background: linear-gradient(135deg, #6b1414 0%, #7f1d1d 30%, #991b1b 60%, #b91c1c 100%);
            box-shadow: 0 4px 20px rgba(127,29,29,0.4);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .card-texture {
            background: white;
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23991b1b' fill-opacity='0.015' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(127,29,29,0.08);
        }

        .card-texture:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(127,29,29,0.12);
            border-color: rgba(127,29,29,0.15);
        }

        .banner-texture {
            background: linear-gradient(135deg, #6b1414 0%, #7f1d1d 30%, #991b1b 60%, #b91c1c 100%);
            background-image:
                url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E"),
                linear-gradient(135deg, #6b1414 0%, #7f1d1d 30%, #991b1b 60%, #b91c1c 100%);
        }

        .glass {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.25);
        }

        .glass-dark {
            background: rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .stat-card {
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            opacity: 0.06;
        }

        .stat-card-red::before { background: #991b1b; }
        .stat-card-green::before { background: #166534; }
        .stat-card-yellow::before { background: #854d0e; }

        .activity-item {
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .activity-item:hover {
            background: linear-gradient(135deg, #fef2f2, #fff5f5);
            border-color: rgba(127,29,29,0.1);
            transform: translateX(4px);
        }

        .nav-pill {
            transition: all 0.2s ease;
        }

        .nav-pill:hover {
            background: white;
            color: #7f1d1d;
            transform: scale(1.05);
        }

        .quick-action {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .quick-action::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(127,29,29,0.05), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .quick-action:hover::after { opacity: 1; }
        .quick-action:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(127,29,29,0.12); }

        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(127,29,29,0.15), transparent);
            margin: 1.5rem 0;
        }

        /* Mobile navbar: tighter spacing */
        @media (max-width: 640px) {
            .navbar-inner { padding: 0.6rem 1rem; }
            .brand-title { font-size: 1rem; }
            .brand-sub { display: none; }
        }
    </style>
</head>
<body class="min-h-screen">

    {{-- Navbar --}}
    <nav class="navbar-texture text-white sticky top-0 z-50">
        <div class="navbar-inner flex justify-between items-center px-4 sm:px-8 py-3 sm:py-4">
            {{-- Logo + Brand --}}
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="bg-white rounded-xl sm:rounded-2xl p-1 sm:p-1.5 shadow-lg flex-shrink-0">
                    <img src="/images/logo.png" alt="UTM FoundIt Logo" class="h-7 w-7 sm:h-9 sm:w-9 object-contain">
                </div>
                <div>
                    <h1 class="brand-title text-base sm:text-xl font-bold tracking-wide leading-tight">UTM FoundIt</h1>
                    <p class="brand-sub text-red-200 text-xs tracking-wider hidden sm:block">LOST & FOUND SYSTEM</p>
                </div>
            </div>

            {{-- Nav Actions --}}
            <div class="flex items-center gap-1.5 sm:gap-3">
                {{-- Notifications --}}
                <a href="/notifications" class="nav-pill glass rounded-full px-2.5 sm:px-4 py-1.5 sm:py-2 text-sm relative flex items-center gap-1">
                    🔔
                    @if($unreadCount > 0)
                        <span class="absolute -top-1 -right-1 bg-yellow-400 text-gray-900 text-xs font-bold rounded-full w-4 h-4 sm:w-5 sm:h-5 flex items-center justify-center shadow text-[10px]">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>

                {{-- My Claims --}}
                <a href="/my-claims" class="nav-pill glass rounded-full px-2.5 sm:px-4 py-1.5 sm:py-2 text-sm flex items-center gap-1.5">
                    🔐 <span class="hidden sm:inline text-xs sm:text-sm">My Claims</span>
                </a>

                {{-- Profile --}}
                <a href="/profile" class="nav-pill glass rounded-full px-2 sm:px-3 py-1.5 sm:py-2 text-sm flex items-center gap-1.5">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                            class="w-5 h-5 sm:w-6 sm:h-6 rounded-full object-cover border-2 border-white" />
                    @else
                        <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-white bg-opacity-30 flex items-center justify-center text-xs">👤</div>
                    @endif
                    <span class="hidden sm:inline font-medium text-xs sm:text-sm">{{ auth()->user()->name }}</span>
                </a>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-white text-red-800 text-xs sm:text-sm px-3 sm:px-5 py-1.5 sm:py-2 rounded-full font-bold hover:bg-red-50 transition shadow-lg">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-5 sm:py-8">

        @if (session('status'))
            <div class="mb-5 text-sm text-green-700 bg-green-50 border border-green-200 p-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <span class="text-xl">✅</span>
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        @endif

        {{-- Welcome Banner --}}
        <div class="banner-texture text-white rounded-2xl sm:rounded-3xl p-5 sm:p-8 mb-6 sm:mb-8 shadow-2xl relative overflow-hidden">
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                {{-- Left: Avatar + Greeting --}}
                <div class="flex items-center gap-4">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                            class="w-14 h-14 sm:w-20 sm:h-20 rounded-2xl object-cover border-4 border-white border-opacity-40 shadow-2xl flex-shrink-0" />
                    @else
                        <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-2xl bg-white bg-opacity-15 flex items-center justify-center text-2xl sm:text-3xl border-4 border-white border-opacity-20 shadow-2xl backdrop-blur-sm flex-shrink-0">
                            👤
                        </div>
                    @endif
                    <div>
                        <p class="text-red-200 text-xs font-bold uppercase tracking-widest mb-1">{{ now()->format('l, d F Y') }}</p>
                        <h2 class="text-xl sm:text-3xl font-extrabold mb-1 drop-shadow-lg leading-tight">
                            Welcome back, {{ auth()->user()->name }}! 👋
                        </h2>
                        <p class="text-red-200 text-xs sm:text-sm">Stay updated on the latest lost and found activities at UTM.</p>
                    </div>
                </div>

                {{-- Right: Total Posts pill — visible on all screens --}}
                <div class="glass-dark rounded-2xl px-5 py-3 text-center self-start sm:self-auto">
                    <p class="text-2xl sm:text-3xl font-extrabold">{{ \App\Models\Item::count() }}</p>
                    <p class="text-red-200 text-xs font-semibold uppercase tracking-wider mt-0.5">Total Posts</p>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Quick Actions</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 sm:mb-8">
            <a href="/report-lost" class="quick-action card-texture rounded-2xl shadow-md p-4 sm:p-6 flex items-center gap-4 sm:gap-5">
                <div class="bg-gradient-to-br from-red-100 to-red-200 text-red-800 rounded-2xl p-3 sm:p-4 text-2xl sm:text-3xl shadow-inner flex-shrink-0">📋</div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-gray-800 text-base sm:text-lg">Report Lost Item</h3>
                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Submit an announcement for your lost item</p>
                </div>
                <span class="text-red-300 text-xl sm:text-2xl flex-shrink-0">→</span>
            </a>
            <a href="/post-found" class="quick-action card-texture rounded-2xl shadow-md p-4 sm:p-6 flex items-center gap-4 sm:gap-5">
                <div class="bg-gradient-to-br from-red-100 to-red-200 text-red-800 rounded-2xl p-3 sm:p-4 text-2xl sm:text-3xl shadow-inner flex-shrink-0">📦</div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-gray-800 text-base sm:text-lg">Post Found Item</h3>
                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Upload details of an item you found</p>
                </div>
                <span class="text-red-300 text-xl sm:text-2xl flex-shrink-0">→</span>
            </a>
        </div>

        <div class="section-divider"></div>

        {{-- Summary Cards --}}
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Overview</p>
        {{-- 2 columns on mobile, 3 on md+ --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 sm:gap-5 mb-6 sm:mb-8">

            <div class="card-texture stat-card stat-card-red rounded-2xl shadow-md p-4 sm:p-6">
                <div class="flex items-center justify-between mb-3 sm:mb-5">
                    <div class="bg-gradient-to-br from-red-100 to-red-200 rounded-xl p-2 sm:p-3 text-xl sm:text-2xl shadow-inner">🔴</div>
                    <span class="text-xs text-red-500 bg-red-50 px-2 sm:px-3 py-1 rounded-full font-bold border border-red-100 uppercase tracking-wider hidden sm:inline">Active</span>
                </div>
                <p class="text-3xl sm:text-5xl font-extrabold text-red-800 mb-1">{{ $totalLost }}</p>
                <p class="text-xs sm:text-sm text-gray-500 font-semibold leading-tight">Active Lost Reports</p>
                <div class="mt-3 sm:mt-4 h-1.5 bg-red-100 rounded-full overflow-hidden">
                    <div class="h-1.5 bg-gradient-to-r from-red-400 to-red-600 rounded-full"
                        style="width: {{ $totalLost > 0 ? min(100, $totalLost * 10) : 5 }}%"></div>
                </div>
            </div>

            <div class="card-texture stat-card stat-card-green rounded-2xl shadow-md p-4 sm:p-6">
                <div class="flex items-center justify-between mb-3 sm:mb-5">
                    <div class="bg-gradient-to-br from-green-100 to-green-200 rounded-xl p-2 sm:p-3 text-xl sm:text-2xl shadow-inner">🟢</div>
                    <span class="text-xs text-green-600 bg-green-50 px-2 sm:px-3 py-1 rounded-full font-bold border border-green-100 uppercase tracking-wider hidden sm:inline">Posted</span>
                </div>
                <p class="text-3xl sm:text-5xl font-extrabold text-red-800 mb-1">{{ $totalFound }}</p>
                <p class="text-xs sm:text-sm text-gray-500 font-semibold leading-tight">Found Items Posted</p>
                <div class="mt-3 sm:mt-4 h-1.5 bg-green-100 rounded-full overflow-hidden">
                    <div class="h-1.5 bg-gradient-to-r from-green-400 to-green-600 rounded-full"
                        style="width: {{ $totalFound > 0 ? min(100, $totalFound * 10) : 5 }}%"></div>
                </div>
            </div>

            {{-- 3rd card: spans full width on mobile so it doesn't look orphaned --}}
            <div class="card-texture stat-card stat-card-yellow rounded-2xl shadow-md p-4 sm:p-6 col-span-2 md:col-span-1">
                <div class="flex items-center justify-between mb-3 sm:mb-5">
                    <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl p-2 sm:p-3 text-xl sm:text-2xl shadow-inner">✅</div>
                    <span class="text-xs text-yellow-600 bg-yellow-50 px-2 sm:px-3 py-1 rounded-full font-bold border border-yellow-100 uppercase tracking-wider hidden sm:inline">Resolved</span>
                </div>
                <p class="text-3xl sm:text-5xl font-extrabold text-red-800 mb-1">{{ $totalClaimed }}</p>
                <p class="text-xs sm:text-sm text-gray-500 font-semibold leading-tight">Items Claimed/Returned</p>
                <div class="mt-3 sm:mt-4 h-1.5 bg-yellow-100 rounded-full overflow-hidden">
                    <div class="h-1.5 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-full"
                        style="width: {{ $totalClaimed > 0 ? min(100, $totalClaimed * 10) : 5 }}%"></div>
                </div>
            </div>

        </div>

        <div class="section-divider"></div>

        {{-- Recent Activities --}}
        <div class="card-texture rounded-2xl shadow-md p-4 sm:p-6">
            <div class="flex justify-between items-center mb-4 sm:mb-6">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Latest Updates</p>
                    <h3 class="text-lg sm:text-xl font-extrabold text-gray-800">📢 Recent Activities</h3>
                </div>
                <a href="/items" class="flex items-center gap-1.5 text-xs sm:text-sm text-white bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 px-3 sm:px-5 py-2 sm:py-2.5 rounded-full transition font-bold shadow-lg hover:shadow-xl whitespace-nowrap">
                    View all →
                </a>
            </div>

            @if(isset($recentItems) && count($recentItems) > 0)
                <div class="space-y-2">
                    @foreach($recentItems as $item)
                        <div class="activity-item flex justify-between items-center p-3 sm:p-4 rounded-2xl gap-3">
                            <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl {{ $item->type === 'lost' ? 'bg-gradient-to-br from-red-100 to-red-200' : 'bg-gradient-to-br from-green-100 to-green-200' }} flex items-center justify-center text-xl sm:text-2xl flex-shrink-0 shadow-inner">
                                    {{ $item->type === 'lost' ? '📋' : '📦' }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-gray-800 truncate">{{ $item->title }}</p>
                                    <div class="flex flex-wrap items-center gap-x-2 gap-y-0.5 mt-0.5">
                                        <p class="text-xs text-gray-400">📍 {{ $item->location }}</p>
                                        <p class="text-xs text-gray-400">🕐 {{ $item->created_at->diffForHumans() }}</p>
                                        <p class="text-xs text-gray-400 hidden sm:block">👤 {{ $item->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                            @if($item->type === 'lost')
                                <span class="text-xs bg-red-100 text-red-700 px-2 sm:px-3 py-1 sm:py-1.5 rounded-full font-bold border border-red-200 flex-shrink-0 uppercase tracking-wider">Lost</span>
                            @else
                                <span class="text-xs bg-green-100 text-green-700 px-2 sm:px-3 py-1 sm:py-1.5 rounded-full font-bold border border-green-200 flex-shrink-0 uppercase tracking-wider">Found</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 sm:py-16">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-red-50 to-red-100 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
                        <span class="text-3xl sm:text-4xl">📭</span>
                    </div>
                    <p class="text-gray-600 font-bold text-base sm:text-lg">No recent activities yet</p>
                    <p class="text-gray-400 text-sm mt-1 mb-5">Post a lost or found item to get started!</p>
                    <div class="flex justify-center gap-3">
                        <a href="/report-lost" class="bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white text-sm font-bold py-2.5 px-5 rounded-xl transition shadow-md">
                            + Report Lost
                        </a>
                        <a href="/post-found" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold py-2.5 px-5 rounded-xl transition border border-gray-200">
                            + Post Found
                        </a>
                    </div>
                </div>
            @endif
        </div>

    </div>

</body>
</html>

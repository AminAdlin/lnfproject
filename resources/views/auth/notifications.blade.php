<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - UTM FoundIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background-color: #f1f1f1;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(127,29,29,0.04) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(153,27,27,0.04) 0%, transparent 50%);
        }
        .navbar-texture {
            background: linear-gradient(135deg, #6b1414 0%, #7f1d1d 30%, #991b1b 60%, #b91c1c 100%);
            box-shadow: 0 4px 20px rgba(127,29,29,0.4);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .banner-texture {
            background: linear-gradient(135deg, #6b1414 0%, #7f1d1d 30%, #991b1b 60%, #b91c1c 100%);
        }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.25); }
        .nav-pill { transition: all 0.2s ease; }
        .nav-pill:hover { background: white; color: #7f1d1d; transform: scale(1.05); }
        .notification-card {
            transition: all 0.2s ease;
        }
        .notification-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(127,29,29,0.1);
        }
    </style>
</head>
<body class="min-h-screen">

    {{-- Navbar --}}
    <nav class="navbar-texture text-white sticky top-0 z-50">
        <div class="flex justify-between items-center px-4 sm:px-8 py-3 sm:py-4">
            {{-- Brand --}}
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="bg-white rounded-xl sm:rounded-2xl p-1 sm:p-1.5 shadow-lg flex-shrink-0">
                    <img src="/images/logo.png" alt="UTM FoundIt Logo" class="h-7 w-7 sm:h-9 sm:w-9 object-contain">
                </div>
                <div>
                    <h1 class="text-base sm:text-xl font-bold tracking-wide leading-tight">UTM FoundIt</h1>
                    <p class="text-red-200 text-xs tracking-wider hidden sm:block">LOST & FOUND SYSTEM</p>
                </div>
            </div>

            {{-- Nav Actions --}}
            <div class="flex items-center gap-1.5 sm:gap-4">
                <a href="/items" class="nav-pill glass rounded-full px-2.5 sm:px-4 py-1.5 sm:py-2 text-sm flex items-center gap-1.5">
                    📋 <span class="hidden sm:inline text-xs sm:text-sm">All Items</span>
                </a>
                <a href="/dashboard" class="nav-pill glass rounded-full px-2.5 sm:px-4 py-1.5 sm:py-2 text-sm flex items-center gap-1.5">
                    🏠 <span class="hidden sm:inline text-xs sm:text-sm">Dashboard</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-white text-red-800 text-xs sm:text-sm px-3 sm:px-5 py-1.5 sm:py-2 rounded-full font-bold hover:bg-red-50 transition shadow-lg">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-5 sm:py-8">

        {{-- Banner --}}
        <div class="banner-texture text-white rounded-2xl sm:rounded-3xl p-5 sm:p-8 mb-6 sm:mb-8 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-20 translate-x-20"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-5 rounded-full translate-y-10 -translate-x-10"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h2 class="text-xl sm:text-3xl font-bold mb-1">Notifications 🔔</h2>
                    <p class="text-red-200 text-xs sm:text-sm">People who think they found your lost items</p>
                </div>
                @if($notifications->count() > 0)
                    <div class="glass rounded-2xl px-4 py-2 text-center flex-shrink-0">
                        <p class="text-xl sm:text-2xl font-extrabold">{{ $notifications->count() }}</p>
                        <p class="text-red-200 text-xs font-semibold uppercase tracking-wider">Total</p>
                    </div>
                @endif
            </div>
        </div>

        @if($notifications->count() > 0)
            <div class="space-y-3 sm:space-y-4">
                @foreach($notifications as $notification)
                    <div class="notification-card bg-white rounded-2xl shadow border {{ $notification->is_read ? 'border-gray-100' : 'border-red-200' }} p-4 sm:p-5">

                        {{-- Header --}}
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                                <div class="text-xl sm:text-2xl flex-shrink-0">🙋</div>
                                <div class="min-w-0">
                                    <p class="font-bold text-gray-800 text-sm sm:text-base truncate">{{ $notification->sender->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @if(!$notification->is_read)
                                <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full font-medium flex-shrink-0 ml-2">New</span>
                            @endif
                        </div>

                        {{-- Message --}}
                        <div class="bg-red-50 rounded-xl p-3 mb-3">
                            <p class="text-xs text-red-800 font-semibold mb-1 truncate">About: {{ $notification->item->title }}</p>
                            <p class="text-xs sm:text-sm text-gray-700 leading-relaxed">{{ $notification->message }}</p>
                        </div>

                        {{-- Contact --}}
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500">📞 Contact:</span>
                            <span class="text-xs font-semibold text-red-800 break-all">{{ $notification->contact }}</span>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 sm:py-24 bg-white rounded-2xl shadow border border-red-50">
                <p class="text-5xl sm:text-6xl mb-4">🔔</p>
                <p class="text-gray-500 font-bold text-base sm:text-lg">No notifications yet</p>
                <p class="text-gray-400 text-xs sm:text-sm mt-1 px-6">When someone finds your lost item they will notify you here</p>
            </div>
        @endif

    </div>

</body>
</html>
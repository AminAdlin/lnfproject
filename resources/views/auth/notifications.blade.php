<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - UTM FoundIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 50%, #b91c1c 100%);
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
            <a href="/items" class="glass rounded-full px-4 py-1.5 text-sm hover:bg-white hover:text-red-800 transition">
                📋 All Items
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

    <div class="max-w-4xl mx-auto px-6 py-8">

        <div class="gradient-bg text-white rounded-3xl p-8 mb-8 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-20 translate-x-20"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-5 rounded-full translate-y-10 -translate-x-10"></div>
            <div class="relative z-10">
                <h2 class="text-3xl font-bold mb-1">Notifications 🔔</h2>
                <p class="text-red-200 text-sm">People who think they found your lost items</p>
            </div>
        </div>

        @if($notifications->count() > 0)
            <div class="space-y-4">
                @foreach($notifications as $notification)
                    <div class="bg-white rounded-2xl shadow border {{ $notification->is_read ? 'border-gray-100' : 'border-red-200' }} p-5">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-3">
                                <div class="text-2xl">🙋</div>
                                <div>
                                    <p class="font-bold text-gray-800">{{ $notification->sender->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @if(!$notification->is_read)
                                <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full font-medium">New</span>
                            @endif
                        </div>

                        <div class="bg-red-50 rounded-xl p-3 mb-3">
                            <p class="text-xs text-red-800 font-medium mb-1">About: {{ $notification->item->title }}</p>
                            <p class="text-sm text-gray-700">{{ $notification->message }}</p>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500">📞 Contact:</span>
                            <span class="text-xs font-semibold text-red-800">{{ $notification->contact }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-24 bg-white rounded-2xl shadow border border-red-50">
                <p class="text-6xl mb-4">🔔</p>
                <p class="text-gray-500 font-medium text-lg">No notifications yet</p>
                <p class="text-gray-300 text-sm mt-1">When someone finds your lost item they will notify you here</p>
            </div>
        @endif

    </div>

</body>
</html>
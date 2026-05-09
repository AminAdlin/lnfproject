<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I Found This - UTM FoundIt</title>
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

    <div class="max-w-2xl mx-auto px-6 py-8">

        {{-- Item Details --}}
        <div class="bg-white rounded-2xl shadow border border-red-50 overflow-hidden mb-6">
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}"
                    alt="{{ $item->title }}"
                    class="w-full h-48 object-cover" />
            @else
                <div class="w-full h-48 bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center text-5xl">
                    📋
                </div>
            @endif

            <div class="p-5">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-bold text-gray-800 text-xl">{{ $item->title }}</h3>
                    <span class="text-xs bg-red-100 text-red-800 px-3 py-1 rounded-full font-medium">Lost</span>
                </div>
                <div class="space-y-1.5">
                    <p class="text-xs text-gray-500">📂 {{ $item->category }}</p>
                    <p class="text-xs text-gray-500">📍 {{ $item->location }}</p>
                    <p class="text-xs text-gray-500">📅 {{ $item->date_reported }}</p>
                    <p class="text-xs text-gray-500">👤 Posted by {{ $item->user->name }}</p>
                </div>
            </div>
        </div>

        {{-- Found This Form --}}
        <div class="bg-white rounded-2xl shadow border border-red-50 p-6">

            <h2 class="text-xl font-bold text-red-800 mb-1">🙋 I Found This!</h2>
            <p class="text-sm text-gray-500 mb-6">Send a message to the owner to let them know you found their item</p>

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 p-4 rounded-2xl">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="/items/{{ $item->id }}/found-this">
                @csrf

                {{-- Message --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Message to Owner</label>
                    <textarea name="message" rows="4"
                        placeholder="e.g. I found your item near the library. It matches your description..."
                        required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm">{{ old('message') }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Max 500 characters</p>
                </div>

                {{-- Contact --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Your Contact Info</label>
                    <input type="text" name="contact" value="{{ old('contact') }}"
                        placeholder="e.g. 01X-XXXXXXX or email"
                        required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm" />
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-red-800 hover:bg-red-900 text-white font-semibold py-3 px-4 rounded-xl transition">
                        Send Notification
                    </button>
                    <a href="/items"
                        class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-xl transition">
                        Cancel
                    </a>
                </div>

            </form>
        </div>

    </div>

</body>
</html>
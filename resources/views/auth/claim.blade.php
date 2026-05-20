<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Item - UTM FoundIt</title>
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
    <nav class="navbar-texture text-white sticky top-0 z-50">
        <div class="navbar-inner flex justify-between items-center px-4 sm:px-8 py-3 sm:py-4">
            
    {{-- Logo + Brand --}}
    <div class="flex items-center gap-3 sm:gap-4">
    <div class="bg-white rounded-xl sm:rounded-2xl p-1 sm:p-1.5 shadow-lg flex-shrink-0">
    <img src="{{ asset('images/logo_utmfoundit_crop.png') }}" alt="UTM FoundIt Logo" class="h-9 w-9 sm:h-12 sm:w-12 object-contain">
    </div>
    <div>
        <h1 class="brand-title text-lg sm:text-2xl font-bold tracking-wide leading-tight">UTM FoundIt</h1>
        <p class="brand-sub text-red-200 text-xs tracking-wider hidden sm:block">LOST & FOUND SYSTEM</p>
    </div>
    </div>
        <div class="flex items-center gap-4">
            <a href="/items" class="glass rounded-full px-4 py-1.5 text-sm hover:bg-white hover:text-red-800 transition">
                📋 All Items
            </a>
            <a href="/dashboard" class="glass rounded-full px-4 py-1.5 text-sm hover:bg-white hover:text-red-800 transition">
                🏠 Dashboard
            </a>
            {{-- Logout --}}
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                    @csrf
                </form>
                <button type="button" onclick="confirmLogout()" class="bg-white text-red-800 text-xs sm:text-sm px-3 sm:px-5 py-1.5 sm:py-2 rounded-full font-bold hover:bg-red-50 transition shadow-lg flex items-center gap-1.5">
                    <span>🚪</span>
                    <span>Logout</span>
                </button>

                <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto px-6 py-8">

        {{-- Item Details Card --}}
        <div class="bg-white rounded-2xl shadow border border-red-50 overflow-hidden mb-6">
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}"
                    alt="{{ $item->title }}"
                    class="w-full h-48 object-cover" />
            @else
                <div class="w-full h-48 bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center text-5xl">
                    📦
                </div>
            @endif

            <div class="p-5">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-bold text-gray-800 text-xl">{{ $item->title }}</h3>
                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium">Found</span>
                </div>
                <div class="space-y-1.5">
                    <p class="text-xs text-gray-500">📂 {{ $item->category }}</p>
                    <p class="text-xs text-gray-500">📍 {{ $item->location }}</p>
                    <p class="text-xs text-gray-500">📅 {{ $item->date_reported }}</p>
                    <p class="text-xs text-gray-500">📞 {{ $item->contact }}</p>
                    <p class="text-xs text-gray-500">👤 Posted by {{ $item->user->name }}</p>
                </div>
            </div>
        </div>

        {{-- Claim Form --}}
        <div class="bg-white rounded-2xl shadow border border-red-50 p-6">

            <h2 class="text-xl font-bold text-red-800 mb-1">🔐 Claim This Item</h2>
            <p class="text-sm text-gray-500 mb-6">Answer the security question to prove ownership</p>

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 p-4 rounded-2xl">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="/items/{{ $item->id }}/claim">
                @csrf

                {{-- Security Question --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Security Question</label>
                    <div class="bg-red-50 border border-red-100 rounded-xl p-4">
                        <p class="text-sm text-red-800 font-medium">{{ $item->security_question }}</p>
                    </div>
                </div>

                {{-- Answer --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Your Answer</label>
                    <input type="text" name="answer" value="{{ old('answer') }}"
                        placeholder="Type your answer here..."
                        required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm" />
                </div>

                {{-- Delivery Method --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Recovery Method</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 border border-gray-200 rounded-xl p-4 cursor-pointer hover:border-red-300 hover:bg-red-50 transition">
                            <input type="radio" name="delivery_method" value="self_pickup" required class="text-red-800">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">🏃 Self Pickup</p>
                                <p class="text-xs text-gray-400">Pick up in person</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 border border-gray-200 rounded-xl p-4 cursor-pointer hover:border-red-300 hover:bg-red-50 transition">
                            <input type="radio" name="delivery_method" value="delivery" required class="text-red-800">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">🚚 Delivery</p>
                                <p class="text-xs text-gray-400">Delivery fee applies</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-red-800 hover:bg-red-900 text-white font-semibold py-3 px-4 rounded-xl transition">
                        Submit Claim
                    </button>
                    <a href="/items"
                        class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-xl transition">
                        Cancel
                    </a>
                </div>

            </form>
        </div>

    </div>
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will need to login again to access your dashboard.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#800000',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, logout!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        })
    }
</script>
</body>
</html>
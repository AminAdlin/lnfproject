<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found Items</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-red-50 min-h-screen">

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
    <div class="max-w-6xl mx-auto px-6 py-8">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-red-800">📦 Found Items</h2>
            <a href="/post-found" class="bg-red-800 hover:bg-red-900 text-white text-sm font-semibold py-2 px-4 rounded-lg transition">
                + Post Found Item
            </a>
        </div>

        @if (session('status'))
            <div class="mb-6 text-sm text-green-600 bg-green-100 p-3 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 text-sm text-red-600 bg-red-100 p-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if($items->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($items as $item)
                    <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between">
                        <div>
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}"
                                    alt="{{ $item->title }}"
                                    class="w-full h-40 object-cover rounded-lg mb-4" />
                            @else
                                <div class="w-full h-40 bg-red-100 rounded-lg mb-4 flex items-center justify-center text-4xl">
                                    📦
                                </div>
                            @endif

                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-gray-800 text-lg">{{ $item->title }}</h3>
                                
                                {{-- Paparan Badge Status yang Dinamik --}}
                                @if($item->status === 'active')
                                    <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded-full font-medium">Active</span>
                                @elseif($item->status === 'claimed')
                                    <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-medium">Pending Review</span>
                                @elseif($item->status === 'returned_by_finder')
                                    <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full font-medium">Handed Over</span>
                                @elseif($item->status === 'returned')
                                    <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded-full font-medium">Case Closed</span>
                                @endif
                            </div>

                            <p class="text-xs text-gray-400 mb-1">📂 {{ $item->category }}</p>
                            <p class="text-xs text-gray-400 mb-1">📍 {{ $item->location }}</p>
                            <p class="text-xs text-gray-400 mb-1">📅 {{ $item->date_reported }}</p>
                            <p class="text-sm text-gray-600 mt-2 mb-4">{{ Str::limit($item->description, 80) }}</p>
                            <p class="text-xs text-gray-400 mb-4">📞 {{ $item->contact }}</p>
                        </div>

                        {{-- SEKSYEN BUTANG TINDAKAN SISTEM (FLOW KAWALAN) --}}
                        <div class="mt-4">
                            @php
                                // Ambil rekod jika user semasa ialah claimant yang tuntutannya diluluskan (approved)
                                $isApprovedClaimant = $item->claims()->where('user_id', auth()->id())->where('status', 'approved')->exists();
                            @endphp

                            {{-- KAWALAN UNTUK FINDER --}}
                            @if(auth()->id() === $item->user_id)
                                @if($item->status === 'claimed')
                                    <form method="POST" action="/items/{{ $item->id }}/returned">
                                        @csrf
                                        <button type="submit"
                                            onclick="return confirm('Mark this item as returned? This will notify the claimant via email.')"
                                            class="w-full bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold py-2 px-4 rounded-lg transition duration-200">
                                            📦 Mark as Returned
                                        </button>
                                    </form>
                                @elseif($item->status === 'returned_by_finder')
                                    <div class="w-full text-center text-xs text-blue-600 py-2 bg-blue-50 rounded-lg font-medium italic">
                                        Waiting for claimant confirmation...
                                    </div>
                                @elseif($item->status === 'returned')
                                    <div class="w-full text-center text-sm text-gray-400 py-2 bg-gray-50 rounded-lg font-bold">
                                        🔒 Case Closed (Archived)
                                    </div>
                                @endif

                            {{-- KAWALAN UNTUK CLAIMANT (YANG APPROVED SAHAJA) --}}
                            @elseif($isApprovedClaimant)
                                @if($item->status === 'returned_by_finder')
                                    <form method="POST" action="/items/{{ $item->id }}/received">
                                        @csrf
                                        <button type="submit"
                                            onclick="return confirm('Confirm that you have safely received your item? This will officially close the case.')"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2 px-4 rounded-lg transition duration-200">
                                            ✅ Item Received
                                        </button>
                                    </form>
                                @elseif($item->status === 'returned')
                                    <div class="w-full text-center text-sm text-gray-400 py-2 bg-gray-50 rounded-lg font-bold">
                                        🎉 Case Closed (Item Received)
                                    </div>
                                @endif
                            
                            {{-- PENGGUNA AWAM / KAD CLOSED UNTUK ORANG LAIN --}}
                            @elseif($item->status === 'returned')
                                <div class="w-full text-center text-sm text-gray-400 py-2 bg-gray-50 rounded-lg">
                                    Case Closed
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-5xl mb-4">📭</p>
                <p class="text-gray-500">No found items posted yet.</p>
                <a href="/post-found" class="mt-4 inline-block bg-red-800 hover:bg-red-900 text-white text-sm font-semibold py-2 px-6 rounded-lg transition">
                    Post Found Item
                </a>
            </div>
        @endif

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
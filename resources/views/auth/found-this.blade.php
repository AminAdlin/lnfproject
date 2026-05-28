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

            <form method="POST" action="/items/{{ $item->id }}/found-this" enctype="multipart/form-data">
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
                
                {{-- Input Gambar Bukti yang Diwajibkan (Required) --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Proof Image <span class="text-red-600">*</span></label>
                <input type="file" name="proof_image" accept="image/*" required
                    class="w-full text-xs text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-800 hover:file:bg-red-100 border border-gray-200 rounded-xl p-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-red-800" />
            <p class="text-xs text-gray-400 mt-1">Please upload a clear photo of the item you found. This is mandatory to prevent false claims.</p>
            </div> 

                {{-- Contact --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Your Contact Info</label>
                    <input type="text" name="contact" value="{{ old('contact') }}"
                        placeholder="e.g. 01X-XXXXXXX or email"
                        required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm" />
                </div>

                <div class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
    <label class="flex items-center gap-2 font-bold text-sm text-gray-700 mb-3 cursor-pointer">
        <input type="checkbox" name="is_delivery_ready" value="1" id="deliveryCheckbox" onchange="toggleBankInputs()" class="rounded text-red-800 focus:ring-red-800">
        📦 I am willing to ship/post this item (Flat Rate RM10.00)
    </label>

    <div id="bankInputs" class="hidden space-y-3 pt-2 border-t border-gray-200">
        <div>
            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Bank Name</label>
            <select name="bank_name" class="w-full text-sm px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-800">
                <option value="">-- Select Bank --</option>
                <option value="Maybank">Maybank</option>
                <option value="CIMB">CIMB Bank</option>
                <option value="Bank Islam">Bank Islam</option>
                <option value="RHB">RHB Bank</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Account Number</label>
            <input type="text" name="account_number" placeholder="e.g. 164012345678" class="w-full text-sm px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-800">
        </div>
    </div>
</div>

<script>
    function toggleBankInputs() {
        const checkbox = document.getElementById('deliveryCheckbox');
        const bankInputs = document.getElementById('bankInputs');
        if(checkbox.checked) {
            bankInputs.classList.remove('hidden');
        } else {
            bankInputs.classList.add('hidden');
        }
    }
</script>

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
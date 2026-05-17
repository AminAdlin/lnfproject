<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Lost Item - UTM FoundIt</title>
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
            background: linear-gradient(135deg, #6b1414 0%, #7f1d1d 30%, #991b1b 60%, #b91c1c 100%);
        }
        .card-texture {
            background: white;
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23991b1b' fill-opacity='0.015' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
            border: 1px solid rgba(127,29,29,0.08);
        }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.25); }
        .nav-pill { transition: all 0.2s ease; }
        .nav-pill:hover { background: white; color: #7f1d1d; transform: scale(1.05); }
    </style>
</head>
<body class="min-h-screen">

    {{-- Navbar --}}
    <nav class="navbar-texture text-white sticky top-0 z-50">
        <div class="flex justify-between items-center px-4 sm:px-8 py-3 sm:py-4">
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="bg-white rounded-xl sm:rounded-2xl p-1 sm:p-1.5 shadow-lg flex-shrink-0">
                    <img src="/images/logo.png" alt="UTM FoundIt Logo" class="h-7 w-7 sm:h-9 sm:w-9 object-contain">
                </div>
                <div>
                    <h1 class="text-base sm:text-xl font-bold tracking-wide leading-tight">UTM FoundIt</h1>
                    <p class="text-red-200 text-xs tracking-wider hidden sm:block">LOST & FOUND SYSTEM</p>
                </div>
            </div>
            <div class="flex items-center gap-1.5 sm:gap-3">
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

    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-5 sm:py-8">

        {{-- Back Button --}}
        <a href="/dashboard" class="inline-flex items-center gap-2 text-sm text-red-800 font-semibold mb-4 hover:gap-3 transition-all">
            ← Back to Dashboard
        </a>

        {{-- Banner --}}
        <div class="banner-texture text-white rounded-2xl sm:rounded-3xl p-5 sm:p-7 mb-6 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white opacity-5 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="relative z-10">
                <p class="text-red-200 text-xs font-bold uppercase tracking-widest mb-1">Submit a Report</p>
                <h2 class="text-xl sm:text-2xl font-extrabold drop-shadow-lg">📋 Report Lost Item</h2>
                <p class="text-red-200 text-xs sm:text-sm mt-1">Fill in the details of your lost item</p>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="card-texture rounded-2xl shadow-md p-4 sm:p-6">

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 p-4 rounded-xl">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="/report-lost" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Item Name</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Blue Umbrella" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm @error('title') border-red-400 @enderror" />
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Category</label>
                    <select name="category" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm bg-white">
                        <option value="">-- Select Category --</option>
                        <option value="Gadget" {{ old('category') == 'Gadget' ? 'selected' : '' }}>Gadget</option>
                        <option value="Wallet" {{ old('category') == 'Wallet' ? 'selected' : '' }}>Wallet</option>
                        <option value="Keys"   {{ old('category') == 'Keys'   ? 'selected' : '' }}>Keys</option>
                        <option value="Card"   {{ old('category') == 'Card'   ? 'selected' : '' }}>Card</option>
                        <option value="Bag"    {{ old('category') == 'Bag'    ? 'selected' : '' }}>Bag</option>
                        <option value="Clothing" {{ old('category') == 'Clothing' ? 'selected' : '' }}>Clothing</option>
                        <option value="Others" {{ old('category') == 'Others' ? 'selected' : '' }}>Others</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" rows="3" placeholder="Describe your lost item in detail..." required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Location Lost</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. Cafe Medina" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm @error('location') border-red-400 @enderror" />
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Date Lost</label>
                    <input type="date" name="date_reported" value="{{ old('date_reported') }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm @error('date_reported') border-red-400 @enderror" />
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Contact Info</label>
                    <input type="text" name="contact" value="{{ old('contact') }}" placeholder="e.g. 01X-XXXXXXX or email" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm @error('contact') border-red-400 @enderror" />
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Photo <span class="normal-case font-normal text-gray-400">(optional)</span></label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs sm:text-sm" />
                    <p class="text-xs text-gray-400 mt-1">Max 2MB. JPG, JPEG, PNG only.</p>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white font-bold py-2.5 px-4 rounded-xl transition shadow-md text-sm">
                        Report Lost Item
                    </button>
                    <a href="/dashboard"
                        class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-4 rounded-xl transition text-sm">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
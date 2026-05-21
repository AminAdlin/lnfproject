<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - UTM FoundIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background-color: #f1f1f1;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(127,29,29,0.04) 0%, transparent 50%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23991b1b' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .navbar-texture { background: linear-gradient(135deg, #6b1414 0%, #7f1d1d 30%, #991b1b 60%, #b91c1c 100%); box-shadow: 0 4px 20px rgba(127,29,29,0.4); }
        .card-texture { background: white; background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23991b1b' fill-opacity='0.015' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E"); border: 1px solid rgba(127,29,29,0.08); }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.25); }
        .nav-pill { transition: all 0.2s ease; }
        .nav-pill:hover { background: white; color: #7f1d1d; transform: scale(1.05); }
        .card-flip { perspective: 1000px; }
        .payment-card {
            background: linear-gradient(135deg, #6b1414, #991b1b, #b91c1c);
            border-radius: 16px;
            padding: 24px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(127,29,29,0.3);
        }
        .payment-card::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }
        .payment-card::after {
            content: '';
            position: absolute;
            bottom: -40px;
            left: -20px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
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
            <a href="/dashboard" class="nav-pill glass rounded-full px-4 py-2 text-sm">🏠 Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-white text-red-800 text-sm px-5 py-2 rounded-full font-bold hover:bg-red-50 transition shadow-lg">Logout</button>
            </form>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-8">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Order Summary --}}
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Order Summary</p>
                <div class="card-texture rounded-2xl shadow-md p-6 mb-6">
                    <div class="flex items-center gap-4 mb-5 pb-5 border-b border-gray-100">
                        @if($claim->item->image)
                            <img src="{{ asset('storage/' . $claim->item->image) }}" class="w-16 h-16 rounded-2xl object-cover shadow border-2 border-red-100">
                        @else
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center text-2xl shadow">📦</div>
                        @endif
                        <div>
                            <h3 class="font-extrabold text-gray-800">{{ $claim->item->title }}</h3>
                            <p class="text-xs text-gray-400 mt-0.5">📂 {{ $claim->item->category }}</p>
                            <p class="text-xs text-gray-400">📍 {{ $claim->item->location }}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500 font-medium">Claimant</span>
                            <span class="text-sm font-bold text-gray-800">{{ $claim->user->name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500 font-medium">Finder</span>
                            <span class="text-sm font-bold text-gray-800">{{ $claim->item->user->name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500 font-medium">Recovery Method</span>
                            <span class="text-sm font-bold text-gray-800">🚚 Delivery</span>
                        </div>
                        <div class="h-px bg-gray-100 my-2"></div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500 font-medium">Delivery Fee</span>
                            <span class="text-sm font-bold text-gray-800">RM 5.00</span>
                        </div>
                        <div class="flex justify-between items-center bg-red-50 rounded-xl p-3 border border-red-100">
                            <span class="text-sm font-extrabold text-red-800">Total</span>
                            <span class="text-xl font-extrabold text-red-800">RM 5.00</span>
                        </div>
                    </div>
                </div>

                {{-- Visual Card --}}
                <div class="payment-card">
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <p class="text-red-200 text-xs uppercase tracking-widest">UTM FoundIt</p>
                                <p class="text-white font-bold text-sm">Delivery Payment</p>
                            </div>
                            <div class="text-2xl">💳</div>
                        </div>
                        <p class="text-white text-lg font-bold tracking-widest mb-4" id="card-display">•••• •••• •••• ••••</p>
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-red-200 text-xs uppercase tracking-wider">Card Holder</p>
                                <p class="text-white font-bold text-sm" id="name-display">YOUR NAME</p>
                            </div>
                            <div>
                                <p class="text-red-200 text-xs uppercase tracking-wider">Expires</p>
                                <p class="text-white font-bold text-sm" id="expiry-display">MM/YY</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payment Form --}}
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Payment Details</p>
                <div class="card-texture rounded-2xl shadow-md p-6">

                    @if ($errors->any())
                        <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 p-4 rounded-2xl">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/claims/{{ $claim->id }}/payment">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Cardholder Name</label>
                            <input type="text" name="card_name" id="card_name" placeholder="e.g. Ahmad bin Ali" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm font-medium" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Card Number</label>
                            <input type="text" name="card_number" id="card_number" placeholder="1234 5678 9012 3456" maxlength="19" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm font-medium" />
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Expiry Date</label>
                                <input type="text" name="expiry" id="expiry" placeholder="MM/YY" maxlength="5" required
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm font-medium" />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">CVV</label>
                                <input type="password" name="cvv" placeholder="•••" maxlength="4" required
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm font-medium" />
                            </div>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 mb-6 flex items-center gap-2">
                            <span>⚠️</span>
                            <p class="text-xs text-yellow-700 font-medium">This is a simulated payment for demonstration purposes only.</p>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white font-extrabold py-3 px-4 rounded-xl transition shadow-lg text-lg">
                            💳 Pay RM 5.00
                        </button>

                        <a href="/my-claims" class="block w-full text-center bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold py-2.5 px-4 rounded-xl transition mt-3 border border-gray-200">
                            Cancel
                        </a>

                    </form>
                </div>
            </div>

        </div>

    </div>

    <script>
        // Live card preview
        document.getElementById('card_name').addEventListener('input', function() {
            document.getElementById('name-display').textContent = this.value.toUpperCase() || 'YOUR NAME';
        });

        document.getElementById('card_number').addEventListener('input', function() {
            let val = this.value.replace(/\D/g, '').substring(0, 16);
            this.value = val.replace(/(.{4})/g, '$1 ').trim();
            let display = val.padEnd(16, '•');
            document.getElementById('card-display').textContent = display.replace(/(.{4})/g, '$1 ').trim();
        });

        document.getElementById('expiry').addEventListener('input', function() {
            let val = this.value.replace(/\D/g, '').substring(0, 4);
            if (val.length >= 2) val = val.substring(0, 2) + '/' + val.substring(2);
            this.value = val;
            document.getElementById('expiry-display').textContent = this.value || 'MM/YY';
        });
    </script>

</body>
</html>
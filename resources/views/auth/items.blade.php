<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Items - UTM FoundIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        }
        .banner-texture {
            background: linear-gradient(135deg, #6b1414 0%, #7f1d1d 30%, #991b1b 60%, #b91c1c 100%);
        }
        .item-card { transition: all 0.3s ease; border: 1px solid rgba(127,29,29,0.08); }
        .item-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(127,29,29,0.12); }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.25); }
        .nav-pill { transition: all 0.2s ease; }
        .nav-pill:hover { background: white; color: #7f1d1d; transform: scale(1.05); }
    </style>
</head>

<body class="min-h-screen">

    {{-- Navbar --}}
    <nav class="navbar-texture text-white sticky top-0 z-50">
        <div class="flex justify-between items-center px-4 sm:px-8 py-3 sm:py-4">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="bg-white rounded-xl sm:rounded-2xl p-1 sm:p-1.5 shadow-lg flex-shrink-0">
                    <img src="{{ asset('images/logo_utmfoundit_crop.png') }}" alt="UTM FoundIt" class="h-9 w-9 sm:h-12 sm:w-12 object-contain">
                </div>
                <div>
                    <h1 class="text-lg sm:text-2xl font-bold tracking-wide leading-tight">UTM FoundIt</h1>
                    <p class="text-red-200 text-xs tracking-wider hidden sm:block">LOST & FOUND SYSTEM</p>
                </div>
            </div>
            <div class="flex items-center gap-1.5 sm:gap-3">
                <a href="/notifications" class="nav-pill glass rounded-full px-2.5 sm:px-4 py-1.5 sm:py-2 text-sm">🔔</a>
                <a href="/my-claims" class="nav-pill glass rounded-full px-2.5 sm:px-4 py-1.5 sm:py-2 text-sm flex items-center gap-1.5">
                    🔐 <span class="hidden sm:inline text-xs sm:text-sm">My Claims</span>
                </a>
                <a href="/dashboard" class="nav-pill glass rounded-full px-2.5 sm:px-4 py-1.5 sm:py-2 text-sm flex items-center gap-1.5">
                    🏠 <span class="hidden sm:inline text-xs sm:text-sm">Dashboard</span>
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
                <button type="button" onclick="confirmLogout()" class="bg-white text-red-800 text-xs sm:text-sm px-3 sm:px-5 py-1.5 sm:py-2 rounded-full font-bold hover:bg-red-50 transition shadow-lg flex items-center gap-1.5">
                    <span>🚪</span><span>Logout</span>
                </button>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-5 sm:py-8">

        <a href="/dashboard" class="inline-flex items-center gap-2 text-sm text-red-800 font-semibold mb-4 hover:gap-3 transition-all">
            ← Back to Dashboard
        </a>

        {{-- Banner --}}
        <div class="banner-texture text-white rounded-2xl sm:rounded-3xl p-5 sm:p-8 mb-6 sm:mb-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full -translate-y-40 translate-x-40"></div>
            <div class="relative z-10 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div>
                    <p class="text-red-200 text-xs font-bold uppercase tracking-widest mb-1">Browse Items</p>
                    <h2 class="text-xl sm:text-3xl font-extrabold mb-1 drop-shadow-lg">All Items 📋</h2>
                    <p class="text-red-200 text-xs sm:text-sm">Browse all lost and found items at UTM</p>
                </div>
                <div class="flex gap-2 sm:gap-3">
                    <a href="/report-lost" class="glass rounded-xl sm:rounded-2xl px-3 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm font-bold hover:bg-white hover:text-red-800 transition">+ Report Lost</a>
                    <a href="/post-found" class="bg-white text-red-800 rounded-xl sm:rounded-2xl px-3 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm font-bold hover:bg-red-50 transition shadow-lg">+ Post Found</a>
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-5 text-sm text-green-700 bg-green-50 border border-green-200 p-4 rounded-2xl flex items-center gap-3 shadow-sm">
                ✅ <span class="font-medium">{{ session('status') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 text-sm text-red-700 bg-red-50 border border-red-200 p-4 rounded-2xl flex items-center gap-3 shadow-sm">
                ❌ <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Filters --}}
        <div class="bg-white rounded-2xl shadow-md p-4 sm:p-5 mb-6 sm:mb-8 border border-red-50">
            <div class="flex flex-col gap-3">
                <div class="flex gap-1 bg-gray-100 rounded-xl p-1 w-full sm:w-auto">
                    <a href="/items"            class="flex-1 sm:flex-none text-center px-4 sm:px-5 py-2 rounded-lg text-xs sm:text-sm font-bold transition {{ request('type') == null     ? 'bg-gradient-to-r from-red-800 to-red-600 text-white shadow' : 'text-gray-500 hover:text-red-800' }}">All</a>
                    <a href="/items?type=lost"  class="flex-1 sm:flex-none text-center px-4 sm:px-5 py-2 rounded-lg text-xs sm:text-sm font-bold transition {{ request('type') == 'lost'   ? 'bg-gradient-to-r from-red-800 to-red-600 text-white shadow' : 'text-gray-500 hover:text-red-800' }}">🔴 Lost</a>
                    <a href="/items?type=found" class="flex-1 sm:flex-none text-center px-4 sm:px-5 py-2 rounded-lg text-xs sm:text-sm font-bold transition {{ request('type') == 'found'  ? 'bg-gradient-to-r from-red-800 to-red-600 text-white shadow' : 'text-gray-500 hover:text-red-800' }}">🟢 Found</a>
                </div>
                <form method="GET" action="/items" class="flex gap-2">
                    @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="🔎 Search by name, location, category..."
                        class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm font-medium" />
                    <button type="submit" class="bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white font-bold py-2.5 px-4 sm:px-6 rounded-xl transition shadow-md text-xs sm:text-sm whitespace-nowrap">Search</button>
                </form>
            </div>
        </div>

        {{-- Items Grid --}}
        @if($items->count() > 0)
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">{{ $items->count() }} Items Found</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">

                @foreach($items as $item)

                @php
                    $approvedClaim = $item->claims()->where('status', 'approved')->latest()->first();
                    $currentId     = auth()->id();
                    $isPostOwner   = ($currentId === $item->user_id);

                    if ($item->type === 'found') {
                        // Scenario A: Finder posted → post creator IS the finder
                        // Claimant answers security question → they ARE the owner
                        $isFinder = $isPostOwner;
                        $isOwner  = $approvedClaim && ($currentId === $approvedClaim->user_id);
                    } else {
                        // Scenario B: Owner posted lost item → post creator IS the owner
                        // Someone submits "I found this" → they ARE the finder
                        $isOwner  = $isPostOwner;
                        $isFinder = $approvedClaim && ($currentId === $approvedClaim->user_id);
                    }
                @endphp

                <div class="item-card bg-white rounded-2xl overflow-hidden shadow-md">

                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-40 sm:h-48 object-cover" />
                    @else
                        <div class="w-full h-40 sm:h-48 bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center text-5xl">
                            {{ $item->type === 'lost' ? '📋' : '📦' }}
                        </div>
                    @endif

                    <div class="p-4 sm:p-5">

                        {{-- Title + type badge --}}
                        <div class="flex justify-between items-start mb-3">
        <h3 class="font-extrabold text-gray-800 text-base sm:text-lg leading-tight truncate mr-2">{{ $item->title }}</h3>
        <div class="flex items-center gap-1.5 flex-shrink-0">
            @if($item->type === 'lost')
                <span class="text-xs bg-red-100 text-red-700 px-2 sm:px-3 py-1 rounded-full font-bold border border-red-200 uppercase tracking-wider">Lost</span>
            @else
                <span class="text-xs bg-green-100 text-green-700 px-2 sm:px-3 py-1 rounded-full font-bold border border-green-200 uppercase tracking-wider">Found</span>
            @endif
            @if(!$isPostOwner)
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false"
                        class="w-7 h-7 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition font-bold text-lg leading-none">
                        ⋮
                    </button>
                    <div x-show="open" x-transition
                        class="absolute right-0 top-8 bg-white border border-gray-200 rounded-xl shadow-lg z-20 w-40 py-1">
                        <button onclick="openReportModal({{ $item->id }})"
                            class="w-full text-left px-4 py-2.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition flex items-center gap-2">
                            🚩 Report Post
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

                        {{-- Meta --}}
                        <div class="space-y-1 mb-3">
                            <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">📂</span> {{ $item->category }}</p>
                            <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">📍</span> {{ $item->location }}</p>
                            <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">📅</span> {{ $item->date_reported }}</p>
                            <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">📞</span> {{ $item->contact }}</p>
                            <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">👤</span> {{ $item->user->name }}</p>
                        </div>

                        <p class="text-xs sm:text-sm text-gray-600 mb-4 leading-relaxed">{{ Str::limit($item->description, 80) }}</p>

                        {{-- SECTION 1 — PUBLIC ACTION BUTTONS --}}
                        {{-- Only shown to strangers (not post owner, not finder, not owner) on active items --}}
                        @if(!$isFinder && !$isOwner && !$isPostOwner && $item->status === 'active')

                            {{-- Scenario A: Found post → stranger can claim --}}
                            @if($item->type === 'found')
                                <a href="/items/{{ $item->id }}/claim"
                                   class="block w-full text-center bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white text-xs sm:text-sm font-bold py-2.5 px-4 rounded-xl transition mb-2 shadow-md">
                                    🔐 Claim This Item
                                </a>
                            @endif

                            {{-- Scenario B: Lost post → stranger can report finding it --}}
                            @if($item->type === 'lost')
                                <a href="/items/{{ $item->id }}/found-this"
                                   class="block w-full text-center bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white text-xs sm:text-sm font-bold py-2.5 px-4 rounded-xl transition mb-2 shadow-md">
                                    🙋 I Found This!
                                </a>
                            @endif

                        @endif

                        {{-- SECTION 2 — STATUS BADGES --}}
                        @if($item->status === 'returned')
                            <div class="w-full text-center text-xs sm:text-sm text-gray-400 py-2.5 bg-gray-50 rounded-xl border border-gray-100 mb-2 font-semibold">✅ Case Closed</div>

                        @elseif($item->status === 'awaiting_appointment')
                            <div class="w-full text-center text-xs sm:text-sm text-orange-600 py-2.5 bg-orange-50 rounded-xl border border-orange-100 mb-2 font-semibold">📅 Awaiting Appointment Schedule</div>

                        @elseif($item->status === 'awaiting_payment')
                            <div class="w-full text-center text-xs sm:text-sm text-yellow-600 py-2.5 bg-yellow-50 rounded-xl border border-yellow-100 mb-2 font-semibold">💳 Awaiting Postage Payment (RM10)</div>
                        
                        @elseif($item->status === 'claimed')

                            @if($isOwner && $approvedClaim && $approvedClaim->delivery_method === 'delivery')
                                <div class="w-full text-center text-xs sm:text-sm text-blue-600 py-2.5 bg-blue-50 rounded-xl border border-blue-100 mb-2 font-semibold">📦 Payment Done — Waiting for Finder to Ship</div>
                            @elseif($isOwner && $approvedClaim && $approvedClaim->delivery_method === 'self_pickup')
                                <div class="w-full text-center text-xs sm:text-sm text-yellow-600 py-2.5 bg-yellow-50 rounded-xl border border-yellow-100 mb-2 font-semibold">📅 Appointment Set — Please Show Up</div>
                            @else
                                <div class="w-full text-center text-xs sm:text-sm text-yellow-600 py-2.5 bg-yellow-50 rounded-xl border border-yellow-100 mb-2 font-semibold">⏳ In Progress — Appointment / Shipment Set</div>
                            @endif

                        @elseif($item->status === 'returned_by_finder')
                            <div class="w-full text-center text-xs sm:text-sm text-blue-600 py-2.5 bg-blue-50 rounded-xl border border-blue-100 mb-2 font-semibold">📦 Handed Over — Awaiting Owner Confirmation</div>

                        @elseif($item->status === 'disputed')
                            <div class="w-full text-center text-xs sm:text-sm text-red-600 py-2.5 bg-red-50 rounded-xl border border-red-200 mb-2 font-semibold">⚠️ Disputed — Under Investigation</div>
                        @endif
                        {{-- SECTION 3 — DELETE (post owner, active only) --}}
                        @if($isPostOwner && $item->status === 'active')
                            <div class="mt-2 pt-2 border-t border-gray-100">
                                <form action="{{ route('item.delete', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-center text-xs font-bold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 py-2 px-4 rounded-xl transition border border-red-100">
                                        🗑️ Delete Post
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- SECTION 4 — PENDING CLAIM INBOX (post owner only) --}}
                        {{--
                            FIX: was `$item->status === 'active'` which hid pending claims
                            after status changed to awaiting_appointment / awaiting_payment.
                            Changed to check statuses where pending claims can still exist.
                        --}}
                        @if($isPostOwner && in_array($item->status, ['active', 'awaiting_appointment', 'awaiting_payment']))
                            @php $pendingClaims = $item->claims->where('status', 'pending'); @endphp

                            @if($pendingClaims->count() > 0)
                                <div class="mt-4 bg-red-50 border-2 border-red-200 rounded-xl p-3 shadow-inner">
                                    <p class="text-xs font-bold text-red-900 mb-2">
                                        {{ $item->type === 'found' ? '🔐 Claim Received!' : '🔍 Found Notification Received!' }}
                                    </p>

                                    @foreach($pendingClaims as $claim)
                                        <div class="bg-white rounded-lg p-2.5 border border-red-100 space-y-2 mb-2 last:mb-0">

                                            <p class="text-xs text-gray-600 font-medium">
                                                <span class="font-bold text-red-800">
                                                    {{ $item->type === 'found' ? 'Claimant:' : 'Finder:' }}
                                                </span>
                                                {{ $claim->user->name ?? 'Anonymous' }}
                                            </p>

                                            @if($claim->message)
                                                <p class="text-xs text-gray-600 italic bg-gray-50 p-2 rounded border border-gray-100">
                                                    "{{ $claim->message }}"
                                                </p>
                                            @endif

                                            @if($claim->proof_image)
                                                <div class="mt-1">
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Proof Image:</p>
                                                    <img src="{{ asset('storage/' . $claim->proof_image) }}"
                                                         alt="Proof"
                                                         class="w-full h-32 object-cover rounded-lg border border-gray-200 shadow-sm cursor-pointer hover:opacity-90 transition"
                                                         onclick="window.open(this.src)">
                                                </div>
                                            @endif

                                            {{-- Approve (with handover method picker) + Reject --}}
                                            {{-- Only allow approve/reject if item is still active (no one approved yet) --}}
                                            @if($item->status === 'active')
                                                <div class="pt-2 border-t border-red-100">
                                                    <p class="text-[11px] font-bold text-gray-500 uppercase mb-2">Choose Handover Method:</p>
                                                    <div class="grid grid-cols-5 gap-2">
                                                        <form method="POST" action="{{ route('claims.approve', $claim->id) }}" class="col-span-3 space-y-2">
                                                            @csrf
                                                            <div class="flex flex-col gap-1.5 mb-2">
                                                                <label class="flex items-center gap-2 p-1.5 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer text-[11px] font-bold text-gray-700">
                                                                    <input type="radio" name="handover_method" value="pickup" required class="text-red-800 focus:ring-red-800">
                                                                    🤝 Self-Pickup
                                                                </label>
                                                                <label class="flex items-center gap-2 p-1.5 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer text-[11px] font-bold text-gray-700">
                                                                    <input type="radio" name="handover_method" value="delivery" required class="text-red-800 focus:ring-red-800">
                                                                    📦 Delivery (RM10)
                                                                </label>
                                                            </div>
                                                            <button type="submit"
                                                                    onclick="return confirm('Confirm and approve this handover method?')"
                                                                    class="w-full bg-green-600 hover:bg-green-700 text-white text-[11px] font-bold py-2 px-1 rounded-lg transition shadow-sm flex items-center justify-center gap-1">
                                                                ✅ Approve
                                                            </button>
                                                        </form>

                                                        <form method="POST" action="{{ route('claims.reject', $claim->id) }}" class="col-span-2 flex items-end">
                                                            @csrf
                                                            <button type="submit"
                                                                    onclick="return confirm('Reject this claim?')"
                                                                    class="w-full bg-gray-400 hover:bg-gray-500 text-white text-[11px] font-bold py-2 rounded-lg transition shadow-sm h-[34px] flex items-center justify-center">
                                                                ❌ Reject
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                {{-- Another claim already approved, these are just queued --}}
                                                <p class="text-[11px] text-gray-400 italic pt-2 border-t border-gray-100">Another claim already approved for this item.</p>
                                            @endif

                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif

                        {{-- SECTION 5 — AWAITING PAYMENT --}}
                        {{-- Owner sees bank details + upload form | Finder sees waiting message --}}
                        @if($item->status === 'awaiting_payment')

                            @if($isOwner && $approvedClaim && $item->type === 'lost')
                                <div class="mt-4 bg-red-50 border-2 border-red-200 rounded-xl p-4 shadow-inner">
                                    <p class="text-xs font-bold text-red-900 mb-2">📦 Postage Payment Required — RM10.00</p>

                                    @php
                                        // Bank details always belong to the Finder:
                                        // Scenario A (Found post) → Finder = post creator → bank on $item
                                        // Scenario B (Lost post)  → Finder = claimant    → bank on $approvedClaim
                                        $finderBankName  = $item->type === 'found' ? $item->bank_name      : $approvedClaim->bank_name;
                                        $finderAccNumber = $item->type === 'found' ? $item->bank_account   : $approvedClaim->account_number;
                                    @endphp

                                    <div class="bg-white rounded-lg p-3 border border-red-100 text-xs text-gray-700 mb-4">
                                        <p class="font-medium text-gray-600 mb-2">Transfer to finder's account:</p>
                                        <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-200 font-mono space-y-1 text-sm text-gray-800">
                                            <p><span class="text-gray-400 text-xs font-sans font-bold">BANK:</span> <strong>{{ $finderBankName ?? 'Not provided' }}</strong></p>
                                            <p><span class="text-gray-400 text-xs font-sans font-bold">ACCOUNT:</span> <strong>{{ $finderAccNumber ?? 'Not provided' }}</strong></p>
                                            <p><span class="text-gray-400 text-xs font-sans font-bold">AMOUNT:</span> <strong class="text-red-800">RM 10.00</strong></p>
                                        </div>
                                        @php
                                            $finderQr = $item->type === 'found' 
                                            ? $item->bank_qr 
                                            : ($approvedClaim ? $approvedClaim->bank_qr : null);
                                        @endphp
                                        @if($finderQr)
                                            <div class="mt-3 pt-3 border-t border-dashed border-gray-200 text-center">
                                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-2">Scan QR to Pay:</p>
                                                <img src="{{ asset('storage/' . $finderQr) }}"
                                                     alt="Bank QR"
                                                     onclick="openQrModal('{{ asset('storage/' . $finderQr) }}')"
                                                     class="w-24 h-24 object-contain rounded-lg border border-gray-200 p-1 bg-white mx-auto cursor-zoom-in hover:opacity-80 transition">
                                                <p class="text-[10px] text-gray-400 mt-1">🔍 Tap to enlarge</p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Pay Online --}}
<form method="POST" action="{{ route('payment.create', $approvedClaim->id) }}" class="mb-2">
    @csrf
    <button type="submit"
        class="w-full py-2 px-4 text-xs font-bold text-white rounded-lg bg-blue-600 hover:bg-blue-700 transition flex items-center justify-center gap-2">
        ⚡ Pay Online via FPX — RM10.00
    </button>
</form>

<div class="flex items-center gap-2 my-2">
    <div class="flex-1 h-px bg-gray-200"></div>
    <span class="text-[10px] text-gray-400 font-bold uppercase">or manual transfer</span>
    <div class="flex-1 h-px bg-gray-200"></div>
</div>

                                    <form action="{{ route('claims.uploadReceipt', $approvedClaim->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                        @csrf
                                        <div>
                                            <label class="block text-gray-500 font-bold uppercase mb-1 text-[10px] tracking-wider">Shipping Address</label>
                                            <textarea name="shipping_address" rows="3"
                                                      class="w-full p-2 text-xs bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:border-red-700 resize-none text-gray-800"
                                                      placeholder="Receiver name, phone number, full address..." required>{{ old('shipping_address') }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-gray-500 font-bold uppercase mb-1 text-[10px] tracking-wider">Payment Receipt (image)</label>
                                            <input type="file" name="payment_receipt_image"
                                                   class="w-full text-xs bg-white border border-gray-300 rounded-lg file:mr-3 file:py-1.5 file:px-3 file:rounded-l-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 text-gray-600"
                                                   accept="image/jpeg,image/png,image/jpg" required>
                                        </div>
                                        <button type="submit" class="w-full py-2 px-4 text-xs font-bold text-white rounded-lg bg-red-800 hover:bg-red-900 transition flex items-center justify-center gap-2">
                                            Submit Payment & Shipping Details
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if($isFinder)
                                <div class="mt-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl p-3 text-xs shadow-sm">
                                    ⏳ Waiting for the owner to complete the RM10.00 postage payment and upload their receipt.
                                </div>
                            @endif

                        @endif

                        {{-- SECTION 6 — AWAITING APPOINTMENT --}}
                        {{-- Finder sees form to set date/time/location | Owner sees waiting message --}}
                        @if($item->status === 'awaiting_appointment')

                            @if($isFinder)
                                <div class="mt-4 bg-gray-50 border border-gray-200 rounded-xl p-3 shadow-sm">
                                    <p class="text-xs font-bold text-red-800 mb-2">📅 Set Handover Appointment</p>
                                    <form method="POST" action="{{ route('items.appointment', $item->id) }}" class="space-y-2">
                                        @csrf
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Date & Time</label>
                                            <input type="datetime-local" name="appointment_date"
                                                   min="{{ now()->format('Y-m-d\TH:i') }}" required
                                                   class="w-full text-xs px-2 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-800 font-medium">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Meeting Location</label>
                                            <input type="text" name="appointment_location"
                                                   placeholder="e.g. FSKTM Block A / Library CICT" required
                                                   class="w-full text-xs px-2 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-800 font-medium">
                                        </div>
                                        <button type="submit" class="w-full bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition shadow-md">
                                            Confirm & Notify Owner
                                        </button>
                                    </form>
                                </div>
                            @endif

                        @endif

                        {{-- SECTION 7 — CLAIMED (appointment set or payment uploaded) --}}
                        {{-- Finder sees: Mark as Returned button (+appointment details if applicable) --}}
                        {{-- Owner sees: appointment details or waiting message --}}
                        @if($item->status === 'claimed')

                            @if($isFinder)
                                <div class="mt-4">
                                    @if($approvedClaim && $approvedClaim->appointment_date)
                                        <div class="bg-green-50 border border-green-200 rounded-xl p-3 mb-3 text-xs text-green-800">
                                            <p class="font-bold mb-1">📅 Appointment Confirmed:</p>
                                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($approvedClaim->appointment_date)->format('d-m-Y h:i A') }}</p>
                                            <p><strong>Location:</strong> {{ $approvedClaim->appointment_location }}</p>
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('items.markReturned', $item->id) }}">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Confirm that you have handed over this item?')"
                                                class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold py-2.5 px-4 rounded-xl transition shadow-md">
                                            📦 Mark as Returned / Shipped
                                        </button>
                                    </form>
                                    @if($approvedClaim && $approvedClaim->payment_method === 'manual' || $approvedClaim && $approvedClaim->payment_status === 'paid')
<div class="mt-2 pt-2 border-t border-gray-100">
<button onclick="openDisputeModal({{ $item->id }}, 'fake_receipt')"
         class="w-full text-center text-xs font-bold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 py-2 px-4 rounded-xl transition border border-red-100">
⚠️ Dispute — Fake Receipt
</button>
</div>
@endif
                                </div>
                            @endif
                        @endif

                        {{-- SECTION 8 — RETURNED BY FINDER (waiting owner confirmation) --}}
                        {{-- Owner sees: Item Received button | Finder sees: waiting message --}}
                        @if($item->status === 'returned_by_finder')

                            @if($isOwner)
                                <div class="mt-4">
                                    <p class="text-xs text-gray-500 mb-2">The finder has marked this item as handed over. Please confirm once you have it.</p>
                                    <form method="POST" action="{{ route('items.confirmReceived', $item->id) }}">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Confirm that you have received this item? This will close the case.')"
                                                class="w-full bg-green-600 hover:bg-green-700 text-white text-xs sm:text-sm font-bold py-2.5 px-4 rounded-xl transition shadow-md">
                                            ✅ Item Received — Close Case
                                        </button>
                                    </form>
                                    <div class="mt-2">
    <button onclick="openDisputeModal({{ $item->id }}, 'item_not_received')"
        class="w-full text-center text-xs font-bold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 py-2 px-4 rounded-xl transition border border-red-100">
        ⚠️ Dispute — Item Not Received
    </button>
</div>
                                </div>
                            @endif
                        @endif

                    </div>{{-- end card body --}}
                </div>{{-- end item-card --}}
                @endforeach

            </div>
        @else
            <div class="text-center py-12 bg-white rounded-2xl border border-gray-100">
                <p class="text-gray-500 font-medium">No items found matching your criteria.</p>
            </div>
        @endif
    </div>

    <div id="report-modal"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:9998;align-items:center;justify-content:center;">
    <div style="background:white;border-radius:20px;padding:28px;width:90%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <h3 style="margin:0 0 6px;color:#800000;font-size:16px;font-weight:800;">🚩 Report Post</h3>
        <p style="margin:0 0 18px;color:#666;font-size:13px;">Help us keep UTM FoundIt safe and trustworthy.</p>
        <form id="report-form" method="POST" action="">
        @csrf
        <div style="margin-bottom:14px;">
            <label style="display:block;font-size:11px;font-weight:700;color:#555;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Reason</label>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <label style="display:flex;align-items:center;gap:10px;padding:10px 12px;border:1px solid #e5e7eb;border-radius:10px;cursor:pointer;font-size:12px;font-weight:600;color:#444;">
                    <input type="radio" name="reason" value="fake_suspicious" required style="accent-color:#800000;">
                    🕵️ Fake / Suspicious Post
                </label>
                <label style="display:flex;align-items:center;gap:10px;padding:10px 12px;border:1px solid #e5e7eb;border-radius:10px;cursor:pointer;font-size:12px;font-weight:600;color:#444;">
                    <input type="radio" name="reason" value="already_resolved" style="accent-color:#800000;">
                    ✅ Already Resolved
                </label>
                <label style="display:flex;align-items:center;gap:10px;padding:10px 12px;border:1px solid #e5e7eb;border-radius:10px;cursor:pointer;font-size:12px;font-weight:600;color:#444;">
                    <input type="radio" name="reason" value="spam_duplicate" style="accent-color:#800000;">
                    🔁 Spam / Duplicate
                </label>
                <label style="display:flex;align-items:center;gap:10px;padding:10px 12px;border:1px solid #e5e7eb;border-radius:10px;cursor:pointer;font-size:12px;font-weight:600;color:#444;">
                    <input type="radio" name="reason" value="inappropriate" style="accent-color:#800000;">
                    ⚠️ Inappropriate Content
                </label>
                <label style="display:flex;align-items:center;gap:10px;padding:10px 12px;border:1px solid #e5e7eb;border-radius:10px;cursor:pointer;font-size:12px;font-weight:600;color:#444;">
                    <input type="radio" name="reason" value="other" style="accent-color:#800000;">
                    💬 Other
                </label>
            </div>
        </div>
        <div style="margin-bottom:18px;">
            <label style="display:block;font-size:11px;font-weight:700;color:#555;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Additional Details <span style="font-weight:400;color:#999;">(Optional)</span></label>
            <textarea name="message" rows="3" placeholder="Describe the issue..."
                style="width:100%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:10px;font-size:13px;resize:none;font-family:Arial,sans-serif;box-sizing:border-box;outline:none;"></textarea>
        </div>
        <div style="display:flex;gap:10px;">
            <button type="submit"
                style="flex:1;background:#800000;color:white;border:none;padding:12px;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;">
                Submit Report
            </button>
            <button type="button" onclick="closeReportModal()"
                style="flex:1;background:#f3f4f6;color:#555;border:none;padding:12px;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;">
                Cancel
            </button>
        </div>
    </form>
</div>
</div>

{{-- REPORT MODAL --}}
<div id="dispute-modal"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:9998;align-items:center;justify-content:center;">
    <div style="background:white;border-radius:20px;padding:28px;width:90%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <h3 style="margin:0 0 6px;color:#800000;font-size:16px;font-weight:800;">⚠️ Raise a Dispute</h3>
        <p style="margin:0 0 6px;color:#666;font-size:13px;">This will freeze the item and notify our admin team.</p>
        <p id="dispute-reason-label" style="margin:0 0 18px;color:#dc2626;font-size:12px;font-weight:700;"></p>
        <form id="dispute-form" method="POST" action="">
            @csrf
            <input type="hidden" name="reason" id="dispute-reason-input">
            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:11px;font-weight:700;color:#555;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Additional Details <span style="font-weight:400;color:#999;">(Optional)</span></label>
                <textarea name="message" rows="4" placeholder="Describe what happened..."
                    style="width:100%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:10px;font-size:13px;resize:none;font-family:Arial,sans-serif;box-sizing:border-box;outline:none;"></textarea>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit"
                    onclick="return confirm('Are you sure? This will freeze the item and notify admin.')"
                    style="flex:1;background:#800000;color:white;border:none;padding:12px;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;">
                    Submit Dispute
                </button>
                <button type="button" onclick="closeDisputeModal()"
                    style="flex:1;background:#f3f4f6;color:#555;border:none;padding:12px;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal overlay --}}
<div id="qr-modal"
     onclick="closeQrModal()"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.78);z-index:9999;align-items:center;justify-content:center;cursor:zoom-out;">
    <span onclick="closeQrModal()"
          style="position:absolute;top:20px;right:24px;color:white;font-size:32px;cursor:pointer;font-weight:bold;line-height:1;opacity:0.8;">✕</span>
    <img id="qr-modal-img" src="" alt="QR Code"
         style="max-width:85vw;max-height:85vh;border-radius:16px;border:4px solid white;box-shadow:0 20px 60px rgba(0,0,0,0.5);animation:qrPopIn 0.2s ease;">
</div>

<style>
    @keyframes qrPopIn {
        from { transform: scale(0.85); opacity: 0; }
        to   { transform: scale(1);    opacity: 1; }
    }
</style>

<script>
    function openQrModal(src) {
        var modal = document.getElementById('qr-modal');
        document.getElementById('qr-modal-img').src = src;
        modal.style.display = 'flex';
    }
    function closeQrModal() {
        document.getElementById('qr-modal').style.display = 'none';
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeQrModal();
    });
</script>
<script>
function openReportModal(itemId) {
document.getElementById('report-form').action = '/items/' + itemId + '/report';
document.getElementById('report-modal').style.display = 'flex';
}
function closeReportModal() {
document.getElementById('report-modal').style.display = 'none';
}

function openDisputeModal(itemId, reason) {
document.getElementById('dispute-form').action = '/items/' + itemId + '/dispute';
document.getElementById('dispute-reason-input').value = reason;
document.getElementById('dispute-reason-label').textContent =
reason === 'item_not_received'
? '📦 Reason: Item Not Received'
: '💳 Reason: Fake Receipt';
document.getElementById('dispute-modal').style.display = 'flex';
}
function closeDisputeModal() {
document.getElementById('dispute-modal').style.display = 'none';
}
</script>

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
            });
        }
    </script>
</body>
</html>
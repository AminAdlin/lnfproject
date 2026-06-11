<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - UTM FoundIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .banner-texture {
            background-image:
                url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E"),
                linear-gradient(135deg, #6b1414 0%, #7f1d1d 30%, #991b1b 60%, #b91c1c 100%);
        }
        .card-texture {
            background: white;
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23991b1b' fill-opacity='0.015' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
            transition: all 0.3s ease;
            border: 1px solid rgba(127,29,29,0.08);
        }
        .notification-item { transition: all 0.2s ease; border: 1px solid transparent; }
        .notification-item:hover { background: linear-gradient(135deg, #fef2f2, #fff5f5); border-color: rgba(127,29,29,0.1); transform: translateX(4px); }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.25); }
        .nav-pill { transition: all 0.2s ease; }
        .nav-pill:hover { background: white; color: #7f1d1d; transform: scale(1.05); }
    </style>
</head>
<body class="min-h-screen">

    <nav class="navbar-texture text-white sticky top-0 z-50">
        <div class="flex justify-between items-center px-4 sm:px-8 py-3 sm:py-4">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="bg-white rounded-xl sm:rounded-2xl p-1 sm:p-1.5 shadow-lg flex-shrink-0">
                    <img src="{{ asset('images/logo_utmfoundit_crop.png') }}" alt="UTM FoundIt Logo" class="h-9 w-9 sm:h-12 sm:w-12 object-contain">
                </div>
                <div>
                    <h1 class="text-lg sm:text-2xl font-bold tracking-wide leading-tight">UTM FoundIt</h1>
                    <p class="text-red-200 text-xs tracking-wider hidden sm:block">LOST & FOUND SYSTEM</p>
                </div>
            </div>
            <div class="flex items-center gap-1.5 sm:gap-3">
                <a href="/profile" class="nav-pill glass rounded-full px-2.5 sm:px-4 py-1.5 sm:py-2 text-sm flex items-center gap-1.5">
                👤 <span class="hidden sm:inline text-xs sm:text-sm">Profile</span>
                </a>
                <a href="/my-claims" class="nav-pill glass rounded-full px-2.5 sm:px-4 py-1.5 sm:py-2 text-sm flex items-center gap-1.5 relative">
    🔐 <span class="hidden sm:inline text-xs sm:text-sm">My Claims</span>
    @php
        $myPendingClaims = \App\Models\Claim::where('user_id', auth()->id())
            ->whereHas('item', function($q) {
                $q->whereIn('status', ['active', 'awaiting_payment', 'returned_by_finder']);
            })
            ->whereIn('status', ['pending', 'approved'])
            ->count();
    @endphp
    @if($myPendingClaims > 0)
        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">
            {{ $myPendingClaims > 9 ? '9+' : $myPendingClaims }}
        </span>
    @endif
</a>
                <a href="/dashboard" class="nav-pill glass rounded-full px-2.5 sm:px-4 py-1.5 sm:py-2 text-sm flex items-center gap-1.5">
                    <span>🏠</span><span class="hidden sm:inline text-xs sm:text-sm">Dashboard</span>
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
                <button type="button" onclick="confirmLogout()" class="bg-white text-red-800 text-xs sm:text-sm px-3 sm:px-5 py-1.5 sm:py-2 rounded-full font-bold hover:bg-red-50 transition shadow-lg flex items-center gap-1.5">
                    <span>🚪</span><span>Logout</span>
                </button>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">

        <a href="/dashboard" class="inline-flex items-center gap-2 text-sm text-red-800 font-semibold mb-4 hover:gap-3 transition-all">
            ← Back to Dashboard
        </a>

        {{-- Banner --}}
        <div class="banner-texture text-white rounded-3xl p-6 sm:p-8 mb-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full -translate-y-40 translate-x-40"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full translate-y-20 -translate-x-20"></div>
            <div class="relative z-10">
                <p class="text-red-200 text-xs font-bold uppercase tracking-widest mb-2">Inbox</p>
                <h2 class="text-3xl font-extrabold mb-1 drop-shadow-lg">Notifications 🔔</h2>
                <p class="text-red-200 text-sm">People who think they found your lost items</p>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-5 text-sm text-green-700 bg-green-50 border border-green-200 p-4 rounded-2xl flex items-center gap-3 shadow-sm">
                ✅ <span class="font-medium">{{ session('status') }}</span>
            </div>
        @endif

        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Found Notifications ({{ $notifications->count() }})</p>

        @if($notifications->count() > 0)
            <div class="space-y-3">
                @foreach($notifications as $claim)
                    <div class="notification-item card-texture rounded-2xl shadow-md p-5">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center text-xl shadow-inner">🙋</div>
                                <div>
                                    <p class="font-extrabold text-gray-800">{{ $claim->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $claim->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            {{-- Status badge --}}
                            @if($claim->status === 'pending')
                                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-bold border border-yellow-200 uppercase tracking-wider">Pending</span>
                            @elseif($claim->status === 'approved')
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-bold border border-green-200 uppercase tracking-wider">Approved</span>
                            @elseif($claim->status === 'rejected')
                                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded-full font-bold border border-gray-200 uppercase tracking-wider">Rejected</span>
                            @elseif($claim->status === 'closed')
                                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full font-bold border border-blue-200 uppercase tracking-wider">Closed</span>
                            @endif
                        </div>

                        {{-- Item info --}}
                        <div class="bg-red-50 rounded-xl p-3 mb-3 border border-red-100">
                            <p class="text-xs text-red-800 font-bold mb-1 uppercase tracking-wider">About: {{ $claim->item->title }}</p>
                            @if($claim->message)
                                <p class="text-sm text-gray-700 font-medium">"{{ $claim->message }}"</p>
                            @endif
                        </div>

                        {{-- Contact + Bank info --}}
                        <div class="space-y-1.5">
                            @if($claim->contact)
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500 font-semibold">📞 Contact:</span>
                                    <span class="text-xs font-bold text-red-800">{{ $claim->contact }}</span>
                                </div>
                            @endif
                            @if($claim->bank_name)
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500 font-semibold">🏦 Bank:</span>
                                    <span class="text-xs font-bold text-gray-700">{{ $claim->bank_name }} — {{ $claim->account_number }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Proof image --}}
                        @if($claim->proof_image)
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-2">Proof Image:</p>
                                <img src="{{ asset('storage/' . $claim->proof_image) }}"
                                     alt="Proof"
                                     class="w-full max-h-48 object-cover rounded-xl border border-gray-200 shadow-sm cursor-pointer hover:opacity-90 transition"
                                     onclick="window.open(this.src)">
                            </div>
                        @endif

                        <div class="mt-3 pt-3 border-t border-gray-100">
    <a href="/items" class="text-xs font-bold text-red-800 hover:underline">
        → Go to Items to approve or reject
    </a>
</div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-24 card-texture rounded-2xl shadow-md">
                <div class="w-20 h-20 bg-gradient-to-br from-red-50 to-red-100 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
                    <span class="text-4xl">🔔</span>
                </div>
                <p class="text-gray-600 font-bold text-lg">No notifications yet</p>
                <p class="text-gray-400 text-sm mt-1 mb-6">When someone finds your lost item, they will notify you here</p>
                <a href="/report-lost" class="bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white text-sm font-bold py-2.5 px-6 rounded-xl transition shadow-md">
                    Report Lost Item
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
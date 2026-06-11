<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Claim Item - UTM FoundIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            background-image:
                url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E"),
                linear-gradient(135deg, #6b1414 0%, #7f1d1d 30%, #991b1b 60%, #b91c1c 100%);
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

            {{-- Logo + Brand --}}
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="bg-white rounded-xl sm:rounded-2xl p-1 sm:p-1.5 shadow-lg flex-shrink-0">
                    <img src="{{ asset('images/logo_utmfoundit_crop.png') }}" alt="UTM FoundIt Logo" class="h-9 w-9 sm:h-12 sm:w-12 object-contain">
                </div>
                <div>
                    <h1 class="text-lg sm:text-2xl font-bold tracking-wide leading-tight">UTM FoundIt</h1>
                    <p class="text-red-200 text-xs tracking-wider hidden sm:block">LOST & FOUND SYSTEM</p>
                </div>
            </div>

            {{-- Nav Actions --}}
            <div class="flex items-center gap-1.5 sm:gap-3">
                <a href="/items" class="nav-pill glass rounded-full px-2.5 sm:px-4 py-1.5 sm:py-2 text-sm flex items-center gap-1.5">
                    <span>📋</span>
                    <span class="hidden sm:inline text-xs sm:text-sm">All Items</span>
                </a>
                <a href="/dashboard" class="nav-pill glass rounded-full px-2.5 sm:px-4 py-1.5 sm:py-2 text-sm flex items-center gap-1.5">
                    <span>🏠</span>
                    <span class="hidden sm:inline text-xs sm:text-sm">Dashboard</span>
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                    @csrf
                </form>
                <button type="button" onclick="confirmLogout()" class="bg-white text-red-800 text-xs sm:text-sm px-3 sm:px-5 py-1.5 sm:py-2 rounded-full font-bold hover:bg-red-50 transition shadow-lg flex items-center gap-1.5">
                    <span>🚪</span>
                    <span>Logout</span>
                </button>
            </div>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-8">

        {{-- Banner --}}
        <div class="banner-texture text-white rounded-3xl p-6 sm:p-8 mb-6 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full -translate-y-40 translate-x-40"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full translate-y-20 -translate-x-20"></div>
            <div class="relative z-10">
                <p class="text-red-200 text-xs font-bold uppercase tracking-widest mb-2">Claim Process</p>
                <h2 class="text-2xl sm:text-3xl font-extrabold mb-1 drop-shadow-lg">🔐 Claim This Item</h2>
                <p class="text-red-200 text-sm">Answer the security question to prove ownership</p>
            </div>
        </div>

        {{-- Item Details Card --}}
        <div class="card-texture rounded-2xl shadow-md overflow-hidden mb-6">
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
                    <h3 class="font-extrabold text-gray-800 text-xl">{{ $item->title }}</h3>
                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold border border-green-200 uppercase tracking-wider">Found</span>
                </div>
                <div class="space-y-1.5">
                    <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">📂</span> {{ $item->category }}</p>
                    <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">📍</span> {{ $item->location }}</p>
                    <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">📅</span> {{ $item->date_reported }}</p>
                    <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">📞</span> {{ $item->contact }}</p>
                    <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium"><span class="bg-gray-100 rounded px-1.5 py-0.5">👤</span> Posted by {{ $item->user->name }}</p>
                </div>
            </div>
        </div>

        {{-- Claim Form --}}
        <div class="card-texture rounded-2xl shadow-md p-6">

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 p-4 rounded-2xl">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($isLocked)
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center mb-4">
        <p class="text-sm font-bold text-red-800 mb-1">🔒 Access Blocked</p>
        <p class="text-xs text-gray-500">You have been blocked from claiming this item due to too many incorrect attempts.</p>
    </div>
@else

            <form method="POST" action="/items/{{ $item->id }}/claim" id="claim-form">
                @csrf

                {{-- Security Question --}}
                <div class="mb-5">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Security Question</label>
                    <div class="bg-red-50 border border-red-100 rounded-xl p-4">
                        <p class="text-sm text-red-800 font-bold">{{ $item->security_question }}</p>
                    </div>
                </div>

                {{-- Answer --}}
                <div class="mb-5">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Your Answer</label>
                    <input type="text" name="answer" value="{{ old('answer') }}"
                        placeholder="Type your answer here..."
                        required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm font-medium" />
                </div>

                {{-- Delivery Method --}}
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Recovery Method</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 border border-gray-200 rounded-xl p-4 cursor-pointer hover:border-red-300 hover:bg-red-50 transition card-texture">
                            <input type="radio" name="delivery_method" value="self_pickup" required class="text-red-800">
                            <div>
                                <p class="text-sm font-bold text-gray-800">🏃 Self Pickup</p>
                                <p class="text-xs text-gray-400">Pick up in person</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 border border-gray-200 rounded-xl p-4 cursor-pointer hover:border-red-300 hover:bg-red-50 transition card-texture">
                            <input type="radio" name="delivery_method" value="delivery" required class="text-red-800">
                            <div>
                                <p class="text-sm font-bold text-gray-800">🚚 Delivery</p>
                                <p class="text-xs text-gray-400 mt-0.5">Delivery fee RM 10.00</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Buttons --}}
<div class="flex gap-3">
    <button type="button" onclick="checkAndSubmit()"
        class="flex-1 bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white font-bold py-3 px-4 rounded-xl transition shadow-md">
        Submit Claim
    </button>
    <a href="/items"
        class="flex-1 flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-4 rounded-xl transition border border-gray-200">
        Cancel
    </a>
</div>
<div id="report-wrong-answer" class="hidden mt-4">
    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
        <p class="text-xs font-bold text-red-800 mb-1">⚠️ Think your answer is correct?</p>
        <p class="text-xs text-gray-500 mb-3">If you believe the security answer is wrong, you can report this to admin.</p>
        <button type="button" onclick="openWrongAnswerReport()"
            class="w-full text-xs font-bold text-red-600 bg-red-100 hover:bg-red-200 py-2 px-4 rounded-xl transition border border-red-200">
            🚩 Report Wrong Security Answer
        </button>
    </div>
</div>
                </div>

            </form>
            @endif
        </div>

    </div>
{{-- SECURITY QUESTION REPORT MODAL --}}
<div id="wrong-answer-modal"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:white;border-radius:20px;padding:28px;width:90%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <h3 style="margin:0 0 6px;color:#800000;font-size:16px;font-weight:800;">🚩 Report Wrong Security Answer</h3>
        <p style="margin:0 0 18px;color:#666;font-size:13px;">Admin will review and contact the post owner to verify.</p>
        <form method="POST" action="/items/{{ $item->id }}/report">
            @csrf
            <input type="hidden" name="reason" value="wrong_security_answer">
            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:11px;font-weight:700;color:#555;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">
                    Explain why you think your answer is correct
                </label>
                <textarea name="message" rows="4" required placeholder="e.g. I am the owner because..."
                    style="width:100%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:10px;font-size:13px;resize:none;font-family:Arial,sans-serif;box-sizing:border-box;outline:none;"></textarea>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit"
                    style="flex:1;background:#800000;color:white;border:none;padding:12px;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;">
                    Submit Report
                </button>
                <button type="button" onclick="document.getElementById('wrong-answer-modal').style.display='none'"
                    style="flex:1;background:#f3f4f6;color:#555;border:none;padding:12px;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
    <script>
    let wrongAttempts = 0;

    function checkAndSubmit() {
        const answer = document.querySelector('input[name="answer"]').value.trim();
        const method = document.querySelector('input[name="delivery_method"]:checked');

        if (!answer) {
            Swal.fire({ icon: 'warning', title: 'Please enter your answer', confirmButtonColor: '#800000' });
            return;
        }
        if (!method) {
            Swal.fire({ icon: 'warning', title: 'Please select a recovery method', confirmButtonColor: '#800000' });
            return;
        }

        // AJAX check answer first
        fetch('/items/{{ $item->id }}/check-answer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ answer: answer })
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                // Correct — submit form
                console.log('submitting form:', document.getElementById('claim-form'));
                document.getElementById('claim-form').submit();
            } else {
                wrongAttempts++;
                
                if (wrongAttempts >= 3) {
                    // Show report button after 3 wrong attempts
                    document.getElementById('report-wrong-answer').classList.remove('hidden');
                    Swal.fire({
                        icon: 'error',
                        title: 'Incorrect Answer',
                        text: 'You have entered the wrong answer 3 times. If you believe your answer is correct, you may report this issue.',
                        confirmButtonColor: '#800000'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Incorrect Answer',
                        text: 'Wrong answer. Attempts: ' + wrongAttempts + '/3',
                        confirmButtonColor: '#800000'
                    });
                }
            }
        });
    }

    function openWrongAnswerReport() {
        document.getElementById('wrong-answer-modal').style.display = 'flex';
    }

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - UTM FoundIt</title>
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
            background-image:
                url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E"),
                linear-gradient(135deg, #6b1414 0%, #7f1d1d 30%, #991b1b 60%, #b91c1c 100%);
        }
        .card-texture {
            background: white;
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23991b1b' fill-opacity='0.015' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(127,29,29,0.08);
        }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.25); }
        .nav-pill { transition: all 0.2s ease; }
        .nav-pill:hover { background: white; color: #7f1d1d; transform: scale(1.05); }
        .section-divider { height: 1px; background: linear-gradient(90deg, transparent, rgba(127,29,29,0.15), transparent); margin: 1.5rem 0; }
        .stat-card { position: relative; overflow: hidden; }
        .stat-card::before { content: ''; position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; border-radius: 50%; opacity: 0.06; }
        .stat-card-red::before { background: #991b1b; }
        .stat-card-green::before { background: #166534; }
        .stat-card-yellow::before { background: #854d0e; }
    </style>
</head>
<body class="min-h-screen">

    {{-- Navbar --}}
    <nav class="navbar-texture text-white sticky top-0 z-50">
        <div class="flex justify-between items-center px-4 sm:px-8 py-3 sm:py-4">
            {{-- Brand --}}
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="bg-white rounded-xl sm:rounded-2xl p-1 sm:p-1.5 shadow-lg flex-shrink-0">
                    <img src="/images/logo.png" alt="UTM FoundIt Logo" class="h-7 w-7 sm:h-9 sm:w-9 object-contain">
                </div>
                <div>
                    <h1 class="text-base sm:text-xl font-bold tracking-wide leading-tight">UTM FoundIt</h1>
                    <p class="text-red-200 text-xs tracking-wider hidden sm:block">LOST & FOUND SYSTEM</p>
                </div>
            </div>

            {{-- Nav Actions --}}
            <div class="flex items-center gap-1.5 sm:gap-3">
                <a href="/notifications" class="nav-pill glass rounded-full px-2.5 sm:px-4 py-1.5 sm:py-2 text-sm">🔔</a>
                <a href="/my-claims" class="nav-pill glass rounded-full px-2.5 sm:px-4 py-1.5 sm:py-2 text-sm flex items-center gap-1.5">
                    🔐 <span class="hidden sm:inline text-xs sm:text-sm">My Claims</span>
                </a>
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

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-5 sm:py-8">

        {{-- Banner --}}
        <div class="banner-texture text-white rounded-2xl sm:rounded-3xl p-5 sm:p-8 mb-6 sm:mb-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full -translate-y-40 translate-x-40"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full translate-y-20 -translate-x-20"></div>
            <div class="relative z-10 flex items-center gap-4 sm:gap-6">
                @if($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}"
                        class="w-14 h-14 sm:w-20 sm:h-20 rounded-2xl object-cover border-4 border-white border-opacity-40 shadow-2xl flex-shrink-0" />
                @else
                    <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-2xl bg-white bg-opacity-15 flex items-center justify-center text-2xl sm:text-3xl border-4 border-white border-opacity-20 shadow-2xl flex-shrink-0">👤</div>
                @endif
                <div class="min-w-0">
                    <p class="text-red-200 text-xs font-bold uppercase tracking-widest mb-1">{{ now()->format('l, d F Y') }}</p>
                    <h2 class="text-xl sm:text-3xl font-extrabold mb-1 drop-shadow-lg truncate">{{ $user->name }}</h2>
                    <p class="text-red-200 text-xs sm:text-sm truncate">{{ $user->email }}</p>
                    @if($user->student_id)
                        <p class="text-red-200 text-xs sm:text-sm mt-0.5">🎓 {{ $user->student_id }}</p>
                    @endif
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-5 text-sm text-green-700 bg-green-50 border border-green-200 p-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <span class="text-xl">✅</span>
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 text-sm text-red-700 bg-red-50 border border-red-200 p-4 rounded-2xl shadow-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        {{-- Activity Cards --}}
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">My Activity</p>
        {{-- 2 cols on mobile, 3 on md+ --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 sm:gap-5 mb-6 sm:mb-8">

            <div class="card-texture stat-card stat-card-red rounded-2xl shadow-md p-4 sm:p-6">
                <div class="flex items-center justify-between mb-3 sm:mb-5">
                    <div class="bg-gradient-to-br from-red-100 to-red-200 rounded-xl p-2 sm:p-3 text-xl sm:text-2xl shadow-inner">📋</div>
                    <span class="text-xs text-red-500 bg-red-50 px-2 py-1 rounded-full font-bold border border-red-100 uppercase tracking-wider hidden sm:inline">Reports</span>
                </div>
                <p class="text-3xl sm:text-5xl font-extrabold text-red-800 mb-1">{{ auth()->user()->items()->where('type', 'lost')->count() }}</p>
                <p class="text-xs sm:text-sm text-gray-500 font-semibold leading-tight">Lost Reports</p>
                <div class="mt-3 sm:mt-4 h-1.5 bg-red-100 rounded-full overflow-hidden">
                    <div class="h-1.5 bg-gradient-to-r from-red-400 to-red-600 rounded-full" style="width: {{ auth()->user()->items()->where('type', 'lost')->count() > 0 ? min(100, auth()->user()->items()->where('type', 'lost')->count() * 20) : 5 }}%"></div>
                </div>
            </div>

            <div class="card-texture stat-card stat-card-green rounded-2xl shadow-md p-4 sm:p-6">
                <div class="flex items-center justify-between mb-3 sm:mb-5">
                    <div class="bg-gradient-to-br from-green-100 to-green-200 rounded-xl p-2 sm:p-3 text-xl sm:text-2xl shadow-inner">📦</div>
                    <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full font-bold border border-green-100 uppercase tracking-wider hidden sm:inline">Posted</span>
                </div>
                <p class="text-3xl sm:text-5xl font-extrabold text-red-800 mb-1">{{ auth()->user()->items()->where('type', 'found')->count() }}</p>
                <p class="text-xs sm:text-sm text-gray-500 font-semibold leading-tight">Found Posts</p>
                <div class="mt-3 sm:mt-4 h-1.5 bg-green-100 rounded-full overflow-hidden">
                    <div class="h-1.5 bg-gradient-to-r from-green-400 to-green-600 rounded-full" style="width: {{ auth()->user()->items()->where('type', 'found')->count() > 0 ? min(100, auth()->user()->items()->where('type', 'found')->count() * 20) : 5 }}%"></div>
                </div>
            </div>

            {{-- 3rd card spans full width on mobile --}}
            <div class="card-texture stat-card stat-card-yellow rounded-2xl shadow-md p-4 sm:p-6 col-span-2 md:col-span-1">
                <div class="flex items-center justify-between mb-3 sm:mb-5">
                    <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl p-2 sm:p-3 text-xl sm:text-2xl shadow-inner">🔐</div>
                    <span class="text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full font-bold border border-yellow-100 uppercase tracking-wider hidden sm:inline">Claims</span>
                </div>
                <p class="text-3xl sm:text-5xl font-extrabold text-red-800 mb-1">{{ auth()->user()->claims()->count() }}</p>
                <p class="text-xs sm:text-sm text-gray-500 font-semibold leading-tight">Claims Made</p>
                <div class="mt-3 sm:mt-4 h-1.5 bg-yellow-100 rounded-full overflow-hidden">
                    <div class="h-1.5 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-full" style="width: {{ auth()->user()->claims()->count() > 0 ? min(100, auth()->user()->claims()->count() * 20) : 5 }}%"></div>
                </div>
            </div>

        </div>

        <div class="section-divider"></div>

        {{-- Edit Profile & Change Password --}}
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Account Settings</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

            {{-- Edit Profile --}}
            <div class="card-texture rounded-2xl shadow-md p-4 sm:p-6">
                <div class="flex items-center gap-4 sm:gap-5 mb-5 sm:mb-6">
                    <div class="bg-gradient-to-br from-red-100 to-red-200 text-red-800 rounded-2xl p-3 sm:p-4 text-2xl sm:text-3xl shadow-inner flex-shrink-0">👤</div>
                    <div>
                        <h3 class="font-extrabold text-gray-800 text-base sm:text-lg">Edit Profile</h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Update your personal information</p>
                    </div>
                </div>
                <form method="POST" action="/profile/update" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm font-medium" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address</label>
                        <input type="email" value="{{ $user->email }}" disabled
                            class="w-full px-4 py-2.5 border border-gray-100 rounded-xl bg-gray-50 text-gray-400 text-sm" />
                        <p class="text-xs text-gray-400 mt-1">Email cannot be changed.</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Student/Staff ID</label>
                        <input type="text" name="student_id" value="{{ old('student_id', $user->student_id) }}"
                            placeholder="e.g. A12345"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm font-medium" />
                    </div>
                    <div class="mb-5 sm:mb-6">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Profile Photo</label>
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}"
                                class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl object-cover mb-2 border-2 border-red-200 shadow" />
                        @endif
                        <input type="file" name="photo" accept="image/*"
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-200 rounded-xl text-xs sm:text-sm" />
                        <p class="text-xs text-gray-400 mt-1">Max 2MB. JPG, JPEG, PNG only.</p>
                    </div>
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white font-bold py-2.5 px-4 rounded-xl transition shadow-md text-sm">
                        Save Changes
                    </button>
                </form>
            </div>

            {{-- Change Password --}}
            <div class="card-texture rounded-2xl shadow-md p-4 sm:p-6">
                <div class="flex items-center gap-4 sm:gap-5 mb-5 sm:mb-6">
                    <div class="bg-gradient-to-br from-red-100 to-red-200 text-red-800 rounded-2xl p-3 sm:p-4 text-2xl sm:text-3xl shadow-inner flex-shrink-0">🔒</div>
                    <div>
                        <h3 class="font-extrabold text-gray-800 text-base sm:text-lg">Change Password</h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Update your account password</p>
                    </div>
                </div>
                <form method="POST" action="/profile/password">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Current Password</label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password" required placeholder="••••••••"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm font-medium pr-10" />
                            <button type="button" onclick="togglePass('current_password')"
                                class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600 text-sm">👁</button>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">New Password</label>
                        <div class="relative">
                            <input type="password" id="new_password" name="password" required placeholder="••••••••"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm font-medium pr-10" />
                            <button type="button" onclick="togglePass('new_password')"
                                class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600 text-sm">👁</button>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">8–16 chars, uppercase, lowercase, number & special character.</p>
                    </div>
                    <div class="mb-5 sm:mb-6">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Confirm New Password</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm font-medium pr-10" />
                            <button type="button" onclick="togglePass('password_confirmation')"
                                class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600 text-sm">👁</button>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700 text-white font-bold py-2.5 px-4 rounded-xl transition shadow-md text-sm">
                        Update Password
                    </button>
                </form>
            </div>

        </div>

    </div>

    <script>
        function togglePass(fieldId) {
            const input = document.getElementById(fieldId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>
</html>
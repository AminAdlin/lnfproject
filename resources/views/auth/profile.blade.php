<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - UTM FoundIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg { background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 50%, #b91c1c 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(127, 29, 29, 0.15); }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- Navbar --}}
    <nav class="gradient-bg text-white px-8 py-4 flex justify-between items-center shadow-lg sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <img src="/images/logo.png" alt="UTM FoundIt Logo" class="h-10 w-10 object-contain rounded-full bg-white p-1 shadow">
            <div>
                <h1 class="text-xl font-bold tracking-wide">UTM FoundIt</h1>
                <p class="text-red-200 text-xs">Lost & Found System</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="/notifications" class="glass rounded-full px-4 py-1.5 text-sm hover:bg-white hover:text-red-800 transition relative">
                🔔
            </a>
            <a href="/my-claims" class="glass rounded-full px-4 py-1.5 text-sm hover:bg-white hover:text-red-800 transition">
                🔐 My Claims
            </a>
            <a href="/dashboard" class="glass rounded-full px-4 py-1.5 text-sm hover:bg-white hover:text-red-800 transition">
                🏠 Dashboard
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-white text-red-800 text-sm px-4 py-1.5 rounded-full font-semibold hover:bg-red-50 transition shadow">Logout</button>
            </form>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-8">

        {{-- Header Banner --}}
        <div class="gradient-bg text-white rounded-3xl p-8 mb-8 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-20 translate-x-20"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-5 rounded-full translate-y-10 -translate-x-10"></div>
            <div class="relative z-10 flex items-center gap-5">
                @if($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}"
                        class="w-16 h-16 rounded-full object-cover border-4 border-white shadow-lg" />
                @else
                    <div class="w-16 h-16 rounded-full bg-white bg-opacity-20 flex items-center justify-center text-2xl border-4 border-white shadow-lg">
                        👤
                    </div>
                @endif
                <div>
                    <p class="text-red-200 text-sm font-medium mb-1">{{ now()->format('l, d F Y') }}</p>
                    <h2 class="text-3xl font-bold mb-1">{{ $user->name }}</h2>
                    <p class="text-red-200 text-sm">{{ $user->email }}</p>
                    @if($user->student_id)
                        <p class="text-red-200 text-sm mt-0.5">🎓 {{ $user->student_id }}</p>
                    @endif
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 p-4 rounded-2xl flex items-center gap-2">
                ✅ {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 text-sm text-red-700 bg-red-50 border border-red-200 p-4 rounded-2xl">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        {{-- Activity Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="card-hover bg-white rounded-2xl shadow p-6 border border-red-50">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-red-100 rounded-xl p-3 text-2xl">📋</div>
                    <span class="text-xs text-red-400 bg-red-50 px-2 py-1 rounded-full">Reports</span>
                </div>
                <p class="text-4xl font-bold text-red-800 mb-1">{{ auth()->user()->items()->where('type', 'lost')->count() }}</p>
                <p class="text-sm text-gray-500">Lost Reports</p>
            </div>
            <div class="card-hover bg-white rounded-2xl shadow p-6 border border-red-50">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-green-100 rounded-xl p-3 text-2xl">📦</div>
                    <span class="text-xs text-green-500 bg-green-50 px-2 py-1 rounded-full">Posted</span>
                </div>
                <p class="text-4xl font-bold text-red-800 mb-1">{{ auth()->user()->items()->where('type', 'found')->count() }}</p>
                <p class="text-sm text-gray-500">Found Posts</p>
            </div>
            <div class="card-hover bg-white rounded-2xl shadow p-6 border border-red-50">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-yellow-100 rounded-xl p-3 text-2xl">🔐</div>
                    <span class="text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">Claims</span>
                </div>
                <p class="text-4xl font-bold text-red-800 mb-1">{{ auth()->user()->claims()->count() }}</p>
                <p class="text-sm text-gray-500">Claims Made</p>
            </div>
        </div>

        {{-- Edit Profile & Change Password --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Edit Profile --}}
            <div class="card-hover bg-white rounded-2xl shadow p-6 border border-red-50">
                <div class="flex items-center gap-5 mb-6">
                    <div class="bg-gradient-to-br from-red-100 to-red-200 text-red-800 rounded-2xl p-4 text-3xl shadow-inner">👤</div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 text-lg">Edit Profile</h3>
                        <p class="text-sm text-gray-500 mt-0.5">Update your personal information</p>
                    </div>
                </div>

                <form method="POST" action="/profile/update" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input type="email" value="{{ $user->email }}" disabled
                            class="w-full px-4 py-2.5 border border-gray-100 rounded-xl bg-gray-50 text-gray-400 text-sm" />
                        <p class="text-xs text-gray-400 mt-1">Email cannot be changed.</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Student/Staff ID</label>
                        <input type="text" name="student_id" value="{{ old('student_id', $user->student_id) }}"
                            placeholder="e.g. A12345"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm" />
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Profile Photo</label>
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}"
                                class="w-16 h-16 rounded-full object-cover mb-2 border-2 border-red-200" />
                        @endif
                        <input type="file" name="photo" accept="image/*"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm" />
                        <p class="text-xs text-gray-400 mt-1">Max 2MB. JPG, JPEG, PNG only.</p>
                    </div>
                    <button type="submit"
                        class="w-full bg-red-800 hover:bg-red-900 text-white font-semibold py-2.5 px-4 rounded-xl transition">
                        Save Changes
                    </button>
                </form>
            </div>

            {{-- Change Password --}}
            <div class="card-hover bg-white rounded-2xl shadow p-6 border border-red-50">
                <div class="flex items-center gap-5 mb-6">
                    <div class="bg-gradient-to-br from-red-100 to-red-200 text-red-800 rounded-2xl p-4 text-3xl shadow-inner">🔒</div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 text-lg">Change Password</h3>
                        <p class="text-sm text-gray-500 mt-0.5">Update your account password</p>
                    </div>
                </div>

                <form method="POST" action="/profile/password">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password" required placeholder="••••••••"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm" />
                            <button type="button" onclick="togglePass('current_password')"
                                class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">👁</button>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                        <div class="relative">
                            <input type="password" id="new_password" name="password" required placeholder="••••••••"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm" />
                            <button type="button" onclick="togglePass('new_password')"
                                class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">👁</button>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">8–16 chars, uppercase, lowercase, number & special character.</p>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 text-sm" />
                            <button type="button" onclick="togglePass('password_confirmation')"
                                class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">👁</button>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full bg-red-800 hover:bg-red-900 text-white font-semibold py-2.5 px-4 rounded-xl transition">
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
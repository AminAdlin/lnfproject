<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - UTM FoundIt</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }

        body {
            background-color: #f1f1f1;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(127,29,29,0.04) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(153,27,27,0.04) 0%, transparent 50%);
        }

        .card {
            background: white;
            border: 1px solid rgba(127,29,29,0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(127,29,29,0.12);
        }

        .navbar {
            background: linear-gradient(135deg, #6b1414, #991b1b);
            box-shadow: 0 4px 20px rgba(127,29,29,0.4);
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<nav class="navbar text-white px-4 sm:px-6 md:px-10 py-3 md:py-4 flex flex-col sm:flex-row justify-between gap-3 sm:items-center">

    <div>
        <h1 class="text-lg sm:text-xl md:text-2xl font-bold">
            👤 User Profile
        </h1>
        <p class="text-xs text-red-200">UTM FoundIt Admin Panel</p>
    </div>

    <a href="{{ route('admin.users') }}"
       class="flex items-center justify-center gap-2 bg-white text-red-800 font-bold px-4 py-2 rounded-full shadow-md hover:bg-red-50 transition text-xs sm:text-sm">
        ← <span class="block sm:inline">Back to Users</span>
    </a>

</nav>

<div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-10 py-6">

    {{-- USER INFO CARD --}}
    <div class="card rounded-2xl p-6">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            👤 User Profile
        </h2>

        {{-- BASIC INFO --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="bg-gray-50 p-4 rounded-xl">
                <p class="text-xs text-gray-500">Name</p>
                <p class="font-semibold text-gray-800">{{ $user->name }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-xl">
                <p class="text-xs text-gray-500">Email</p>
                <p class="font-semibold text-gray-800">{{ $user->email }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-xl">
                <p class="text-xs text-gray-500">Role</p>
                <p class="font-semibold capitalize text-gray-800">{{ $user->role }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-xl">
                <p class="text-xs text-gray-500">Joined Date</p>
                <p class="font-semibold text-gray-800">
                    {{ $user->created_at->format('d M Y') }}
                </p>
            </div>

        </div>

        {{-- ACTIVITY --}}
        <div class="mt-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                📦 Activity
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <div class="card rounded-xl p-4 text-center">
                    <p class="text-xs text-gray-500">Posts</p>
                    <p class="text-xl font-bold text-gray-800">
                        {{ $user->items->count() }}
                    </p>
                </div>

                <div class="card rounded-xl p-4 text-center">
                    <p class="text-xs text-gray-500">Lost Items</p>
                    <p class="text-xl font-bold text-gray-800">
                        {{ $user->items->where('type', 'lost')->count() }}
                    </p>
                </div>

                <div class="card rounded-xl p-4 text-center">
                    <p class="text-xs text-gray-500">Found Items</p>
                    <p class="text-xl font-bold text-gray-800">
                        {{ $user->items->where('type', 'found')->count() }}
                    </p>
                </div>

                <div class="card rounded-xl p-4 text-center">
                    <p class="text-xs text-gray-500">Claims</p>
                    <p class="text-xl font-bold text-gray-800">
                        {{ $user->claims->count() }}
                    </p>
                </div>

            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="mt-8 flex flex-wrap gap-3">

            {{-- BAN / UNBAN --}}
            @if(!$user->is_banned)
                <a href="{{ route('admin.users.ban', $user->id) }}"
                class="bg-red-700 text-white px-5 py-2 rounded-xl hover:bg-red-800 transition">
                    Ban User
                </a>
            @else
                <a href="{{ route('admin.users.unban', $user->id) }}"
                class="bg-green-700 text-white px-5 py-2 rounded-xl hover:bg-green-800 transition">
                    Unban User
                </a>
            @endif

            {{-- DELETE --}}
            <form action="{{ route('admin.users.destroy', $user->id) }}"
                method="POST"
                onsubmit="return confirm('Are you sure you want to delete this user?');">

            @csrf
            @method('DELETE')

            <button
                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                Delete User
            </button>
            </form>

        </div>

    </div>
</div>

</body>
</html>
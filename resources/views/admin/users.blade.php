<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management - UTM FoundIt</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            transform: translateY(-4px);
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
        <h1 class="text-lg sm:text-xl md:text-2xl font-bold">👥 Users Management</h1>
        <p class="text-xs text-red-200">UTM FoundIt Admin Panel</p>
    </div>

    <a href="/admin/dashboard"
       class="flex items-center justify-center gap-2 bg-white text-red-800 font-bold px-4 py-2 rounded-full shadow-md hover:bg-red-50 transition text-xs sm:text-sm">
        🏠 <span class="block sm:inline">Back to Dashboard</span>
    </a>

</nav>

<div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-10 py-6">

    {{-- SEARCH + STATS --}}
    <div class="flex flex-col lg:flex-row gap-4 lg:justify-between lg:items-center mb-6">

        {{-- SEARCH --}}
        <form method="GET" action="/admin/users"
              class="flex w-full lg:w-auto gap-2">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search name or email..."
                class="w-full lg:w-96 px-4 py-2 border rounded-xl shadow-sm focus:ring-2 focus:ring-red-300">

            <button class="bg-red-800 text-white px-5 py-2 rounded-xl hover:bg-red-900 transition">
                🔍
            </button>

        </form>

        {{-- TOTAL USERS --}}
        <div class="card rounded-2xl px-5 py-3 w-full lg:w-auto text-center lg:text-left">
            <p class="text-xs text-gray-500">Total Users</p>
            <p class="text-xl sm:text-2xl font-bold text-red-800">
                {{ $users->total() }}
            </p>
        </div>

    </div>

    {{-- USERS GRID (FULL RESPONSIVE) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">

        @foreach($users as $user)

            <div class="card rounded-2xl p-4 sm:p-5">

                {{-- TOP SECTION --}}
                <div class="flex items-start gap-3">

                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-red-100 flex items-center justify-center text-lg sm:text-xl flex-shrink-0">
                        👤
                    </div>

                    <div class="min-w-0">
                        <h2 class="font-bold text-gray-800 text-sm sm:text-base truncate">
                            {{ $user->name }}
                        </h2>

                        <p class="text-xs sm:text-sm text-gray-500 truncate">
                            {{ $user->email }}
                        </p>

                        @if($user->student_id)
                            <p class="text-xs text-gray-400">
                                ID: {{ $user->student_id }}
                            </p>
                        @endif
                    </div>

                </div>

                {{-- ROLE --}}
                <div class="mt-3">
                    @if($user->role == 'admin')
                        <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full font-bold">
                            ADMIN
                        </span>
                    @else
                        <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold">
                            USER
                        </span>
                    @endif
                </div>

                {{-- FOOTER --}}
                <div class="mt-4 flex justify-between items-center text-xs text-gray-400">

                    <span class="truncate">
                        📅 {{ $user->created_at->format('d M Y') }}
                    </span>

                    <a href="{{ route('admin.users.show', $user->id) }}"
                       class="text-red-700 font-bold hover:underline text-xs sm:text-sm">
                        View →
                    </a>

                </div>

            </div>

        @endforeach

    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $users->links() }}
    </div>

</div>

</body>
</html>
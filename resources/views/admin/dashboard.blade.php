<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTM FoundIt Admin Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * { font-family: 'Inter', sans-serif; }

        body {
            background: #f4f4f4;
        }

        .navbar {
            background: linear-gradient(135deg,#6b1414,#800000,#991b1b);
            box-shadow: 0 8px 25px rgba(0,0,0,.2);
        }

        .card {
            background: white;
            border-radius: 20px;
            transition: .3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .banner {
            background: linear-gradient(135deg,#6b1414,#991b1b);
            border-radius: 25px;
            color: white;
            overflow: hidden;
            position: relative;
        }
    </style>
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar text-white px-4 md:px-8 py-4 flex justify-between items-center flex-wrap gap-3">

    <div class="flex items-center gap-3">
        <div class="bg-white rounded-xl p-2">
            <img src="{{ asset('images/logo_utmfoundit_crop.png') }}" class="h-10">
        </div>

        <div>
            <h1 class="text-lg md:text-2xl font-bold">UTM FoundIt</h1>
            <p class="text-red-200 text-xs">ADMIN PANEL</p>
        </div>
    </div>

    <div class="flex flex-wrap gap-2 md:gap-3 text-sm md:text-base">

        <a href="/admin/dashboard" class="bg-white/20 px-3 py-2 rounded-full">🏠 Dashboard</a>
        <a href="/admin/users" class="bg-white/20 px-3 py-2 rounded-full">👥 Users</a>
        <a href="/admin/posts" class="bg-white/20 px-3 py-2 rounded-full">📦 Posts</a>
        <a href="/admin/disputes" class="bg-white/20 px-3 py-2 rounded-full">⚖️ Disputes</a>
        <a href="/admin/reports" class="bg-white/20 px-3 py-2 rounded-full">🚨 Reports</a>

    </div>

    <button onclick="confirmLogout()"
        class="bg-white text-red-800 font-bold px-4 py-2 rounded-full text-sm md:text-base">
        🚪 Logout
    </button>

</nav>

<!-- hidden logout form -->
<form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
    @csrf
</form>

<!-- ================= CONTENT ================= -->
<div class="max-w-7xl mx-auto p-4 md:p-8">

@if(session('status'))
    <div class="bg-green-50 border border-green-300 text-green-700 rounded-xl p-4 mb-5">
        {{ session('status') }}
    </div>
@endif

<!-- ================= BANNER ================= -->
<div class="banner p-5 md:p-8 mb-6">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

        <div>
            <p class="text-red-200 text-sm md:text-base">
                {{ now()->format('l d F Y') }}
            </p>

            <h2 class="text-2xl md:text-4xl font-extrabold mt-2">
                Welcome Admin 👋
            </h2>

            <p class="text-red-100 mt-2 text-sm md:text-base">
                Manage all users, disputes, reports and transactions.
            </p>
        </div>

        <div class="bg-white/20 p-4 md:p-5 rounded-2xl text-center">
            <p class="text-2xl md:text-4xl font-bold">
                {{ $totalUsers }}
            </p>
            <p>Registered Users</p>
        </div>

    </div>

</div>

<!-- ================= STATS 1 ================= -->
<div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">

    <a href="{{ route('admin.users') }}" class="block">
        <div class="card p-4 md:p-6 cursor-pointer hover:scale-105 transition">
            👥
            <h1 class="text-2xl md:text-5xl font-bold mt-3 text-red-800">
                {{ $totalUsers }}
            </h1>
            <p class="text-sm md:text-base text-gray-500">Total Users</p>
        </div>
    </a>

    <a href="/admin/posts" class="block">
        <div class="card p-4 md:p-6 cursor-pointer hover:scale-105 transition">
            📦
            <h1 class="text-2xl md:text-5xl font-bold mt-3 text-red-800">
                {{ $totalPosts }}
            </h1>
            <p class="text-sm md:text-base text-gray-500">Total Posts</p>
        </div>
    </a>

    <a href="/admin/reports" class="block">
        <div class="card p-4 md:p-6 cursor-pointer hover:scale-105 transition">
            🚨
            <h1 class="text-2xl md:text-5xl font-bold mt-3 text-red-800">
                {{ $totalReports }}
            </h1>
            <p class="text-sm md:text-base text-gray-500">Reports</p>
        </div>
    </a>

    <a href="/admin/disputes" class="block">
        <div class="card p-4 md:p-6 cursor-pointer hover:scale-105 transition">
            ⚖️
            <h1 class="text-2xl md:text-5xl font-bold mt-3 text-red-800">
                {{ $totalDisputes }}
            </h1>
            <p class="text-sm md:text-base text-gray-500">Open Disputes</p>
        </div>
    </a>

</div>

<!-- ================= STATS 2 ================= -->
<div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">

    <a href="/admin/posts?type=lost" class="block">
        <div class="card p-4 md:p-5 cursor-pointer hover:scale-105 transition">
            <h1 class="text-2xl md:text-4xl font-bold text-red-800">
                {{ $totalLost }}
            </h1>
            <p class="text-sm md:text-base">Lost Posts</p>
        </div>
    </a>

    <a href="/admin/posts?type=found" class="block">
        <div class="card p-4 md:p-5 cursor-pointer hover:scale-105 transition">
            <h1 class="text-2xl md:text-4xl font-bold text-red-800">
                {{ $totalFound }}
            </h1>
            <p class="text-sm md:text-base">Found Posts</p>
        </div>
    </a>

    <a href="/admin/posts?type=claimed" class="block">
        <div class="card p-4 md:p-5 cursor-pointer hover:scale-105 transition">
            <h1 class="text-2xl md:text-4xl font-bold text-red-800">
                {{ $totalClaimed }}
            </h1>
            <p class="text-sm md:text-base">Claimed Items</p>
        </div>
    </a>

    <a href="/admin/posts?type=deleted" class="block">
        <div class="card p-4 md:p-5 cursor-pointer hover:scale-105 transition">
            <h1 class="text-2xl md:text-4xl font-bold text-red-800">
                {{ $deletedPosts }}
            </h1>
            <p class="text-sm md:text-base">Deleted Posts</p>
        </div>
    </a>

</div>

</div>

<!-- ================= SWEETALERT ================= -->
<script>
function confirmLogout() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You will need to login again.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#800000',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, logout',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}
</script>

</body>
</html>
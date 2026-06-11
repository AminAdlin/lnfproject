<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTM FoundIt Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * { font-family: 'Inter', sans-serif; }

        body { background: #f4f4f4; }

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
<nav class="navbar text-white px-4 sm:px-6 md:px-10 py-3 md:py-4 flex flex-wrap justify-between items-center gap-3">

    <!-- Logo -->
    <div class="flex items-center gap-3 flex-1 min-w-fit"> 
        <div class="bg-white rounded-xl p-2">
            <img src="{{ asset('images/logo_utmfoundit_crop.png') }}" class="h-10">
        </div>

        <div>
            <h1 class="text-lg md:text-2xl font-bold">UTM FoundIt</h1>
            <p class="text-red-200 text-xs">ADMIN PANEL</p>
        </div>
    </div>

    <!-- Navigation -->
    <div class="order-3 lg:order-2 w-full lg:w-auto flex flex-wrap justify-center gap-2 text-xs sm:text-sm">

        <a href="/admin/dashboard"
            class="transition px-4 py-2 rounded-full
            {{ ($active ?? '') == 'dashboard'
                ? 'bg-white text-red-800 font-bold shadow'
                : 'bg-white/20 hover:bg-white/30' }}">
            🏠 Dashboard
        </a>
        <a href="/admin/users"
            class="transition px-4 py-2 rounded-full
            {{ ($active ?? '') == 'users'
                ? 'bg-white text-red-800 font-bold shadow'
                : 'bg-white/20 hover:bg-white/30' }}">
            👥 Users
        </a>
        <a href="/admin/posts"
           class="transition px-4 py-2 rounded-full
           {{ ($active ?? '') == 'posts'
                ? 'bg-white text-red-800 font-bold shadow'
                : 'bg-white/20 hover:bg-white/30' }}">
            📦 Posts
        </a>
        <a href="/admin/reports"
            class="transition px-4 py-2 rounded-full
            {{ ($active ?? '') == 'reports'
                ? 'bg-white text-red-800 font-bold shadow'
                : 'bg-white/20 hover:bg-white/30' }}">
            🚨 Reports
        </a>
        <a href="/admin/disputes"
            class="transition px-4 py-2 rounded-full
            {{ ($active ?? '') == 'disputes'
                ? 'bg-white text-red-800 font-bold shadow'
                : 'bg-white/20 hover:bg-white/30' }}">
            ⚖️ Disputes
        </a>
        <a href="/admin/claimed"
            class="transition px-4 py-2 rounded-full
            {{ ($active ?? '') == 'claimed'
                ? 'bg-white text-red-800 font-bold shadow'
                : 'bg-white/20 hover:bg-white/30' }}">
            ✅ Claimed
        </a>
        <a href="/admin/deleted"
            class="transition px-4 py-2 rounded-full
            {{ ($active ?? '') == 'deleted'
                ? 'bg-white text-red-800 font-bold shadow'
                : 'bg-white/20 hover:bg-white/30' }}">
            🗑️ Deleted
        </a>
    </div>

    <!-- Logout -->
    <div class="order-2 lg:order-3 ml-auto">
        <button onclick="confirmLogout()"
            class="bg-white text-red-800 font-bold px-5 py-2 rounded-full hover:bg-red-100 transition">
            🚪 Logout
        </button>
    </div>

</nav>

<form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
    @csrf
</form>

<!-- PAGE CONTENT -->
<div class="max-w-7xl mx-auto p-4 md:p-8">

    @yield('content')

</div>

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
@extends('layouts.admin')

@section('content')

<!-- ================= BANNER ================= -->
<div class="banner p-5 md:p-8 mb-6">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

        <div>
            <p class="text-red-200 text-sm md:text-base">
                {{ now()->format('l d F Y') }}
            </p>

            <h2 class="text-2xl md:text-4xl font-extrabold mt-2">
                Welcome Admin 💻
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
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

    <a href="{{ route('admin.users') }}">
        <div class="card p-6 hover:scale-105 cursor-pointer">
            <div class="text-4xl mb-3">👥</div>
            <h1 class="text-5xl font-bold text-red-800">{{ $totalUsers }}</h1>
            <p class="text-gray-500 mt-2">Total Users</p>
        </div>
    </a>

    <a href="{{ route('admin.posts') }}">
        <div class="card p-6 hover:scale-105 cursor-pointer">
            <div class="text-4xl mb-3">📦</div>
            <h1 class="text-5xl font-bold text-red-800">{{ $totalPosts }}</h1>
            <p class="text-gray-500 mt-2">Total Posts</p>
        </div>
    </a>

    <a href="/admin/reports">
        <div class="card p-6 hover:scale-105 cursor-pointer">
            <div class="text-4xl mb-3">🚩</div>
            <h1 class="text-5xl font-bold text-red-800">{{ $totalReports }}</h1>
            <p class="text-gray-500 mt-2">Reports</p>
        </div>
    </a>

    <a href="/admin/disputes">
        <div class="card p-6 hover:scale-105 cursor-pointer">
            <div class="text-4xl mb-3">⚖️</div>
            <h1 class="text-5xl font-bold text-red-800">{{ $totalDisputes }}</h1>
            <p class="text-gray-500 mt-2">Open Disputes</p>
        </div>
    </a>

    <a href="/admin/claimed">
        <div class="card p-6 hover:scale-105 cursor-pointer">
            <div class="text-4xl mb-3">✅</div>
            <h1 class="text-5xl font-bold text-red-800">{{ $totalClaimed }}</h1>
            <p class="text-gray-500 mt-2">Claimed Items</p>
        </div>
    </a>

    <a href="/admin/deleted">
        <div class="card p-6 hover:scale-105 cursor-pointer">
            <div class="text-4xl mb-3">🗑️</div>
            <h1 class="text-5xl font-bold text-red-800">{{ $deletedPosts }}</h1>
            <p class="text-gray-500 mt-2">Deleted Posts</p>
        </div>
    </a>

</div>

@endsection
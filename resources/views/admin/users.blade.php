@extends('layouts.admin')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-4 gap-5 mb-6">

    <!-- SEARCH CARD -->
    <div class="lg:col-span-3 bg-white rounded-2xl shadow p-5">

        <form method="GET" action="/admin/users"
              class="flex flex-col sm:flex-row gap-3">

            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by ID or Name..."
                class="flex-1 border border-gray-300 rounded-xl px-4 py-3
                       focus:ring-2 focus:ring-red-700 focus:outline-none">

            <button type="submit"
                class="bg-red-800 hover:bg-red-900 text-white px-6 py-3 rounded-xl font-semibold transition">
                🔍 Search
            </button>

        </form>

    </div>

    <!-- TOTAL USERS -->
    <div class="card rounded-2xl px-8 py-4 text-center min-w-[220px]">

        <p class="text-sm text-gray-500">Total Users</p>

        <p class="text-4xl font-extrabold text-red-800 mt-1">
            {{ $users->total() }}
        </p>

    </div>

</div>

{{-- USERS GRID --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

@foreach($users as $user)

    <div class="card p-6 rounded-2xl hover:scale-105 transition">

        <div class="flex items-start gap-3">

            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                👤
            </div>

            <div>
                <h2 class="font-bold text-gray-800">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>

                @if($user->student_id)
                    <p class="text-xs text-gray-400">ID: {{ $user->student_id }}</p>
                @endif
            </div>

        </div>

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

        <div class="mt-4 flex justify-between items-center">

            <span class="text-xs text-gray-500">
                📅 {{ $user->created_at->format('d M Y') }}
            </span>

            <a href="{{ route('admin.users.show', $user->id) }}"
               class="text-red-700 font-bold hover:underline text-sm">
                View →
            </a>

        </div>

    </div>

@endforeach

</div>

<div class="mt-6">
    {{ $users->links() }}
</div>

@endsection
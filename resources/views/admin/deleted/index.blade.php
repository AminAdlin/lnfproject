@extends('layouts.admin', ['active' => 'deleted'])

@section('content')

@if(session('success'))
    <div class="mb-5 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-xl shadow-md">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-6xl mx-auto p-6">

    <h1 class="text-3xl font-bold mb-6 text-red-800">
        🗑 Deleted Posts History
    </h1>

    <p class="text-gray-500 mb-6">
        All deleted items (finder, claimant, admin actions).
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

        @forelse($deletedItems as $item)

            <div class="bg-white rounded-2xl shadow p-5 opacity-90">

                <h2 class="font-bold text-lg text-gray-800">
                    {{ $item->title }}
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    📍 {{ $item->location ?? 'No location' }}
                </p>

                <div class="mt-3">
                    <span class="text-xs bg-gray-200 text-gray-700 px-3 py-1 rounded-full">
                        {{ strtoupper($item->type) }}
                    </span>
                </div>

                <p class="text-sm text-red-600 mt-3">
                    🗑 Deleted by: {{ $item->deleted_by ?? 'System' }}
                </p>

                <p class="text-xs text-gray-400 mt-2">
                    {{ $item->deleted_at }}
                </p>

                <div class="mt-4 flex gap-2">

                    <a href="{{ route('admin.deleted.show',$item->id) }}"
                    class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded-lg text-sm">

                    View Original

                </a>

                    <form action="{{ route('admin.deleted.restore', $item->id) }}"
                        method="POST"
                        class="flex-1"
                        onsubmit="return confirm('Are you sure you want to restore this post?')">

                    @csrf

                    <button
                        type="submit"
                        class="w-full bg-green-700 hover:bg-green-800 text-white px-3 py-2 rounded-lg text-sm">
                        Restore
                    </button>

                    </form>

                </div>

            </div>

        @empty

            <div class="col-span-full text-center text-gray-500">
                No deleted records found.
            </div>

        @endforelse

    </div>

</div>

@endsection
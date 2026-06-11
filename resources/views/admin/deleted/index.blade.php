@extends('layouts.admin', ['active' => 'deleted'])

@section('content')

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

                    <a href="/admin/posts/{{ $item->id }}"
                       class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded-lg text-sm">
                        View Original
                    </a>

                    <button class="flex-1 bg-red-700 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-800">
                        Restore
                    </button>

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
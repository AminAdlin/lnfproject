@extends('layouts.admin', ['active' => 'deleted'])

@section('content')

<div class="max-w-5xl mx-auto p-6">

    <!-- Title -->
    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold text-red-800">
            🗑 Deleted Post Details
        </h1>

        <a href="{{ route('admin.deleted') }}"
            class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded-lg font-semibold">
            ← Back
        </a>

    </div>

    <!-- Card -->
    <div class="card rounded-2xl p-6 shadow-lg">

        <!-- Image -->
        <div class="bg-white rounded-2xl shadow p-4 mb-6">

            @if($item->image)

                <img
                    src="{{ asset('storage/' . $item->image) }}"
                    alt="Post Image"
                    class="w-full max-h-[450px] object-contain rounded-xl bg-gray-100">

            @else

                <div class="h-64 flex items-center justify-center bg-gray-100 rounded-xl text-gray-400">
                    No Image
                </div>

            @endif

        </div>

        <!-- Details -->
        <div class="grid md:grid-cols-2 gap-5">

            <div>
                <p class="text-gray-500 text-sm">
                    Title
                </p>

                <h2 class="font-bold text-2xl">
                    {{ $item->title }}
                </h2>
            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Type
                </p>

                @if($item->type == 'lost')

                    <span class="bg-red-100 text-red-700 px-4 py-1 rounded-full">
                        LOST
                    </span>

                @else

                    <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full">
                        FOUND
                    </span>

                @endif

            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Location
                </p>

                <p class="font-semibold">
                    📍 {{ $item->location }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Status
                </p>

                <span class="bg-gray-200 text-gray-700 px-4 py-1 rounded-full">
                    DELETED
                </span>
            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Posted By
                </p>

                <p class="font-semibold">
                    {{ $item->user->name }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Deleted At
                </p>

                <p class="font-semibold">
                    {{ $item->deleted_at->format('d M Y h:i A') }}
                </p>
            </div>

            <div>

    <p class="text-gray-500 text-sm">
        Deleted By
    </p>

    <p class="font-semibold">
        {{ $item->deleted_by ?? 'System' }}
    </p>

</div>
        </div>

        <!-- Description -->
        <div class="mt-6">

            <p class="text-gray-500 text-sm mb-2">
                Description
            </p>

            <div class="bg-gray-50 rounded-xl p-4">
                {{ $item->description }}
            </div>

        </div>

        <!-- Buttons -->
        <div class="flex flex-wrap gap-3 mt-8">

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

</div>

@endsection

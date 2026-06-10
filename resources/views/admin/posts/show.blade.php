@extends('layouts.admin')

@section('content')

<div class="max-w-5xl mx-auto p-6">

    <!-- Title -->
    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold text-red-800">
            📦 Post Details
        </h1>

        <a href="{{ route('admin.posts') }}"
            class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded-lg font-semibold">
            ← Back
        </a>

    </div>

    <!-- Card -->
    <div class="card rounded-2xl p-6 shadow-lg">

        <!-- Image -->
        <div class="mb-6">

            @if($post->image)

                <img src="{{ asset('storage/'.$post->image) }}"
                     class="w-full h-80 object-cover rounded-xl">

            @else

                <div class="h-80 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400">
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
                    {{ $post->title }}
                </h2>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Category
                </p>

                @if($post->type=="lost")

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
                    📍 {{ $post->location }}
                </p>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Status
                </p>

                @if($post->status=="active")

                    <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full">
                        OPEN
                    </span>

                @else

                    <span class="bg-gray-200 text-gray-700 px-4 py-1 rounded-full">
                        CLOSED
                    </span>

                @endif

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Posted By
                </p>

                <p class="font-semibold">
                    {{ $post->user->name }}
                </p>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Created At
                </p>

                <p class="font-semibold">
                    {{ $post->created_at->format('d M Y h:i A') }}
                </p>

            </div>

        </div>

        <!-- Description -->

        <div class="mt-6">

            <p class="text-gray-500 text-sm mb-2">
                Description
            </p>

            <div class="bg-gray-50 rounded-xl p-4">
                {{ $post->description }}
            </div>

        </div>

        <!-- Buttons -->

        <div class="flex flex-wrap gap-3 mt-8">

            <form action="{{ route('admin.posts.delete',$post->id) }}" method="POST">

                @csrf

                <button
                    class="bg-red-700 hover:bg-red-800 text-white px-5 py-2 rounded-lg">
                    🗑 Delete Post
                </button>

            </form>

            <form action="{{ route('admin.posts.toggle',$post->id) }}" method="POST">

                @csrf

                <button
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg">

                    @if($post->status=="active")
                        🔒 Close Case
                    @else
                        🔓 Open Case
                    @endif

                </button>

            </form>

        </div>

    </div>

</div>

@endsection

@extends('layouts.admin', ['active' => 'posts'])

@section('content')

@if(session('success'))

<div class="mb-5 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-xl">
    {{ session('success') }}
</div>

@endif

<div class="max-w-6xl mx-auto p-6">

    <!-- TITLE -->
    <h1 class="text-3xl font-bold mb-6 text-red-800">
        📦 Posts Management
    </h1>

    <!-- ================= TABS ================= -->
    <div class="flex flex-wrap gap-3 mb-6">

        <a href="{{ route('admin.posts', ['type' => 'all']) }}"
           class="px-5 py-2 rounded-full font-bold transition
           {{ $type == 'all' || !$type ? 'bg-red-800 text-white' : 'bg-white' }}">
            All ({{ $totalAll }})
        </a>

        <a href="{{ route('admin.posts', ['type' => 'lost']) }}"
           class="px-5 py-2 rounded-full font-bold transition
           {{ $type == 'lost' ? 'bg-red-800 text-white' : 'bg-white' }}">
            Lost ({{ $totalLost }})
        </a>

        <a href="{{ route('admin.posts', ['type' => 'found']) }}"
           class="px-5 py-2 rounded-full font-bold transition
           {{ $type == 'found' ? 'bg-red-800 text-white' : 'bg-white' }}">
            Found ({{ $totalFound }})
        </a>

    </div>

    <!-- ================= POSTS LIST ================= -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

        @forelse($posts as $post)

            <div class="card p-4">

                <h2 class="font-bold text-lg text-gray-800">
                    {{ $post->title }}
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    📍 {{ $post->location ?? 'No location' }}
                </p>

                <p class="text-xs mt-2">
                    @if($post->type == 'lost')
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
                            LOST
                        </span>
                    @else
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                            FOUND
                        </span>
                    @endif
                </p>

                <div class="mt-4 flex justify-between items-center">

                    <span class="text-xs text-gray-400">
                        {{ $post->created_at->format('d M Y') }}
                    </span>

                    <a href="/admin/posts/{{ $post->id }}"
                       class="bg-red-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-800">
                        View
                    </a>

                </div>

            </div>

        @empty

            <div class="col-span-full text-center text-gray-500">
                No posts found.
            </div>

        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="mt-6">
        {{ $posts->links() }}
    </div>

</div>

@endsection
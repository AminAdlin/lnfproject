@extends('layouts.admin', ['active' => 'disputes'])

@section('content')

@if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-6xl mx-auto p-6">

    <h1 class="text-3xl font-bold mb-6 text-red-800">
        ⚖️ Disputes Management
    </h1>

    <p class="text-gray-500 mb-6">
        Fake receipt reports & “item not received” cases.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

        @forelse($disputes as $dispute)

            <div class="bg-white rounded-2xl shadow p-5">

                <h2 class="font-bold text-lg text-gray-800">
                    Dispute #{{ $dispute->id }}
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    📦 Item ID: {{ $dispute->item_id }}
                </p>

                <p class="text-sm text-gray-500">
                    👤 Reporter ID: {{ $dispute->reporter->name ?? 'Unknown' }}
                </p>

                <span class="text-xs px-3 py-1 rounded-full
                    {{ $dispute->status == 'resolved'
                    ? 'bg-green-100 text-green-700'
                    : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst($dispute->status) }}
                </span>

                @php
    $typeLabel = match($dispute->reason) {
        'fake_receipt' => 'Fake Receipt Report',
        'item_not_received' => 'Item Not Received',
        default => 'Dispute'
    };
@endphp

<div class="mt-3">
    <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full">
        {{ $typeLabel }}
    </span>
</div>

                <p class="text-sm text-gray-600 mt-3">
                    {{ $dispute->message }}
                </p>

                <p class="text-xs text-gray-400 mt-3">
                    {{ $dispute->created_at->format('d M Y') }}
                </p>

                <div class="mt-4 flex gap-2">

                    <a href="{{ route('admin.posts.show', $dispute->item_id) }}"
                       class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded-lg text-sm">
                        View Item
                    </a>

                    @if($dispute->status === 'resolved')

                    <button disabled
                        class="flex-1 bg-green-600 text-white px-3 py-2 rounded-lg text-sm opacity-70 cursor-not-allowed">
                        Done
                    </button>

                @else

    <form method="POST" action="{{ route('admin.disputes.resolve', $dispute->id) }}" 
      onsubmit="return confirm('Are you sure you want to resolve this dispute?');">
    @csrf

            <button
                class="w-full bg-red-700 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-800">
                Resolve
            </button>
        </form>

    @endif

</div>

            </div>

        @empty

            <div class="col-span-full text-center text-gray-500">
                No disputes found.
            </div>

        @endforelse

    </div>

</div>

@endsection
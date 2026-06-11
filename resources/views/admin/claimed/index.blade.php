@extends('layouts.admin', ['active' => 'claimed'])

@section('content')

<div class="max-w-6xl mx-auto p-6">

    <h1 class="text-3xl font-bold mb-6 text-red-800">
        ✅ Claimed Transactions
    </h1>

    <p class="text-gray-500 mb-6">
        Payment history (FPX / manual bank-in / self pickup).
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

        @forelse($claimed as $claim)

            <div class="bg-white rounded-2xl shadow p-5">

    <h2 class="font-bold text-lg text-gray-800">
        Claim #{{ $claim->id }}
    </h2>

    <p class="text-sm text-gray-500 mt-1">
        📦 Item ID: {{ $claim->item_id }}
    </p>

    <p class="text-sm text-gray-500">
        👤 Claimer ID: {{ $claim->user_id }}
    </p>

    <p class="text-sm text-gray-500">
        🚚 Delivery: {{ strtoupper($claim->delivery_method) }}
    </p>

    <p class="text-xs text-gray-400 mt-3">
        🕒 {{ $claim->created_at->format('d M Y') }}
    </p>

    <div class="mt-4">
        <a href="{{ route('admin.claimed.show', $claim->id) }}"
           class="w-full block text-center bg-blue-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-700">
            View Details
        </a>
    </div>

</div>

        @empty

            <div class="col-span-full text-center text-gray-500">
                No transactions found.
            </div>

        @endforelse

    </div>

</div>

@endsection
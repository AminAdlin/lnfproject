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
                    👤 Claimer: {{ $claim->user_id }}
                </p>

                <div class="mt-3">
                    <span class="text-xs px-3 py-1 rounded-full
                        {{ $claim->method == 'fpx' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $claim->method == 'bankin' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $claim->method == 'selfpickup' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                        {{ strtoupper($claim->method) }}
                    </span>
                </div>

                <p class="text-sm text-gray-600 mt-3">
                    💳 Amount: RM {{ $claim->amount }}
                </p>

                <p class="text-xs text-gray-400 mt-3">
                    {{ $claim->created_at->format('d M Y') }}
                </p>

                <div class="mt-4 flex gap-2">

                    <a href="#"
                       class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded-lg text-sm">
                        View Receipt
                    </a>

                    <button class="flex-1 bg-red-700 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-800">
                        Details
                    </button>

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
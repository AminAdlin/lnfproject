@extends('layouts.admin', ['active' => 'claimed'])

@section('content')

<div class="max-w-5xl mx-auto p-6">

    <!-- Title -->
    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold text-red-800">
            📦 Claim Transaction Details
        </h1>

        <a href="{{ route('admin.claimed.index') }}"
            class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded-lg font-semibold">
            ← Back
        </a>

    </div>

    <!-- Card -->
    <div class="card rounded-2xl p-6 shadow-lg">

        <!-- TOP INFO GRID -->
        <div class="grid md:grid-cols-2 gap-5">

            <div>
                <p class="text-gray-500 text-sm">Claim ID</p>
                <h2 class="font-bold text-2xl">
                    #{{ $claim->id }}
                </h2>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Delivery Method</p>

                <span class="px-4 py-1 rounded-full text-sm
                    {{ $claim->delivery_method == 'self_pickup' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ strtoupper($claim->delivery_method) }}
                </span>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Item</p>
                <p class="font-semibold">
                    {{ $claim->item->title ?? 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Claimer</p>
                <p class="font-semibold">
                    {{ $claim->user->name ?? 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Created At</p>
                <p class="font-semibold">
                    {{ $claim->created_at->format('d M Y h:i A') }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Status</p>

                <span class="px-4 py-1 rounded-full text-sm
                    {{ $claim->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $claim->status == 'approved' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $claim->status == 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                    {{ strtoupper($claim->status) }}
                </span>
            </div>

        </div>

        <!-- TRANSACTION SECTION -->
        <div class="mt-8">

            <h3 class="text-lg font-bold mb-3">
                💳 Payment Information
            </h3>

        @if($claim->delivery_method === 'self_pickup')
            <p>No payment required (Self Pickup)</p>

        @elseif($claim->payment_receipt)

            <img src="{{ asset('storage/' . $claim->payment_receipt) }}" 
                class="w-full rounded-lg">

            @else

                <div class="bg-gray-100 p-4 rounded-xl text-gray-500">
                    No receipt uploaded
                </div>

            @endif

        </div>

    </div>

</div>

@endsection
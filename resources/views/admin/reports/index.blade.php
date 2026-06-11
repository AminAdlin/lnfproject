@extends('layouts.admin', ['active' => 'reports'])

@section('content')

<div class="max-w-6xl mx-auto p-6">

    {{-- TITLE --}}
    <h1 class="text-3xl font-bold mb-6 text-red-800">
        🚨 Reports Management
    </h1>

    {{-- SUMMARY --}}
    <div class="mb-6 bg-white rounded-2xl shadow p-5 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500">Total Reports</p>
            <p class="text-3xl font-extrabold text-red-800">
                {{ $reports->count() }}
            </p>
        </div>
    </div>

    {{-- REPORT LIST --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

        @forelse($reports as $report)

            <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">

                {{-- REPORT HEADER --}}
                <h2 class="font-bold text-lg text-gray-800">
                    Report #{{ $report->id }}
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    📦 Item ID: {{ $report->item_id }}
                </p>

                <p class="text-sm text-gray-500">
                    👤 User ID: {{ $report->user_id }}
                </p>

                {{-- REASON --}}
                <div class="mt-3">
                    <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full font-bold">
                        {{ $report->reason }}
                    </span>
                </div>

                {{-- MESSAGE --}}
                <p class="text-sm text-gray-600 mt-3 line-clamp-3">
                    {{ $report->message }}
                </p>

                {{-- STATUS --}}
                <div class="mt-3">
                    @if($report->status == 'pending')
                        <span class="text-xs bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">
                            PENDING
                        </span>
                    @elseif($report->status == 'reviewed')
                        <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">
                            REVIEWED
                        </span>
                    @else
                        <span class="text-xs bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                            CLOSED
                        </span>
                    @endif
                </div>

                {{-- DATE --}}
                <p class="text-xs text-gray-400 mt-3">
                    {{ $report->created_at->format('d M Y') }}
                </p>

                {{-- ACTION BUTTONS --}}
                <div class="mt-4 flex gap-2">

                    <a href="/admin/posts/{{ $report->item_id }}"
                       class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded-lg text-sm">
                        View Item
                    </a>

                    @if($report->status == 'reviewed')
    <button class="bg-green-500 text-white px-3 py-2 rounded opacity-70 cursor-not-allowed" disabled>
        Reviewed
    </button>
@else
    <form method="POST" action="{{ route('admin.reports.reviewed', $report->id) }}">
        @csrf

        <button
            type="submit"
            onclick="return confirm('Are you sure you want to mark this as reviewed?')"
            class="bg-blue-500 text-white px-3 py-2 rounded">
            Mark Reviewed
        </button>
    </form>
@endif
                </div>

            </div>

        @empty

            <div class="col-span-full text-center text-gray-500">
                No reports found.
            </div>

        @endforelse

    </div>

</div>


@endsection
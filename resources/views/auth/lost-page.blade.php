<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost Items</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-red-50 min-h-screen">

    <nav class="bg-red-800 text-white px-6 py-4 flex justify-between items-center shadow">
        <h1 class="text-xl font-bold">🔍 UTM FoundIt</h1>
        <div class="flex items-center gap-4">
            <a href="/dashboard" class="text-sm hover:underline">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-white text-red-800 text-sm px-3 py-1 rounded-lg font-semibold hover:bg-red-50 transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-8">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-red-800">📋 Lost Items</h2>
            <a href="/report-lost" class="bg-red-800 hover:bg-red-900 text-white text-sm font-semibold py-2 px-4 rounded-lg transition">
                + Report Lost Item
            </a>
        </div>

        @if (session('status'))
            <div class="mb-6 text-sm text-green-600 bg-green-100 p-3 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        @if($items->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($items as $item)
                    <div class="bg-white rounded-xl shadow p-5">

                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}"
                                alt="{{ $item->title }}"
                                class="w-full h-40 object-cover rounded-lg mb-4" />
                        @else
                            <div class="w-full h-40 bg-red-100 rounded-lg mb-4 flex items-center justify-center text-4xl">
                                📋
                            </div>
                        @endif

                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-gray-800 text-lg">{{ $item->title }}</h3>
                            @if($item->status === 'active')
                                <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">Lost</span>
                            @else
                                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded-full">Recovered</span>
                            @endif
                        </div>

                        <p class="text-xs text-gray-400 mb-1">📂 {{ $item->category }}</p>
                        <p class="text-xs text-gray-400 mb-1">📍 {{ $item->location }}</p>
                        <p class="text-xs text-gray-400 mb-1">📅 {{ $item->date_reported }}</p>
                        <p class="text-sm text-gray-600 mt-2 mb-4">{{ Str::limit($item->description, 80) }}</p>
                        <p class="text-xs text-gray-400 mb-2">📞 {{ $item->contact }}</p>
                        <p class="text-xs text-gray-400">👤 Posted by {{ $item->user->name }}</p>

                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-5xl mb-4">📭</p>
                <p class="text-gray-500">No lost items reported yet.</p>
                <a href="/report-lost" class="mt-4 inline-block bg-red-800 hover:bg-red-900 text-white text-sm font-semibold py-2 px-6 rounded-lg transition">
                    Report Lost Item
                </a>
            </div>
        @endif

    </div>

</body>
</html>
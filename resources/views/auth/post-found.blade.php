<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Found Item</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-red-50 min-h-screen">

    {{-- Navbar --}}
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

    <div class="max-w-2xl mx-auto px-6 py-8">
        <div class="bg-white rounded-xl shadow-md p-8">

            <h2 class="text-2xl font-bold text-red-800 mb-1">📦 Post Found Item</h2>
            <p class="text-sm text-gray-500 mb-6">Fill in the details of the item you found</p>

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 bg-red-100 p-3 rounded-lg">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="/post-found" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Black Wallet" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 @error('title') border-red-500 @enderror" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800">
                        <option value="">-- Select Category --</option>
                        <option value="Gadget" {{ old('category') == 'Gadget' ? 'selected' : '' }}>Gadget</option>
                        <option value="Wallet" {{ old('category') == 'Wallet' ? 'selected' : '' }}>Wallet</option>
                        <option value="Keys" {{ old('category') == 'Keys' ? 'selected' : '' }}>Keys</option>
                        <option value="Card" {{ old('category') == 'Card' ? 'selected' : '' }}>Card</option>
                        <option value="Bag" {{ old('category') == 'Bag' ? 'selected' : '' }}>Bag</option>
                        <option value="Clothing" {{ old('category') == 'Clothing' ? 'selected' : '' }}>Clothing</option>
                        <option value="Others" {{ old('category') == 'Others' ? 'selected' : '' }}>Others</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" placeholder="Describe the item in detail..." required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Location Found</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. Library Block T" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 @error('location') border-red-500 @enderror" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Found</label>
                    <input type="date" name="date_reported" value="{{ old('date_reported') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 @error('date_reported') border-red-500 @enderror" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Info</label>
                    <input type="text" name="contact" value="{{ old('contact') }}" placeholder="e.g. 01X-XXXXXXX or email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 @error('contact') border-red-500 @enderror" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Photo (optional)</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800" />
                    <p class="text-xs text-gray-400 mt-1">Max 2MB. JPG, JPEG, PNG only.</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Security Question</label>
                    <input type="text" name="security_question" value="{{ old('security_question') }}"
                        placeholder="e.g. What color is the inside of the wallet?" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 @error('security_question') border-red-500 @enderror" />
                    <p class="text-xs text-gray-400 mt-1">Only the rightful owner should know the answer.</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Security Answer</label>
                    <input type="text" name="security_answer" value="{{ old('security_answer') }}"
                        placeholder="Your answer here" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 @error('security_answer') border-red-500 @enderror" />
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-red-800 hover:bg-red-900 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                        Post Found Item
                    </button>
                    <a href="/dashboard"
                        class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg transition duration-200">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
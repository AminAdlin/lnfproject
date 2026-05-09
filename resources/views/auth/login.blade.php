<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Welcome Back</h1>
            <p class="text-sm text-gray-500 mt-1">Login with your UTM email</p>
        </div>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-600 bg-green-100 p-3 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600 bg-red-100 p-3 rounded-lg">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="example@utm.my"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                />
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                    />
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600 text-sm">👁</button>
                </div>
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" id="remember" class="mr-2 rounded"> Remember me
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:underline">Forgot password?</a>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                Login
            </button>

        </form>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>
</html>
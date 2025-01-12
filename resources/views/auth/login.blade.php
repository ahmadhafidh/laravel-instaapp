<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <h1 class="my-8 text-center text-4xl font-bold">Sign In</h1>
    <form method="POST" action="{{ route("login") }}">
        @csrf

        <!-- Email Address -->
        <div>
            <div class="relative">
                <x-gmdi-alternate-email-tt
                    class="absolute left-2 top-2.5 h-4 w-4"
                />
                <x-text-input
                    id="email"
                    class="mt-1 block w-full pl-8"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    placeholder="Email"
                    autofocus
                    autocomplete="username"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <div class="relative">
                <x-heroicon-s-lock-closed
                    class="absolute left-2 top-2.5 h-4 w-4"
                />
                <x-text-input
                    id="password"
                    class="placeholder:slate-200 mt-1 block w-full pl-8"
                    type="password"
                    name="password"
                    placeholder="Kata Sandi"
                    required
                    autocomplete="current-password"
                />
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mt-4 block">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    name="remember"
                />
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <div class="mt-4 flex flex-col items-center gap-4">
            <x-primary-button class="w-full">Masuk</x-primary-button>

            <a
                class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                href="{{ route("register") }}"
            >
                Belum puny akun? Daftar sekarang
            </a>
        </div>
    </form>
</x-guest-layout>

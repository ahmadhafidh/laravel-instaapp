<x-guest-layout>
    <h1 class="my-8 text-center text-4xl font-bold">Sign Up</h1>

    <form method="POST" action="{{ route("register") }}">
        @csrf

        <!-- Name -->
        <div>
            <div class="relative">
                <x-heroicon-c-user class="absolute left-2 top-2.5 h-4 w-4" />
                <x-text-input
                    id="name"
                    class="mt-1 block w-full pl-8"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Nama"
                />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
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
                    autocomplete="username"
                    placeholder="Email"
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
                    class="mt-1 block w-full pl-8"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Kata Sandi"
                />
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <div class="relative">
                <x-heroicon-s-lock-closed
                    class="absolute left-2 top-2.5 h-4 w-4"
                />
                <x-text-input
                    id="password_confirmation"
                    class="mt-1 block w-full pl-8"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Konfirmasi Kata Sandi"
                />
            </div>

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        <div class="mt-4 flex flex-col items-center gap-4">
            <a
                class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                href="{{ route("login") }}"
            >
                Sudah punya akun? masuk di sini
            </a>

            <x-primary-button class="w-full">Daftar</x-primary-button>
        </div>
    </form>
</x-guest-layout>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Informasi Profil</h2>

        <p class="mt-1 text-sm text-gray-600">
            Perbarui informasi profil Anda dan email.
        </p>
    </header>

    <form
        method="post"
        action="{{ route("profile.update") }}"
        enctype="multipart/form-data"
        class="mt-6 space-y-6"
    >
        @csrf
        @method("patch")

        <div>
            <x-input-label for="name" :value="'Nama'" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-gray-800">
                        Alamat email Anda belum diverifikasi.

                        <button
                            form="send-verification"
                            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Tekan di sini untuk meminta tautan verifikasi
                        </button>
                    </p>

                    @if (session("status") === "verification-link-sent")
                        <p class="mt-2 text-sm font-medium text-green-600">
                            Tautan verifikasi baru telah dikirim ke alamat email
                            Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="profile_picture" :value="'Foto Profil'" />
            <input
                id="profile_picture"
                name="profile_picture"
                type="file"
                class="mt-1 block w-full"
                accept="image/*"
            />
            <x-input-error
                class="mt-2"
                :messages="$errors->get('profile_picture')"
            />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan</x-primary-button>

            @if (session("status") === "profile-updated")
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => (show = false), 2000)"
                    class="text-sm text-gray-600"
                >
                    Tersimpan
                </p>
            @endif
        </div>
    </form>
</section>

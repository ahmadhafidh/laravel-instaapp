<x-app-layout>
    <div class="mt-12 flex flex-col items-center border-b pb-8">
        <img
            src="{{ Auth::user()->profile_picture ? Storage::url(Auth::user()->profile_picture) : asset("assets/profile_placeholder.jpg") }}"
            alt="{{ Auth::user()->name }}'s Profile"
            class="mx-auto aspect-square w-24 rounded-full"
        />
        <div>
            <h1 class="mt-4 text-center text-xl font-semibold">
                {{ Auth::user()->name }}
            </h1>
            <p class="text-center text-sm text-gray-500">
                {{ Auth::user()->email }}
            </p>
        </div>
        <div class="flex gap-2">
            <a
                href="{{ route("profile.edit") }}"
                class="mt-8 block rounded-full bg-slate-200 px-6 py-2"
            >
                Edit Profil
            </a>
            <form action="{{ route("logout") }}" method="POST">
                @csrf
                <input
                    type="hidden"
                    name="_token"
                    value="{{ Str::random(40) }}"
                />
                <button
                    type="submit"
                    class="mt-8 block rounded-full bg-red-500 px-6 py-2 text-white"
                >
                    Keluar
                </button>
            </form>
        </div>
    </div>

    <div class="-mx-2 grid grid-cols-3 gap-2 overflow-y-auto py-4">
        @foreach ($posts as $post)
            <a href="{{ route("posts.detail", ["post" => $post->id]) }}">
                <img
                    src="{{ Storage::url($post->images[0]->path) }}"
                    alt="{{ Auth::user()->name }}'s Post"
                    class="aspect-square w-full rounded-lg"
                />
            </a>
        @endforeach
    </div>
</x-app-layout>

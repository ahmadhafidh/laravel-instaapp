<div>
    <div class="my-1 flex items-center justify-between px-2">
        <div class="my-2 flex items-center gap-4">
            <img
                src="{{ $post->user->profile_picture ? Storage::url($post->user->profile_picture) : asset("assets/profile_placeholder.jpg") }}"
                alt="{{ $post->user->name }}'s Profile"
                class="aspect-square w-12 rounded-full"
            />
            <div class="flex flex-col">
                <span class="font-semibold">{{ $post->user->name }}</span>
                <span class="-mt-0.5 text-xs">
                    {{ $post->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
        @if (Auth::id() === $post->user_id)
            <div x-data="{ openDropdown: false }" class="relative">
                <button
                    x-on:click="openDropdown = !openDropdown"
                    class="rounded-full p-2 transition-all hover:bg-slate-200"
                >
                    <x-heroicon-o-ellipsis-horizontal class="h-6 w-6" />
                </button>

                <div
                    x-show="openDropdown"
                    @click.away="openDropdown = false"
                    class="absolute right-0 z-10 mt-2 w-32 rounded-lg bg-white shadow-lg"
                >
                    <button
                        x-on:click.prevent="openDropdown = false; $dispatch('open-modal', 'confirm-post-deletion-{{ $post->id }}')"
                        class="block w-full px-4 py-2 text-left text-sm text-red-500 hover:bg-gray-100"
                    >
                        Hapus
                    </button>
                    <a
                        href="{{ route("posts.edit.form", $post->id) }}"
                        class="text-stale-800 block w-full px-4 py-2 text-left text-sm hover:bg-gray-100"
                    >
                        Edit
                    </a>
                </div>
            </div>
        @endif
    </div>

    <x-modal name="confirm-post-deletion-{{ $post->id }}" focusable>
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
            <h2 class="text-lg font-semibold">Konfirmasi Penghapusan</h2>
            <p class="mt-2 text-sm text-gray-600">
                Anda yakin ingin menghapus postingan ini?
            </p>
            <div class="mt-4 flex justify-end space-x-2">
                <button
                    x-on:click="$dispatch('close')"
                    class="rounded bg-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-400"
                >
                    Batal
                </button>
                <form
                    method="POST"
                    action="{{ route("posts.delete", $post->id) }}"
                    class="inline"
                >
                    @csrf
                    @method("DELETE")
                    <button
                        type="submit"
                        class="rounded bg-red-500 px-4 py-2 text-sm text-white hover:bg-red-600"
                    >
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-modal>

    <div
        class="scrollbar {{ count($post->images) > 1 ? "-mx-4" : "" }} flex snap-x snap-mandatory overflow-x-auto transition-transform duration-500 ease-in-out"
        :style="`transform: translateX(-${currentIndex * 100}%)`"
    >
        @foreach ($post->images as $image)
            <div
                class="{{ count($post->images) > 1 ? "max-w-[90%]" : "w-full" }} {{ $loop->first ? "ml-4 mr-2" : "mr-2" }} {{ $loop->last ? "mr-4" : "mr-2" }} w-full flex-shrink-0 snap-center"
            >
                <img
                    src="{{ asset("storage/" . $image->path) }}"
                    alt="Image"
                    draggable="false"
                    class="h-auto w-full rounded-2xl"
                />
            </div>
        @endforeach
    </div>

    <div class="my-2 flex items-center gap-1">
        <form action="{{ route("posts.like", $post->id) }}" method="POST">
            @csrf
            <button
                type="submit"
                class="flex items-center gap-1 rounded-full p-1 transition-all hover:bg-slate-200"
            >
                @if ($post->likes->where("user_id", auth()->id())->count() > 0)
                    <x-heroicon-s-heart class="h-6 w-6 text-red-500" />
                @else
                    <x-heroicon-o-heart class="h-6 w-6 text-slate-800" />
                @endif

                @if (count($post->likes) > 0)
                    <span class="block text-sm">
                        {{ count($post->likes) }}
                    </span>
                @endif
            </button>
        </form>
        @if (! $isDetailed)
            <a
                href="{{ route("posts.detail", ["post" => $post->id]) }}"
                class="flex items-center gap-1 rounded-full p-1 transition-all hover:bg-slate-200"
            >
                <x-heroicon-o-chat-bubble-oval-left
                    class="h-6 w-6 text-slate-800"
                />
                @if (count($post->comments) > 0)
                    <span class="block text-sm">
                        {{ count($post->comments) }}
                    </span>
                @endif
            </a>
        @endif
    </div>

    <div class="px-2">
        <p>{{ $post->content }}</p>
    </div>
</div>

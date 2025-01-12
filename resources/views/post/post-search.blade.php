<x-app-layout>
    <div class="my-8">
        <form
            action="{{ route("posts.search.results") }}"
            method="GET"
            class="flex items-center gap-2"
        >
            <input
                type="text"
                name="query"
                placeholder="Cari postingan..."
                value="{{ request()->query("query") }}"
                class="w-full resize-none overflow-hidden rounded-3xl border border-gray-300 px-4 py-2 placeholder:text-sm placeholder:text-slate-400"
            />
            <button
                type="submit"
                class="h-fit rounded-full bg-teal-800 px-4 py-2 text-white"
            >
                <x-heroicon-m-magnifying-glass class="h-6 w-6" />
            </button>
        </form>

        <div class="pb-20">
            @if ($posts)
                <div id="post-list" class="mt-4">
                    @if ($posts->isEmpty())
                        <div class="mt-12 px-4">
                            <p class="text-center text-gray-500">
                                Tidak ada postingan yang ditemukan
                            </p>
                        </div>
                    @else
                        @foreach ($posts as $post)
                            <x-post :post="$post" :isDetailed="false" />
                        @endforeach
                    @endif
                </div>
                <!-- Pagination links -->
                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="mt-12 px-4">
                    <p class="text-center text-gray-500">
                        Mulai cari postingan
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    @include("layouts.top-navigation", ["title" => "Postingan " . $post->user->name])

    <x-post :post="$post" isDetailed="true" />

    <div class="mb-32">
        <div class="mt-4">
            <form
                action="{{ route("posts.comment", $post->id) }}"
                method="POST"
                class="flex gap-2"
            >
                @csrf
                <textarea
                    name="content"
                    rows="1"
                    class="w-full resize-none overflow-hidden rounded-3xl border border-gray-300 px-4 py-2 placeholder:text-sm placeholder:text-slate-400"
                    placeholder="Tambahkan komentar untuk {{ $post->user->name }}"
                    required
                    x-data="{ value: '' }"
                    x-model="value"
                    x-init="
                        $nextTick(
                            () => ($refs.textarea.style.height = $refs.textarea.scrollHeight + 'px'),
                        )
                    "
                    x-ref="textarea"
                    @input="$refs.textarea.style.height = 'auto'; $refs.textarea.style.height = $refs.textarea.scrollHeight + 'px'"
                ></textarea>
                <button
                    type="submit"
                    class="h-fit rounded-full bg-teal-700 px-4 py-2 text-white"
                >
                    <x-heroicon-o-paper-airplane class="h-6 w-6" />
                </button>
            </form>
        </div>
        @if ($post->comments->isEmpty())
            <div class="mt-4">
                <p class="text-center text-gray-500">Belum ada komentar</p>
            </div>
        @else
            <div class="mt-4">
                <h3 class="text-xl font-semibold">Komentar</h3>

                <div class="mt-2 space-y-4">
                    @foreach ($post->comments as $comment)
                        <div class="flex gap-2">
                            <img
                                src="{{ $comment->user->profile_picture ? Storage::url($comment->user->profile_picture) : asset("assets/profile_placeholder.jpg") }}"
                                alt="User Profile"
                                class="h-8 w-8 rounded-full"
                            />
                            <div>
                                <div class="flex items-center">
                                    <span class="block text-sm font-semibold">
                                        {{ $comment->user->name }}
                                    </span>
                                    <span
                                        class="ml-2 block text-xs text-gray-500"
                                    >
                                        {{ $comment->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p>{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

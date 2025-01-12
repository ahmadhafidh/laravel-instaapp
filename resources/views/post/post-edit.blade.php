<x-app-layout>
    @include("layouts.top-navigation", ["title" => "Edit Postingan"])

    @php
        $content = $post->content;
        $images = $post->images->pluck("path")->toArray();
    @endphp

    <div
        x-data="{
            images: {{ json_encode($images) }} || [],
            maxImages: 12,
            content: {{ json_encode($content) }},
            isSubmitDisabled() {
                return (
                    (this.images.length === 0 && ! this.$refs.images.files.length) ||
                    ! this.content.trim()
                )
            },
            previewImages(event) {
                this.images = Array.from(event.target.files).slice(0, this.maxImages)
            },
            removeImage(index) {
                this.images.splice(index, 1)
            },
        }"
    >
        <form
            action="{{ route("posts.update", $post->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            <div class="bg-white">
                <div>
                    <div class="space-y-6">
                        <div
                            id="image-preview-container"
                            class="mb-4 grid grid-cols-4 gap-2"
                        >
                            <template
                                x-for="(image, index) in images"
                                :key="index"
                            >
                                <div class="relative inline-block">
                                    <img
                                        :src="image instanceof File ? URL.createObjectURL(image) : '{{ Storage::url("") }}' + image"
                                        class="mb-2 mr-2 aspect-square w-full overflow-hidden rounded object-cover"
                                    />
                                    <button
                                        type="button"
                                        x-on:click="removeImage(index)"
                                        class="absolute -top-2 right-0 flex h-6 w-6 items-center justify-center rounded-full bg-slate-100 text-xs text-slate-500"
                                    >
                                        &times;
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div class="flex w-full items-center justify-center">
                            <label
                                for="images"
                                class="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100"
                            >
                                <div
                                    class="flex flex-col items-center justify-center pb-6 pt-5"
                                >
                                    <svg
                                        class="mb-4 h-8 w-8 text-gray-500 dark:text-gray-400"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 20 16"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                                        />
                                    </svg>
                                    <p
                                        class="mb-2 text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        <span class="font-semibold">
                                            Klik untuk mengunggah
                                        </span>
                                        atau drag and drop
                                    </p>
                                    <p
                                        class="text-xs text-gray-500 dark:text-gray-400"
                                    >
                                        SVG, PNG, JPG atau GIF
                                    </p>
                                </div>
                                <input
                                    type="file"
                                    name="images[]"
                                    id="images"
                                    placeholder="Pilih gambar..."
                                    class="hidden"
                                    multiple
                                    x-ref="images"
                                    x-on:change="previewImages"
                                />
                            </label>
                        </div>
                        <p
                            x-show="images.length >= maxImages"
                            class="mt-2 text-sm text-red-500"
                        >
                            Kamu hanya bisa mengunggah maksimal 12 gambar
                        </p>

                        <div>
                            <label
                                for="content"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Konten
                            </label>
                            <textarea
                                name="content"
                                id="content"
                                placeholder="Tulis sesuatu..."
                                x-model="content"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required
                            ></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button
                                type="submit"
                                :disabled="isSubmitDisabled()"
                                class="w-full rounded-full border border-transparent bg-teal-800 px-4 py-2 text-center text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                :class="{'opacity-50 cursor-not-allowed': isSubmitDisabled()}"
                            >
                                Ubah Postingan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

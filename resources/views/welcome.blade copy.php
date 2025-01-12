<x-app-layout>
    @if ($posts->isEmpty())
        <div class="mt-12 px-4">
            <p class="text-center text-gray-500">Tidak ada postingan</p>
        </div>
    @else
        <div class="pb-20">
            <div id="post-list" class="space-y-4 divide-y">
                @foreach ($posts as $post)
                    <x-post :post="$post" :isDetailed="false" />
                @endforeach
            </div>

            <div id="loading" class="hidden text-center">
                <p>Loading more post...</p>
            </div>
        </div>
    @endif

    <script>
        $(document).ready(function () {
            let page = 1;
            let isLoading = false;

            $(window).scroll(function () {
                if (
                    $(window).scrollTop() + $(window).height() >=
                        $(document).height() - 100 &&
                    !isLoading
                ) {
                    page++;
                    loadMoreData(page);
                }
            });

            function loadMoreData(page) {
                isLoading = true;
                $.ajax({
                    url: '?page=' + page,
                    method: 'GET',
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    success: function (data) {
                        if (data.trim() === '') {
                            $('#loading').hide();
                            return;
                        }
                        $('#loading').hide();
                        $('#post-list').append(data);
                        isLoading = false;
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        isLoading = false;
                    },
                });
            }
        });
    </script>
</x-app-layout>

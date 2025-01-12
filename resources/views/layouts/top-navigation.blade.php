<div class="container flex w-full items-center gap-4 bg-white px-4 py-4">
    <a href="{{ url()->previous() }}">
        <x-heroicon-c-arrow-left class="h-6 w-6" />
    </a>
    <div class="text-lg font-semibold">
        <span>{{ $title }}</span>
    </div>
</div>

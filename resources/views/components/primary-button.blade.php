<button
    {{ $attributes->merge(["type" => "submit", "class" => "px-4 py-2 bg-teal-700 rounded-full font-semibold text-white hover:bg-teal-800 transition-all"]) }}
>
    {{ $slot }}
</button>

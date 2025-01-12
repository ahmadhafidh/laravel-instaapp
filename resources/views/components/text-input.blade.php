@props(["disabled" => false])

<input
    @disabled($disabled)
    {{ $attributes->merge(["class" => "border-x-0 border-t-0 border-b-2 border-slate-400 "]) }}
/>

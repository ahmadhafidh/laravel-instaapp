<nav class="fixed bottom-0 -mx-4 w-full max-w-md bg-white">
    <ul class="flex justify-around py-4">
        <li>
            <a href="{{ route("home") }}">
                <x-heroicon-m-home
                    class="h-6 w-6 {{ request()->routeIs('home') ? 'text-teal-700' : 'text-slate-600' }}"
                />
            </a>
        </li>
        <li>
            <a href="{{ route("posts.search.form") }}">
                <x-heroicon-m-magnifying-glass
                    class="h-6 w-6 {{ request()->routeIs('posts.search.form') ? 'text-teal-700' : 'text-slate-600' }}"
                />
            </a>
        </li>
        <li>
            <a href="{{ route("posts.create") }}">
                <x-heroicon-m-plus
                    class="h-6 w-6 {{ request()->routeIs('posts.create') ? 'text-teal-700' : 'text-slate-600' }}"
                />
            </a>
        </li>
        <li>
            <a href="{{ route("profile.view") }}">
                <x-heroicon-o-user
                    class="h-6 w-6 {{ request()->routeIs('profile.view') ? 'text-teal-700' : 'text-slate-600' }}"
                />
            </a>
        </li>
    </ul>
</nav>

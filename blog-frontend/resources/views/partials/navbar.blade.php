<nav class="border-b border-gray-200 bg-white">
    <div class="mx-auto max-w-7xl px-5">

    <div class="flex h-20 items-center">

        <a
            href="/"
            class="text-3xl font-bold tracking-[3px] text-gray-900"
        >
            KLE
        </a>

        <div class="ml-auto hidden items-center gap-6 min-[768px]:flex">

            <a
                href="/"
                class="text-gray-700 transition hover:text-black"
            >
                Anasayfa
            </a>

            <a
                href="/categories"
                class="text-gray-700 transition hover:text-black"
            >
                Kategoriler
            </a>

            @if (session('api_token'))

                <a
                    href="/dashboard"
                    class="text-gray-700 transition hover:text-black"
                >
                    Profil
                </a>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    class="inline"
                >
                    @csrf

                    <button
                        type="submit"
                        class="rounded-lg bg-black px-5 py-2.5 text-white transition hover:bg-gray-800"
                    >
                        Çıkış Yap
                    </button>
                </form>

            @else

                <a
                    href="/login"
                    class="text-gray-700 transition hover:text-black"
                >
                    Giriş Yap
                </a>

                <a
                    href="/register"
                    class="rounded-lg bg-black px-5 py-2.5 text-white transition hover:bg-gray-800"
                >
                    Kayıt Ol
                </a>

            @endif

        </div>


        <button
            id="navbar-toggler"
            type="button"
            class="ml-auto rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 min-[768px]:hidden"
            aria-label="Menüyü aç"
            aria-expanded="false"
        >
            Menü
        </button>

    </div>


    <div
        id="navbar-menu"
        class="hidden border-t border-gray-100 py-4 min-[768px]:hidden"
    >

        <div class="flex flex-col gap-2">

            <a
                href="/"
                class="rounded-lg px-4 py-3 text-gray-700 transition hover:bg-gray-100 hover:text-black"
            >
                Anasayfa
            </a>

            <a
                href="/categories"
                class="rounded-lg px-4 py-3 text-gray-700 transition hover:bg-gray-100 hover:text-black"
            >
                Kategoriler
            </a>

            @if (session('api_token'))

                <a
                    href="/dashboard"
                    class="rounded-lg px-4 py-3 text-gray-700 transition hover:bg-gray-100 hover:text-black"
                >
                    Profil
                </a>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="mt-1 w-full rounded-lg bg-black px-4 py-3 text-center text-white transition hover:bg-gray-800"
                    >
                        Çıkış Yap
                    </button>
                </form>

            @else

                <a
                    href="/login"
                    class="rounded-lg px-4 py-3 text-gray-700 transition hover:bg-gray-100 hover:text-black"
                >
                    Giriş Yap
                </a>

                <a
                    href="/register"
                    class="mt-1 rounded-lg bg-black px-4 py-3 text-center text-white transition hover:bg-gray-800"
                >
                    Kayıt Ol
                </a>

            @endif

        </div>

    </div>

</div>

</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const toggler = document.getElementById('navbar-toggler');
        const menu = document.getElementById('navbar-menu');

        toggler.addEventListener('click', function () {

            menu.classList.toggle('hidden');

            const isOpen = !menu.classList.contains('hidden');

            toggler.setAttribute(
                'aria-expanded',
                String(isOpen)
            );

        });

    });
</script>

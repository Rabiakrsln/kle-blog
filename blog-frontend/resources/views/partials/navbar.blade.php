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

            <a
                id="login-link"
                href="/login"
                class="text-gray-700 transition hover:text-black"
            >
                Giriş Yap
            </a>

            <a
                id="register-link"
                href="/register"
                class="rounded-lg bg-black px-5 py-2.5 text-white transition hover:bg-gray-800"
            >
                Kayıt Ol
            </a>

            <a
                id="dashboard-link"
                href="/dashboard"
                class="hidden text-gray-700 transition hover:text-black"
            >
                Profil
            </a>

            <button
                id="logout-button"
                type="button"
                class="hidden rounded-lg bg-black px-5 py-2.5 text-white transition hover:bg-gray-800"
            >
                Çıkış Yap
            </button>

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

            <a
                id="mobile-login-link"
                href="/login"
                class="rounded-lg px-4 py-3 text-gray-700 transition hover:bg-gray-100 hover:text-black"
            >
                Giriş Yap
            </a>

            <a
                id="mobile-register-link"
                href="/register"
                class="mt-1 rounded-lg bg-black px-4 py-3 text-center text-white transition hover:bg-gray-800"
            >
                Kayıt Ol
            </a>

            <a
                id="mobile-dashboard-link"
                href="/dashboard"
                class="hidden rounded-lg px-4 py-3 text-gray-700 transition hover:bg-gray-100 hover:text-black"
            >
                Profil
            </a>

            <button
                id="mobile-logout-button"
                type="button"
                class="hidden mt-1 rounded-lg bg-black px-4 py-3 text-center text-white transition hover:bg-gray-800"
            >
                Çıkış Yap
            </button>

        </div>

    </div>

</div>

</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const token = localStorage.getItem('token');

        const loginLink = document.getElementById('login-link');
        const registerLink = document.getElementById('register-link');
        const dashboardLink = document.getElementById('dashboard-link');
        const logoutButton = document.getElementById('logout-button');

        const mobileLoginLink = document.getElementById('mobile-login-link');
        const mobileRegisterLink = document.getElementById('mobile-register-link');
        const mobileDashboardLink = document.getElementById('mobile-dashboard-link');
        const mobileLogoutButton = document.getElementById('mobile-logout-button');


        if (token) {

            loginLink.classList.add('hidden');
            registerLink.classList.add('hidden');

            dashboardLink.classList.remove('hidden');
            logoutButton.classList.remove('hidden');

            mobileLoginLink.classList.add('hidden');
            mobileRegisterLink.classList.add('hidden');

            mobileDashboardLink.classList.remove('hidden');
            mobileLogoutButton.classList.remove('hidden');

        }


        async function logout() {

            if (token) {

                await fetch('http://localhost:8000/api/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });

            }

            localStorage.removeItem('token');
            localStorage.removeItem('user');

            window.location.href = '/login';
        }


        logoutButton.addEventListener('click', logout);
        mobileLogoutButton.addEventListener('click', logout);


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

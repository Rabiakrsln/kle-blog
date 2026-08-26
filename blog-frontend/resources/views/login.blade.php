@extends('layouts.app')

@section('content')

    <section class="min-h-[calc(100vh-80px)] bg-gray-50">
        <div class="mx-auto flex max-w-7xl justify-center px-5 py-20 lg:py-24">

            <div class="w-full max-w-md">

                <div class="text-center">

                    <p class="text-sm font-semibold uppercase tracking-[3px] text-gray-500">
                        KLE BLOG
                    </p>

                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Hoş geldin
                    </h1>

                </div>


                <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">

                    <form id="login-form">

                        <div>

                            <label
                                for="email"
                                class="text-sm font-medium text-gray-900"
                            >
                                E-posta
                            </label>

                            <input
                                id="email"
                                type="email"
                                placeholder="ornek@mail.com"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-500 focus:ring-2 focus:ring-gray-100"
                            >

                        </div>


                        <div class="mt-5">

                            <label
                                for="password"
                                class="text-sm font-medium text-gray-900"
                            >
                                Şifre
                            </label>

                            <input
                                id="password"
                                type="password"
                                placeholder="••••••••"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-500 focus:ring-2 focus:ring-gray-100"
                            >

                        </div>


                        <p
                            id="login-message"
                            class="mt-5 hidden rounded-xl px-4 py-3 text-sm"
                        ></p>


                        <button
                            id="login-button"
                            type="submit"
                            class="mt-6 w-full rounded-xl bg-black px-5 py-3.5 text-sm font-medium text-white transition hover:bg-gray-800"
                        >
                            Giriş Yap
                        </button>

                    </form>


                    <div class="mt-7 border-t border-gray-100 pt-6 text-center">

                        <p class="text-sm text-gray-500">
                            Henüz hesabın yok mu?

                            <a
                                href="/register"
                                class="font-semibold text-gray-900 hover:underline"
                            >
                                Kayıt Ol
                            </a>
                        </p>

                    </div>

                </div>

            </div>

        </div>
    </section>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const form = document.getElementById('login-form');
            const button = document.getElementById('login-button');
            const message = document.getElementById('login-message');


            form.addEventListener('submit', async function (event) {

                event.preventDefault();


                const email =
                    document.getElementById('email').value.trim();

                const password =
                    document.getElementById('password').value;


                message.classList.add('hidden');

                message.classList.remove(
                    'bg-red-50',
                    'text-red-600',
                    'bg-green-50',
                    'text-green-600'
                );


                if (!email || !password) {

                    message.textContent =
                        'Lütfen e-posta ve şifre alanlarını doldur.';

                    message.classList.remove('hidden');

                    message.classList.add(
                        'bg-red-50',
                        'text-red-600'
                    );

                    return;
                }


                button.disabled = true;
                button.textContent = 'Giriş yapılıyor...';


                try {

                    const response = await fetch(
                        'http://localhost:8000/api/login',
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },

                            body: JSON.stringify({
                                email: email,
                                password: password
                            })
                        }
                    );


                    const data = await response.json();


                    if (!response.ok) {

                        let errorMessage =
                            'Giriş başarısız.';


                        if (response.status === 422 && data.errors) {

                            const errors =
                                Object.values(data.errors)
                                    .flat()
                                    .map(error => {

                                        if (error === 'validation.required') {
                                            return 'Lütfen e-posta ve şifre alanlarını doldur.';
                                        }

                                        if (error === 'validation.email') {
                                            return 'Lütfen geçerli bir e-posta adresi gir.';
                                        }

                                        return error;
                                    });

                            errorMessage = errors.join(' ');

                        } else if (data.message) {

                            errorMessage = data.message;
                        }


                        message.textContent = errorMessage;

                        message.classList.remove('hidden');

                        message.classList.add(
                            'bg-red-50',
                            'text-red-600'
                        );

                        return;
                    }


                    if (!data.token) {

                        message.textContent =
                            'Giriş başarılı ancak token alınamadı.';

                        message.classList.remove('hidden');

                        message.classList.add(
                            'bg-red-50',
                            'text-red-600'
                        );

                        return;
                    }


                    localStorage.setItem(
                        'token',
                        data.token
                    );

                    localStorage.setItem(
                        'user',
                        JSON.stringify(data.user)
                    );


                    message.textContent =
                        'Giriş başarılı! Ana sayfaya yönlendiriliyorsun...';

                    message.classList.remove('hidden');

                    message.classList.add(
                        'bg-green-50',
                        'text-green-600'
                    );


                    setTimeout(function () {

                        window.location.href = '/';

                    }, 1000);


                } catch (error) {

                    console.error(error);

                    message.textContent =
                        'Sunucuya bağlanırken bir hata oluştu.';

                    message.classList.remove('hidden');

                    message.classList.add(
                        'bg-red-50',
                        'text-red-600'
                    );

                } finally {

                    button.disabled = false;
                    button.textContent = 'Giriş Yap';

                }

            });

        });

    </script>

@endsection
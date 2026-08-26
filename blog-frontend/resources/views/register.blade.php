@extends('layouts.app')

@section('content')

    <section class="min-h-[calc(100vh-80px)] bg-gray-50">
        <div class="mx-auto flex max-w-7xl justify-center px-5 py-16 lg:py-20">

            <div class="w-full max-w-md">

                <div class="text-center">

                    <p class="text-sm font-semibold uppercase tracking-[3px] text-gray-500">
                        KLE BLOG
                    </p>

                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Hesabını oluştur
                    </h1>

                    <p class="mt-4 text-sm leading-6 text-gray-600">
                        KLE Blog'a katıl ve kendi yazılarını paylaşmaya başla.
                    </p>

                </div>


                <div class="mt-10 rounded-2xl border border-gray-200 bg-white p-7 shadow-sm sm:p-8">

                    <form id="register-form">

                        <div>

                            <label
                                for="name"
                                class="text-sm font-medium text-gray-900"
                            >
                                Ad Soyad
                            </label>

                            <input
                                id="name"
                                type="text"
                                placeholder="Ad Soyad"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-500 focus:ring-2 focus:ring-gray-100"
                            >

                        </div>


                        <div class="mt-5">

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


                        <div class="mt-5">

                            <label
                                for="password_confirmation"
                                class="text-sm font-medium text-gray-900"
                            >
                                Şifre Tekrar
                            </label>

                            <input
                                id="password_confirmation"
                                type="password"
                                placeholder="••••••••"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-500 focus:ring-2 focus:ring-gray-100"
                            >

                        </div>


                        <div class="mt-5 flex items-start gap-3">

                            <input
                                id="agreement"
                                type="checkbox"
                                class="mt-1 h-4 w-4 rounded border-gray-300"
                            >

                            <label
                                for="agreement"
                                class="text-sm leading-6 text-gray-600"
                            >
                                Kullanım koşullarını ve gizlilik politikasını
                                kabul ediyorum.
                            </label>

                        </div>


                        <p
                            id="register-message"
                            class="mt-5 hidden rounded-xl px-4 py-3 text-sm"
                        ></p>


                        <button
                            id="register-button"
                            type="submit"
                            class="mt-7 w-full rounded-xl bg-black px-5 py-3.5 text-sm font-medium text-white transition hover:bg-gray-800"
                        >
                            Kayıt Ol
                        </button>

                    </form>


                    <div class="mt-7 border-t border-gray-100 pt-6 text-center">

                        <p class="text-sm text-gray-500">
                            Zaten hesabın var mı?

                            <a
                                href="/login"
                                class="font-semibold text-gray-900 hover:underline"
                            >
                                Giriş Yap
                            </a>
                        </p>

                    </div>

                </div>

            </div>

        </div>
    </section>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const form = document.getElementById('register-form');
            const button = document.getElementById('register-button');
            const message = document.getElementById('register-message');

            form.addEventListener('submit', async function (event) {

                event.preventDefault();

                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value;
                const passwordConfirmation =
                    document.getElementById('password_confirmation').value;

                const agreement =
                    document.getElementById('agreement').checked;


                message.classList.add('hidden');
                message.classList.remove(
                    'bg-red-50',
                    'text-red-600',
                    'bg-green-50',
                    'text-green-600'
                );


                if (!name || !email || !password || !passwordConfirmation) {

                    message.textContent = 'Lütfen tüm alanları doldur.';
                    message.classList.remove('hidden');
                    message.classList.add('bg-red-50', 'text-red-600');

                    return;
                }


                if (password !== passwordConfirmation) {

                    message.textContent = 'Şifreler eşleşmiyor.';
                    message.classList.remove('hidden');
                    message.classList.add('bg-red-50', 'text-red-600');

                    return;
                }


                if (!agreement) {

                    message.textContent =
                        'Devam etmek için kullanım koşullarını kabul etmelisin.';

                    message.classList.remove('hidden');
                    message.classList.add('bg-red-50', 'text-red-600');

                    return;
                }


                button.disabled = true;
                button.textContent = 'Kaydediliyor...';


                try {

                    const response = await fetch(
                        'http://localhost:8000/api/register',
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },

                            body: JSON.stringify({
                                name: name,
                                email: email,
                                password: password,
                                password_confirmation: passwordConfirmation
                            })
                        }
                    );


                    const data = await response.json();


                    if (!response.ok) {

                        let errorMessage = 'Kayıt sırasında bir hata oluştu.';

                        if (response.status === 422) {

                            if (data.errors) {

                                const errors = Object.values(data.errors)
                                    .flat()
                                    .map(error => {

                                        if (error === 'validation.unique') {
                                            return 'Bu e-posta adresi zaten kayıtlı.';
                                        }

                                        if (error === 'validation.required') {
                                            return 'Lütfen tüm zorunlu alanları doldur.';
                                        }

                                        if (error === 'validation.email') {
                                            return 'Lütfen geçerli bir e-posta adresi gir.';
                                        }

                                        if (error === 'validation.min') {
                                            return 'Şifre en az 8 karakter olmalıdır.';
                                        }

                                        if (error === 'validation.confirmed') {
                                            return 'Şifreler eşleşmiyor.';
                                        }

                                        return error;
                                    });

                                errorMessage = errors.join(' ');
                            } else if (data.message) {

                                errorMessage = data.message;
                            }
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


                    message.textContent =
                        'Kayıt başarılı! Giriş sayfasına yönlendiriliyorsun...';

                    message.classList.remove('hidden');
                    message.classList.add(
                        'bg-green-50',
                        'text-green-600'
                    );


                    if (data.token) {

                        localStorage.setItem('token', data.token);
                    }


                    setTimeout(function () {
                        window.location.href = '/login';
                    }, 1500);


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
                    button.textContent = 'Kayıt Ol';

                }

            });

        });

    </script>

@endsection
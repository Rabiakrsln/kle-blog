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

            @if ($errors->has('login'))

                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3">

                    <p class="text-sm text-red-600">
                        {{ $errors->first('login') }}
                    </p>

                </div>

            @endif


            @if ($errors->any() && !$errors->has('login'))

                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3">

                    @foreach ($errors->all() as $error)

                        <p class="text-sm text-red-600">
                            {{ $error }}
                        </p>

                    @endforeach

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('login.submit') }}"
            >

                @csrf


                <div>

                    <label
                        for="email"
                        class="text-sm font-medium text-gray-900"
                    >
                        E-posta
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        placeholder="ornek@mail.com"
                        required
                        autocomplete="email"
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
                        name="password"
                        type="password"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                        class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-500 focus:ring-2 focus:ring-gray-100"
                    >

                </div>


                <button
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
                        href="{{ url('/register') }}"
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

@endsection

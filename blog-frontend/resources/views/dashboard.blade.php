@extends('layouts.app')

@section('content')

<section class="bg-gray-50">
    <div class="mx-auto max-w-5xl px-5 py-20">

    <div class="mb-10">

        <p class="text-sm font-semibold uppercase tracking-[2px] text-gray-500">
            KLE BLOG
        </p>

        <h1 class="mt-3 text-3xl font-bold text-gray-900">
            Kullanıcı Paneli
        </h1>

        <p class="mt-3 text-gray-600">
            Hesap bilgilerini, yazılarını ve yorumlarını buradan görebilirsin.
        </p>

    </div>


    <div class="rounded-2xl border border-gray-200 bg-white p-8">

        <h2 class="text-xl font-bold text-gray-900">
            Hesap Bilgileri
        </h2>

        @if (session('success'))
            <div class="mt-6 rounded-xl border border-green-200 bg-green-50 p-4">
                <p class="text-sm text-green-700">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        @if ($errors->has('profile'))
            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4">
                <p class="text-sm text-red-700">
                    {{ $errors->first('profile') }}
                </p>
            </div>
        @endif


        <form
            method="POST"
            action="{{ route('dashboard.profile.update') }}"
            class="mt-6 space-y-6"
        >

            @csrf
            @method('PUT')


            <div>

                <label
                    for="name"
                    class="block text-sm font-medium text-gray-700"
                >
                    Ad Soyad
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $user['name'] ?? '') }}"
                    required
                    class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-gray-900 focus:outline-none"
                >

                @error('name')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            <div>

                <label
                    for="email"
                    class="block text-sm font-medium text-gray-700"
                >
                    E-posta
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $user['email'] ?? '') }}"
                    required
                    class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-gray-900 focus:outline-none"
                >

                @error('email')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            <button
                type="submit"
                class="mt-2 block w-full rounded-xl bg-black px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-gray-800 sm:w-auto"
            >
                Profili Güncelle
            </button>

        </form>

    </div>


    <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-8">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm font-semibold uppercase tracking-[2px] text-gray-500">
                    İçerikler
                </p>

                <h2 class="mt-2 text-2xl font-bold text-gray-900">
                    Yazılarım
                </h2>

            </div>

            <span class="text-sm text-gray-500">
                {{ count($posts) }} yazı
            </span>

        </div>


        <div class="mt-6 space-y-4">

            @forelse ($posts as $post)

                <article class="rounded-xl border border-gray-200 p-6">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                        <div>

                            <h3 class="text-lg font-bold text-gray-900">
                                {{ $post['title'] ?? '' }}
                            </h3>

                            <p class="mt-2 text-sm text-gray-500">
                                {{ $post['category']['name'] ?? 'Genel' }}
                            </p>

                        </div>


                        @if (($post['status'] ?? '') === 'approved')

                            <span class="w-fit rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700">
                                Onaylandı
                            </span>

                        @else

                            <span class="w-fit rounded-full bg-yellow-50 px-3 py-1 text-xs font-medium text-yellow-700">
                                Bekliyor
                            </span>

                        @endif

                    </div>


                    @if (($post['status'] ?? '') === 'approved' && !empty($post['slug']))

                        <div class="mt-5 border-t border-gray-100 pt-4">

                            <a
                                href="{{ url('/posts/' . $post['slug']) }}"
                                class="text-sm font-semibold text-gray-900 hover:underline"
                            >
                                Yazıyı Gör →
                            </a>

                        </div>

                    @endif

                </article>

            @empty

                <div class="rounded-xl border border-gray-200 bg-gray-50 p-6">

                    <p class="text-sm text-gray-500">
                        Henüz yazdığın bir yazı bulunmuyor.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

    <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-8">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm font-semibold uppercase tracking-[2px] text-gray-500">
                    Etkileşimler
                </p>

                <h2 class="mt-2 text-2xl font-bold text-gray-900">
                    Yorumlarım
                </h2>

            </div>

            <span class="text-sm text-gray-500">
                {{ count($comments) }} yorum
            </span>

        </div>


        <div class="mt-6 space-y-4">

            @forelse ($comments as $comment)

                <article class="rounded-xl border border-gray-200 p-6">

                    <div class="flex items-start justify-between gap-4">

                        <div class="flex-1">

                            <p class="text-sm leading-7 text-gray-700">
                                {{ $comment['content'] ?? '' }}
                            </p>

                        </div>


                        @if (($comment['status'] ?? '') === 'approved')

                            <span class="shrink-0 rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700">
                                Onaylandı
                            </span>

                        @else

                            <span class="shrink-0 rounded-full bg-yellow-50 px-3 py-1 text-xs font-medium text-yellow-700">
                                Bekliyor
                            </span>

                        @endif

                    </div>


                    <div class="mt-5 flex flex-col gap-2 border-t border-gray-100 pt-4 sm:flex-row sm:items-center sm:justify-between">

                        <p class="text-sm text-gray-500">

                            @if (!empty($comment['post']['title']))
                                Yazı: {{ $comment['post']['title'] }}
                            @else
                                Yazı bilgisi bulunamadı.
                            @endif

                        </p>


                        @if (!empty($comment['created_at']))

                            <span class="text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($comment['created_at'])->translatedFormat('d F Y') }}
                            </span>

                        @endif

                    </div>

                </article>

            @empty

                <div class="rounded-xl border border-gray-200 bg-gray-50 p-6">

                    <p class="text-sm text-gray-500">
                        Henüz yaptığın bir yorum bulunmuyor.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

</section>

@endsection
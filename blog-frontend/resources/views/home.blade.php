@extends('layouts.app')

@section('content')

<section class="border-b border-gray-200 bg-white">
    <div class="mx-auto max-w-7xl px-5 py-20 lg:py-24">

    <div class="max-w-6xl">

        <p class="mb-6 text-sm font-semibold uppercase tracking-[3px] text-gray-500">
            KLE BLOG
        </p>

        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">
            Yeni fikirler,
            <span class="text-gray-500">yeni bakış açıları.</span>
        </h1>

        <p class="mt-6 max-w-2xl text-lg leading-8 text-gray-600">
            Yazılım, teknoloji, tasarım ve daha fazlası hakkında
            yayınlanan tüm yazıları keşfet.
        </p>

        {{-- FİLTRELER --}}
        <form
            method="GET"
            action="{{ route('home') }}"
            class="mt-10 rounded-2xl border border-gray-200 bg-gray-50 p-6"
        >

            <div class="grid gap-4 lg:grid-cols-12">

                {{-- Arama --}}
                <div class="lg:col-span-3">

                    <label
                        for="search"
                        class="mb-2 block text-sm font-medium text-gray-900"
                    >
                        Yazı ara
                    </label>

                    <input
                        id="search"
                        name="search"
                        type="text"
                        value="{{ request('search') }}"
                        placeholder="Yazı başlığında ara..."
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-500 focus:ring-2 focus:ring-gray-100"
                    >

                </div>

                {{-- Kategori --}}
                <div class="lg:col-span-3">

                    <label
                        for="category"
                        class="mb-2 block text-sm font-medium text-gray-900"
                    >
                        Kategori
                    </label>

                    <select
                        id="category"
                        name="category"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-gray-500 focus:ring-2 focus:ring-gray-100"
                    >

                        <option value="">
                            Tüm kategoriler
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category['slug'] }}"
                                @selected(request('category') === $category['slug'])
                            >
                                {{ $category['name'] }}
                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Tarih --}}
                <div class="lg:col-span-2">

                    <label
                        for="date"
                        class="mb-2 block text-sm font-medium text-gray-900"
                    >
                        Tarih
                    </label>

                    <select
                        id="date"
                        name="date"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-gray-500 focus:ring-2 focus:ring-gray-100"
                    >

                        <option value="">
                            Tüm tarihler
                        </option>

                        <option
                            value="today"
                            @selected(request('date') === 'today')
                        >
                            Bugün
                        </option>

                        <option
                            value="week"
                            @selected(request('date') === 'week')
                        >
                            Bu hafta
                        </option>

                        <option
                            value="month"
                            @selected(request('date') === 'month')
                        >
                            Bu ay
                        </option>

                        <option
                            value="year"
                            @selected(request('date') === 'year')
                        >
                            Bu yıl
                        </option>

                    </select>

                </div>

                {{-- Yazar --}}
                <div class="lg:col-span-2">

                    <label
                        for="author"
                        class="mb-2 block text-sm font-medium text-gray-900"
                    >
                        Yazar
                    </label>

                    <select
                        id="author"
                        name="author"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-gray-500 focus:ring-2 focus:ring-gray-100"
                    >

                        <option value="">
                            Tüm yazarlar
                        </option>

                        @php
                            $authors = collect($posts)
                                ->filter(fn ($post) => isset($post['user']['id']))
                                ->map(fn ($post) => $post['user'])
                                ->unique('id')
                                ->values();
                        @endphp

                        @foreach($authors as $author)

                            <option
                                value="{{ $author['id'] }}"
                                @selected((string) request('author') === (string) $author['id'])
                            >
                                {{ $author['name'] }}
                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Butonlar --}}
                <div class="flex items-end gap-2 lg:col-span-2">

                    <button
                        type="submit"
                        class="flex-1 rounded-xl bg-black px-5 py-3 text-sm font-medium text-white transition hover:bg-gray-800"
                    >
                        Ara
                    </button>

                    <a
                        href="{{ route('home') }}"
                        class="flex-1 rounded-xl border border-gray-300 bg-white px-4 py-3 text-center text-sm font-medium text-gray-700 transition hover:bg-gray-100"
                    >
                        Temizle
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

</section>

<section class="bg-gray-50">

<div class="mx-auto max-w-7xl px-5 py-16">

    <div class="mb-10 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

        <div>

            <p class="text-sm font-semibold uppercase tracking-[2px] text-gray-500">
                Blog
            </p>

            <h2 class="mt-2 text-3xl font-bold text-gray-900">
                Tüm Yazılar
            </h2>

            <p class="mt-3 text-gray-600">
                Yayınlanan tüm yazıları keşfet.
            </p>

        </div>

        <div class="flex items-center gap-4">

            <p class="text-sm text-gray-500">
                {{ count($posts) }} yazı
            </p>

            <a
                href="{{ url('/posts/create') }}"
                class="rounded-xl bg-black px-5 py-3 text-sm font-medium text-white transition hover:bg-gray-800"
            >
                + Yazı Ekle
            </a>

        </div>

    </div>


    {{-- FİLTRE MESAJI --}}
    @if(request()->hasAny(['search', 'category', 'date', 'author']))

        <div class="mb-6 rounded-xl bg-green-50 px-4 py-3 text-sm text-green-600">
            {{ count($posts) }} yazı bulundu.
        </div>

    @endif


    {{-- YAZILAR --}}
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

        @forelse($posts as $post)

            <article
                class="group rounded-2xl border border-gray-200 bg-white p-7 transition duration-300 hover:-translate-y-1 hover:border-gray-300 hover:shadow-lg"
            >

                <div class="flex items-center justify-between gap-3">

                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                        {{ $post['category']['name'] ?? 'Genel' }}
                    </span>

                    <span class="text-xs text-gray-400">

                        @if(!empty($post['published_at']))
                            {{ \Carbon\Carbon::parse($post['published_at'])->format('d F Y') }}
                        @endif

                    </span>

                </div>


                <h3 class="mt-7 text-xl font-bold tracking-tight text-gray-900">
                    {{ $post['title'] ?? '' }}
                </h3>


                <p class="mt-4 text-sm leading-6 text-gray-600">
                    {{ $post['excerpt'] ?? '' }}
                </p>


                <div class="mt-8 flex items-center justify-between border-t border-gray-100 pt-5">

                    <span class="text-sm text-gray-500">
                        {{ $post['user']['name'] ?? 'Bilinmeyen yazar' }}
                    </span>

                    <a
                        href="{{ url('/posts/' . $post['slug']) }}"
                        class="text-sm font-semibold text-gray-900 transition hover:underline"
                    >
                        Yazıyı Oku →
                    </a>

                </div>

            </article>

        @empty

            <div class="col-span-full rounded-2xl border border-gray-200 bg-white p-10 text-center">

                <h3 class="text-xl font-semibold text-gray-900">
                    Sonuç bulunamadı.
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Arama veya filtre kriterlerini değiştirmeyi deneyebilirsin.
                </p>

            </div>

        @endforelse

    </div>

</div>

</section>

@endsection

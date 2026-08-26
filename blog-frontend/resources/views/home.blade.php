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

                <div class="mt-10 rounded-2xl border border-gray-200 bg-gray-50 p-6">

                    <div class="grid gap-4 lg:grid-cols-12">

                        <div class="lg:col-span-4">

                            <label
                                for="search"
                                class="mb-2 block text-sm font-medium text-gray-900"
                            >
                                Yazı ara
                            </label>

                            <input
                                id="search"
                                type="text"
                                placeholder="Yazı başlığında ara..."
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-500 focus:ring-2 focus:ring-gray-100"
                            >

                        </div>

                        <div class="lg:col-span-3">

                            <label
                                for="category"
                                class="mb-2 block text-sm font-medium text-gray-900"
                            >
                                Kategori
                            </label>

                            <select
                                id="category"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-gray-500 focus:ring-2 focus:ring-gray-100"
                            >

                                <option value="">
                                    Tüm kategoriler
                                </option>

                                @php
                                    $categories = collect($posts)
                                        ->filter(fn ($post) => isset($post['category']['slug']))
                                        ->map(fn ($post) => $post['category'])
                                        ->unique('slug')
                                        ->values();
                                @endphp

                                @foreach($categories as $category)

                                    <option value="{{ $category['slug'] }}">
                                        {{ $category['name'] }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="lg:col-span-2">

                            <label
                                for="date"
                                class="mb-2 block text-sm font-medium text-gray-900"
                            >
                                Tarih
                            </label>

                            <select
                                id="date"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-gray-500 focus:ring-2 focus:ring-gray-100"
                            >

                                <option value="">
                                    Tüm tarihler
                                </option>

                                <option value="today">
                                    Bugün
                                </option>

                                <option value="week">
                                    Bu hafta
                                </option>

                                <option value="month">
                                    Bu ay
                                </option>

                                <option value="year">
                                    Bu yıl
                                </option>

                            </select>

                        </div>

                        <div class="flex items-end gap-2 lg:col-span-3">

                            <button
                                type="button"
                                id="search-button"
                                class="flex-1 rounded-xl bg-black px-5 py-3 text-sm font-medium text-white transition hover:bg-gray-800"
                            >
                                Ara
                            </button>

                            <button
                                type="button"
                                id="clear-button"
                                class="flex-1 rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
                            >
                                Temizle
                            </button>

                        </div>

                    </div>

                    <p
                        id="filter-message"
                        class="mt-4 hidden rounded-xl px-4 py-3 text-sm"
                    ></p>

                </div>

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

                    <p
                        id="post-count"
                        class="text-sm text-gray-500"
                    >
                        {{ count($posts) }} yazı
                    </p>

                    <a
                        href="/posts/create"
                        class="rounded-xl bg-black px-5 py-3 text-sm font-medium text-white transition hover:bg-gray-800"
                    >
                        + Yazı Ekle
                    </a>

                </div>

            </div>

            <div
                id="posts-container"
                class="grid gap-6 md:grid-cols-2 lg:grid-cols-3"
            >

                @forelse($posts as $post)

                    <article
                        class="post-card group rounded-2xl border border-gray-200 bg-white p-7 transition duration-300 hover:-translate-y-1 hover:border-gray-300 hover:shadow-lg"
                    >

                        <div class="flex items-center justify-between gap-3">

                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                {{ $post['category']['name'] ?? 'Genel' }}
                            </span>

                            <span class="text-xs text-gray-400">

                                @if(isset($post['published_at']))
                                    {{ \Carbon\Carbon::parse($post['published_at'])->format('d F Y') }}
                                @endif

                            </span>

                        </div>

                        <h3 class="mt-7 text-xl font-bold tracking-tight text-gray-900">
                            {{ $post['title'] }}
                        </h3>

                        <p class="mt-4 text-sm leading-6 text-gray-600">
                            {{ $post['excerpt'] ?? '' }}
                        </p>

                        <div class="mt-8 flex items-center justify-between border-t border-gray-100 pt-5">

                            <span class="text-sm text-gray-500">
                                {{ $post['user']['name'] ?? 'Bilinmeyen yazar' }}
                            </span>

                            <a
                                href="/posts/{{ $post['id'] }}"
                                class="text-sm font-semibold text-gray-900 transition hover:underline"
                            >
                                Yazıyı Oku →
                            </a>

                        </div>

                    </article>

                @empty

                    <div class="col-span-full rounded-2xl border border-gray-200 bg-white p-10 text-center">

                        <h3 class="text-xl font-semibold text-gray-900">
                            Henüz yazı bulunmuyor.
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Yayınlanan yazılar burada görünecek.
                        </p>

                    </div>

                @endforelse

            </div>

            <div
                id="no-results"
                class="mt-6 hidden rounded-2xl border border-gray-200 bg-white p-10 text-center"
            >

                <h3 class="text-xl font-semibold text-gray-900">
                    Sonuç bulunamadı.
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Arama veya filtre kriterlerini değiştirmeyi deneyebilirsin.
                </p>

            </div>

        </div>

    </section>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const searchInput = document.getElementById('search');
            const categorySelect = document.getElementById('category');
            const dateSelect = document.getElementById('date');

            const searchButton = document.getElementById('search-button');
            const clearButton = document.getElementById('clear-button');

            const postsContainer = document.getElementById('posts-container');
            const postCount = document.getElementById('post-count');
            const noResults = document.getElementById('no-results');
            const filterMessage = document.getElementById('filter-message');

            function showMessage(text, type = 'error') {

                filterMessage.textContent = text;

                filterMessage.classList.remove(
                    'hidden',
                    'bg-red-50',
                    'text-red-600',
                    'bg-green-50',
                    'text-green-600'
                );

                if (type === 'success') {

                    filterMessage.classList.add(
                        'bg-green-50',
                        'text-green-600'
                    );

                } else {

                    filterMessage.classList.add(
                        'bg-red-50',
                        'text-red-600'
                    );

                }

            }

            function hideMessage() {

                filterMessage.classList.add('hidden');

            }

            async function loadCategories() {

                try {

                    const response = await fetch(
                        'http://localhost:8000/api/categories',
                        {
                            headers: {
                                'Accept': 'application/json'
                            }
                        }
                    );

                    const data = await response.json();

                    if (!response.ok) {
                        return;
                    }

                    categorySelect.innerHTML =
                        '<option value="">Tüm kategoriler</option>';

                    (data.data ?? []).forEach(function (category) {

                        const option = document.createElement('option');

                        option.value = category.slug;
                        option.textContent = category.name;

                        categorySelect.appendChild(option);

                    });

                } catch (error) {

                    console.error(error);

                }

            }

            async function loadPosts() {

                const params = new URLSearchParams();

                const search = searchInput.value.trim();
                const category = categorySelect.value;
                const date = dateSelect.value;

                if (search) {
                    params.append('search', search);
                }

                if (category) {
                    params.append('category', category);
                }

                if (date) {
                    params.append('date', date);
                }

                searchButton.disabled = true;
                searchButton.textContent = 'Aranıyor...';

                hideMessage();

                try {

                    const url =
                        'http://localhost:8000/api/posts?' +
                        params.toString();

                    const response = await fetch(url, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {

                        showMessage(
                            data.message ?? 'Yazılar getirilemedi.'
                        );

                        return;
                    }

                    postsContainer.innerHTML = '';

                    const posts = data.data ?? [];

                    postCount.textContent =
                        posts.length + ' yazı';

                    if (posts.length === 0) {

                        noResults.classList.remove('hidden');

                        return;

                    }

                    noResults.classList.add('hidden');

                    posts.forEach(function (post) {

                        const article =
                            document.createElement('article');

                        const publishedDate =
                            post.published_at
                                ? new Date(
                                    post.published_at
                                ).toLocaleDateString('tr-TR')
                                : '';

                        article.className =
                            'post-card group rounded-2xl border border-gray-200 bg-white p-7 transition duration-300 hover:-translate-y-1 hover:border-gray-300 hover:shadow-lg';

                        article.innerHTML = `

                            <div class="flex items-center justify-between gap-3">

                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                    ${post.category?.name ?? 'Genel'}
                                </span>

                                <span class="text-xs text-gray-400">
                                    ${publishedDate}
                                </span>

                            </div>

                            <h3 class="mt-7 text-xl font-bold tracking-tight text-gray-900">
                                ${post.title ?? ''}
                            </h3>

                            <p class="mt-4 text-sm leading-6 text-gray-600">
                                ${post.excerpt ?? ''}
                            </p>

                            <div class="mt-8 flex items-center justify-between border-t border-gray-100 pt-5">

                                <span class="text-sm text-gray-500">
                                    ${post.user?.name ?? 'Bilinmeyen yazar'}
                                </span>

                                <a
                                    href="/posts/${post.id}"
                                    class="text-sm font-semibold text-gray-900 transition hover:underline"
                                >
                                    Yazıyı Oku →
                                </a>

                            </div>

                        `;

                        postsContainer.appendChild(article);

                    });

                    if (search || category || date) {

                        showMessage(
                            posts.length + ' yazı bulundu.',
                            'success'
                        );

                    }

                } catch (error) {

                    console.error(error);

                    showMessage(
                        'Yazılar yüklenirken bir hata oluştu.'
                    );

                } finally {

                    searchButton.disabled = false;
                    searchButton.textContent = 'Ara';

                }

            }

            searchButton.addEventListener(
                'click',
                function () {
                    loadPosts();
                }
            );

            searchInput.addEventListener(
                'keydown',
                function (event) {

                    if (event.key === 'Enter') {
                        loadPosts();
                    }

                }
            );

            clearButton.addEventListener(
                'click',
                function () {

                    searchInput.value = '';
                    categorySelect.value = '';
                    dateSelect.value = '';

                    hideMessage();

                    loadPosts();

                }
            );

            loadCategories();

        });

    </script>

@endsection
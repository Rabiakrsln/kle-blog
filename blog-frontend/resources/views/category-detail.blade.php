@extends('layouts.app')

@section('content')

    <section class="border-b border-gray-200 bg-white">
        <div class="mx-auto max-w-7xl px-5 py-20 lg:py-24">

            <div class="max-w-3xl">

                <a
                    href="/categories"
                    class="inline-flex items-center text-sm font-medium text-gray-500 transition hover:text-black"
                >
                    ← Kategorilere dön
                </a>

                <p class="mt-10 text-sm font-semibold uppercase tracking-[3px] text-gray-500">
                    KATEGORİ
                </p>

                <h1 class="mt-4 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">
                    {{ $category['name'] }}
                </h1>

                <p class="mt-6 text-lg leading-8 text-gray-600">
                    {{ $category['description'] ?? '' }}
                </p>

            </div>

        </div>
    </section>


    <section class="bg-gray-50">
        <div class="mx-auto max-w-7xl px-5 py-20">

            <div class="mb-12 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <p class="text-sm font-semibold uppercase tracking-[2px] text-gray-500">
                        Yazılar
                    </p>

                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        {{ $category['name'] }} Yazıları
                    </h2>
                </div>

                <span class="text-sm text-gray-500">
                    {{ count($category['posts'] ?? []) }} yazı
                </span>

            </div>


            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                @forelse($category['posts'] ?? [] as $post)

                    <article
                        class="rounded-2xl border border-gray-200 bg-white p-6 transition duration-300 hover:-translate-y-1 hover:shadow-lg"
                    >

                        <div class="mb-4 flex items-center gap-2 text-xs text-gray-500">

                            <span>{{ $category['name'] }}</span>

                            @if(!empty($post['published_at']))
                                <span>•</span>

                                <span>
                                    {{ \Carbon\Carbon::parse($post['published_at'])->format('d F Y') }}
                                </span>
                            @endif

                        </div>


                        <h3 class="text-xl font-bold leading-8 text-gray-900">
                            {{ $post['title'] }}
                        </h3>


                        <p class="mt-4 text-sm leading-7 text-gray-600">
                            {{ $post['excerpt'] ?? '' }}
                        </p>


                        <div class="mt-7 flex items-center justify-between">

                            <span class="text-sm text-gray-500">
                                {{ $post['user']['name'] ?? 'Bilinmeyen yazar' }}
                            </span>

                            <a
                                href="/posts/{{ $post['slug'] }}"
                                class="text-sm font-semibold text-gray-900 transition hover:underline"
                            >
                                Yazıyı Oku →
                            </a>

                        </div>

                    </article>

                @empty

                    <div class="col-span-full rounded-2xl border border-gray-200 bg-white p-6">

                        <p class="text-sm text-gray-500">
                            Bu kategoride henüz yazı bulunmuyor.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>
    </section>

@endsection
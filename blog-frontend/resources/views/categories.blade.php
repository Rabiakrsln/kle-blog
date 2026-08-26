@extends('layouts.app')

@section('content')

    <section class="bg-gray-50">
        <div class="mx-auto max-w-7xl px-5 py-20 lg:py-28">

            <div class="mx-auto max-w-3xl text-center">

                <h1 class="mt-5 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">
                    Kategoriler
                </h1>

                <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-gray-600">
                    Sana uygun içerikleri kolayca bul.
                </p>

            </div>

            <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                @forelse($categories as $category)

                    <a
                        href="/categories/{{ $category['id'] }}"
                        class="group rounded-2xl border border-gray-200 bg-white p-7 transition duration-300 hover:-translate-y-1 hover:border-gray-300 hover:shadow-xl"
                    >

                        <h2 class="mt-10 text-2xl font-semibold tracking-tight text-gray-900">
                            {{ $category['name'] }}
                        </h2>

                        <div class="mt-8 flex items-center justify-between border-t border-gray-100 pt-5">

                            <span class="text-sm font-medium text-gray-700 transition group-hover:text-black">
                                Yazıları Gör
                            </span>

                        </div>

                    </a>

                @empty

                    <div class="col-span-full rounded-2xl border border-gray-200 bg-white p-6 text-center">
                        <p class="text-sm text-gray-500">
                            Henüz kategori bulunmuyor.
                        </p>
                    </div>

                @endforelse

            </div>

        </div>
    </section>

@endsection
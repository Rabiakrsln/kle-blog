@extends('layouts.app')

@section('content')

<section class="bg-gray-50">
    <div class="mx-auto max-w-3xl px-5 py-20">

    <div class="rounded-2xl border border-gray-200 bg-white p-8">

        <p class="text-sm font-semibold uppercase tracking-[2px] text-gray-500">
            KLE BLOG
        </p>

        <h1 class="mt-3 text-3xl font-bold text-gray-900">
            Yeni Yazı Oluştur
        </h1>

        <p class="mt-3 text-gray-600">
            Yeni bir blog yazısı oluşturabilirsin.
        </p>

        @if ($errors->any())

            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3">

                @foreach ($errors->all() as $error)

                    <p class="text-sm text-red-600">
                        {{ $error }}
                    </p>

                @endforeach

            </div>

        @endif

        @if (session('success'))

            <div class="mt-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3">

                <p class="text-sm text-green-600">
                    {{ session('success') }}
                </p>

            </div>

        @endif

        <form
            method="POST"
            action="{{ route('posts.store') }}"
            class="mt-10"
        >

            @csrf

            <div>

                <label
                    for="category_id"
                    class="text-sm font-semibold text-gray-900"
                >
                    Kategori
                </label>

                <select
                    id="category_id"
                    name="category_id"
                    required
                    class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3"
                >

                    <option value="">
                        Kategori seç
                    </option>

                    @foreach ($categories as $category)

                        <option
                            value="{{ $category['id'] }}"
                            {{ old('category_id') == $category['id'] ? 'selected' : '' }}
                        >
                            {{ $category['name'] }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="mt-6">

                <label
                    for="title"
                    class="text-sm font-semibold text-gray-900"
                >
                    Başlık
                </label>

                <input
                    id="title"
                    name="title"
                    type="text"
                    value="{{ old('title') }}"
                    required
                    class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                    placeholder="Yazı başlığı"
                >

            </div>


            <div class="mt-6">

                <label
                    for="excerpt"
                    class="text-sm font-semibold text-gray-900"
                >
                    Özet
                </label>

                <textarea
                    id="excerpt"
                    name="excerpt"
                    rows="3"
                    class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                    placeholder="Yazının kısa özeti"
                >{{ old('excerpt') }}</textarea>

            </div>


            <div class="mt-6">

                <label
                    for="content"
                    class="text-sm font-semibold text-gray-900"
                >
                    İçerik
                </label>

                <textarea
                    id="content"
                    name="content"
                    rows="10"
                    required
                    class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                    placeholder="Yazını buraya yaz..."
                >{{ old('content') }}</textarea>

            </div>


            <div class="mt-8 flex justify-end">

                <button
                    type="submit"
                    class="rounded-xl bg-black px-6 py-3 text-sm font-medium text-white transition hover:bg-gray-800"
                >
                    Yazıyı Gönder
                </button>

            </div>

        </form>

    </div>

</div>

</section>

@endsection

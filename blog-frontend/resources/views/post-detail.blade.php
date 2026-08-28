@extends('layouts.app')

@section('content')

<section class="bg-white">
    <div class="mx-auto max-w-5xl px-5 py-20">

    <a
        href="/"
        class="text-sm font-medium text-gray-500 hover:text-gray-900"
    >
        ← Ana sayfaya dön
    </a>

    <article class="mt-10">

        <p class="text-sm font-semibold uppercase tracking-[2px] text-gray-500">
            KLE BLOG
        </p>

        <h1 class="mt-4 text-4xl font-bold tracking-tight text-gray-900">
            {{ $post['title'] ?? '' }}
        </h1>

        @if (!empty($post['category']['name']))
            <p class="mt-4 text-sm text-gray-500">
                {{ $post['category']['name'] }}
            </p>
        @endif

        @if (!empty($post['published_at']))
            <p class="mt-2 text-sm text-gray-400">
                {{ \Carbon\Carbon::parse($post['published_at'])->translatedFormat('d F Y') }}
            </p>
        @endif

        @if (!empty($post['excerpt']))
            <p class="mt-8 text-lg leading-8 text-gray-600">
                {{ $post['excerpt'] }}
            </p>
        @endif

        <div class="mt-10 border-t border-gray-100 pt-10">
            <div class="whitespace-pre-line text-base leading-8 text-gray-700">
                {{ $post['content'] ?? '' }}
            </div>
        </div>

    </article>

    <section class="mt-16 border-t border-gray-200 pt-10">

        <h2 class="text-2xl font-bold text-gray-900">
            Yorumlar
        </h2>

        @if (count($comments) === 0)

            <p class="mt-6 text-sm text-gray-500">
                Henüz yorum bulunmuyor.
            </p>

        @else

            <div class="mt-6 space-y-4">

                @foreach ($comments as $comment)

                    <div class="rounded-xl border border-gray-200 p-5">

                        <div class="flex items-center justify-between gap-4">

                            <p class="font-medium text-gray-900">
                                {{ $comment['user']['name'] ?? 'Kullanıcı' }}
                            </p>

                            @if (!empty($comment['created_at']))
                                <span class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($comment['created_at'])->translatedFormat('d F Y') }}
                                </span>
                            @endif

                        </div>

                        <p class="mt-3 text-sm leading-7 text-gray-600">
                            {{ $comment['content'] ?? '' }}
                        </p>

                    </div>

                @endforeach

            </div>

        @endif

    </section>

</div>

</section>

@endsection

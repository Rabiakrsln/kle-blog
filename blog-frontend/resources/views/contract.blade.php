@extends('layouts.app')

@section('content')

<section class="border-b border-gray-200 bg-white">
    <div class="mx-auto max-w-4xl px-5 py-20 lg:py-24">

    <a
        href="/"
        class="inline-flex items-center text-sm font-medium text-gray-500 transition hover:text-black"
    >
        ← Ana sayfaya dön
    </a>

    <div class="mt-10">

        <p class="text-sm font-semibold uppercase tracking-[3px] text-gray-500">
            KLE BLOG
        </p>

        <h1 class="mt-4 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
            {{ $contract['title'] }}
        </h1>

        @if(!empty($contract['published_at']))
            <p class="mt-5 text-sm text-gray-500">
                Yayınlanma tarihi:
                {{ \Carbon\Carbon::parse($contract['published_at'])->format('d F Y') }}
            </p>
        @endif

    </div>

</div>

</section>

<section class="bg-gray-50">
    <div class="mx-auto max-w-3xl px-5 py-16 lg:py-20">

    <article class="rounded-2xl border border-gray-200 bg-white p-8 sm:p-10">

        <div class="prose max-w-none text-gray-700">
            {!! $contract['content'] !!}
        </div>

    </article>

</div>

</section>

@endsection

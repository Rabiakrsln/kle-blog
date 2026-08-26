@extends('layouts.app')

@section('content')

    <section class="border-b border-gray-200 bg-white">
        <div class="mx-auto max-w-4xl px-5 py-20 lg:py-24">

            <a
                href="/"
                class="inline-flex items-center text-sm font-medium text-gray-500 transition hover:text-black"
            >
                ← Yazılara dön
            </a>

            <div class="mt-10">

                <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
                    <span>{{ $post['category']['name'] ?? 'Genel' }}</span>
                </div>

                <h1 class="mt-5 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">
                    {{ $post['title'] }}
                </h1>

                <div class="mt-8 flex items-center gap-3">

                    <div>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $post['user']['name'] ?? 'Bilinmeyen yazar' }}
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <section class="bg-white">
        <div class="mx-auto max-w-3xl px-5 py-10 lg:py-20">

            <article class="text-gray-700">

                <p class="text-lg leading-8">
                    {{ $post['content'] }}
                </p>

            </article>

        </div>
    </section>

    <section class="border-t border-gray-200 bg-gray-50">
        <div class="mx-auto max-w-3xl px-5 py-16 lg:py-20">

            <div>
                <p class="text-sm font-semibold uppercase tracking-[2px] text-gray-500">
                    Yorumlar
                </p>

                <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900">
                    Bu yazı hakkında ne düşünüyorsun?
                </h2>
            </div>

            <div class="mt-10 rounded-2xl border border-gray-200 bg-white p-6">

                <label
                    for="comment"
                    class="text-sm font-semibold text-gray-900"
                >
                    Yorumun
                </label>

                <textarea
                    id="comment"
                    rows="5"
                    placeholder="Yorumunu buraya yaz..."
                    class="mt-3 w-full resize-none rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-500"
                ></textarea>

                <div class="mt-4 flex justify-end">

                    <button
                        id="comment-button"
                        type="button"
                        class="rounded-lg bg-black px-6 py-3 text-sm font-medium text-white transition hover:bg-gray-800"
                    >
                        Yorum Yap
                    </button>

                </div>

                <p
                    id="comment-message"
                    class="mt-4 hidden text-sm"
                ></p>

            </div>

            <div class="mt-8 space-y-4">

                @forelse($comments as $comment)

                    <article class="rounded-2xl border border-gray-200 bg-white p-6">

                        <div class="flex items-center justify-between">

                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-xs font-semibold text-gray-700">
                                    {{ strtoupper(substr($comment['user']['name'] ?? 'U', 0, 2)) }}
                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $comment['user']['name'] ?? 'Bilinmeyen kullanıcı' }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        {{ isset($comment['approved_at']) ? \Carbon\Carbon::parse($comment['approved_at'])->format('d F Y') : '' }}
                                    </p>
                                </div>

                            </div>

                        </div>

                        <p class="mt-4 text-sm leading-7 text-gray-600">
                            {{ $comment['content'] }}
                        </p>

                    </article>

                @empty

                    <div class="rounded-2xl border border-gray-200 bg-white p-6">
                        <p class="text-sm text-gray-500">
                            Bu yazıya henüz yorum yapılmamış.
                        </p>
                    </div>

                @endforelse

            </div>

        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const button = document.getElementById('comment-button');
            const textarea = document.getElementById('comment');
            const message = document.getElementById('comment-message');

            if (!button || !textarea || !message) {
                return;
            }

            button.addEventListener('click', async function () {

                const token = localStorage.getItem('token');
                const content = textarea.value.trim();

                if (!token) {
                    message.textContent = 'Yorum yapmak için giriş yapmalısın.';
                    message.classList.remove('hidden');
                    message.classList.add('text-red-600');
                    return;
                }

                if (!content) {
                    message.textContent = 'Lütfen yorumunu yaz.';
                    message.classList.remove('hidden');
                    message.classList.add('text-red-600');
                    return;
                }

                button.disabled = true;
                button.textContent = 'Gönderiliyor...';

                try {

                    const response = await fetch('http://localhost:8000/api/comments', {
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            post_id: {{ $post['id'] }},
                            content: content
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) {

                        if (response.status === 401) {
                            message.textContent = 'Oturumun sona ermiş. Lütfen tekrar giriş yap.';
                        } else if (response.status === 422) {
                            message.textContent = 'Yorum bilgilerini kontrol et.';
                        } else {
                            message.textContent = data.message ?? 'Yorum gönderilemedi.';
                        }

                        message.classList.remove('hidden');
                        message.classList.remove('text-green-600');
                        message.classList.add('text-red-600');

                        return;
                    }

                    textarea.value = '';

                    message.textContent = 'Yorumun gönderildi. Admin onayından sonra yayınlanacaktır.';
                    message.classList.remove('hidden');
                    message.classList.remove('text-red-600');
                    message.classList.add('text-green-600');

                } catch (error) {

                    console.error(error);

                    message.textContent = 'Yorum gönderilirken bir hata oluştu.';
                    message.classList.remove('hidden');
                    message.classList.add('text-red-600');

                } finally {

                    button.disabled = false;
                    button.textContent = 'Yorum Yap';

                }

            });

        });
    </script>

@endsection
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

            <div class="mt-6 grid gap-6 sm:grid-cols-2">

                <div>
                    <p class="text-sm text-gray-500">
                        Ad Soyad
                    </p>

                    <p
                        id="dashboard-user-name"
                        class="mt-1 font-medium text-gray-900"
                    >
                        -
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-500">
                        E-posta
                    </p>

                    <p
                        id="dashboard-user-email"
                        class="mt-1 font-medium text-gray-900"
                    >
                        -
                    </p>
                </div>

            </div>

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

                <span
                    id="posts-count"
                    class="text-sm text-gray-500"
                >
                    0 yazı
                </span>

            </div>


            <div
                id="my-posts"
                class="mt-6 space-y-4"
            >

                <p class="text-sm text-gray-500">
                    Yazılar yükleniyor...
                </p>

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

                <span
                    id="comments-count"
                    class="text-sm text-gray-500"
                >
                    0 yorum
                </span>

            </div>


            <div
                id="my-comments"
                class="mt-6 space-y-4"
            >

                <p class="text-sm text-gray-500">
                    Yorumlar yükleniyor...
                </p>

            </div>

        </div>

    </div>
</section>


<script>

document.addEventListener('DOMContentLoaded', async function () {

    const token = localStorage.getItem('token');

    const user = JSON.parse(
        localStorage.getItem('user') || 'null'
    );


    if (!token || !user) {

        window.location.href = '/login';

        return;

    }

    document.getElementById('dashboard-user-name').textContent =
        user.name ?? '-';

    document.getElementById('dashboard-user-email').textContent =
        user.email ?? '-';


    const postsContainer =
        document.getElementById('my-posts');

    const commentsContainer =
        document.getElementById('my-comments');

    const postsCount =
        document.getElementById('posts-count');

    const commentsCount =
        document.getElementById('comments-count');


    async function loadDashboardData() {

        try {

            const [postsResponse, commentsResponse] =
                await Promise.all([

                    fetch('http://localhost:8000/api/user/posts', {
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json'
                        }
                    }),

                    fetch('http://localhost:8000/api/user/comments', {
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json'
                        }
                    })

                ]);

            if (
                postsResponse.status === 401 ||
                commentsResponse.status === 401
            ) {

                localStorage.removeItem('token');
                localStorage.removeItem('user');

                window.location.href = '/login';

                return;

            }


            const postsData =
                await postsResponse.json();

            const commentsData =
                await commentsResponse.json();

            const posts =
                postsData.data ?? [];

            postsCount.textContent =
                posts.length + ' yazı';


            postsContainer.innerHTML = '';


            if (posts.length === 0) {

                postsContainer.innerHTML = `
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-6">
                        <p class="text-sm text-gray-500">
                            Henüz yazdığın bir yazı bulunmuyor.
                        </p>
                    </div>
                `;

            } else {

                posts.forEach(function (post) {

                    const status =
                        post.status ?? 'pending';


                    const statusText =
                        status === 'approved'
                            ? 'Onaylandı'
                            : 'Bekliyor';


                    const statusClass =
                        status === 'approved'
                            ? 'bg-green-50 text-green-700'
                            : 'bg-yellow-50 text-yellow-700';


                    const publishedDate =
                        post.created_at
                            ? new Date(
                                post.created_at
                            ).toLocaleDateString('tr-TR')
                            : '';


                    const article =
                        document.createElement('article');


                    article.className =
                        'rounded-xl border border-gray-200 p-6 transition hover:border-gray-300 hover:shadow-sm';


                    article.innerHTML = `

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                            <div>

                                <h3 class="text-lg font-bold text-gray-900">
                                    ${post.title ?? ''}
                                </h3>

                                <p class="mt-2 text-sm text-gray-500">
                                    ${post.category?.name ?? 'Genel'}
                                </p>

                            </div>


                            <span class="w-fit rounded-full px-3 py-1 text-xs font-medium ${statusClass}">
                                ${statusText}
                            </span>

                        </div>


                        <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4">

                            <span class="text-xs text-gray-400">
                                ${publishedDate}
                            </span>

                            ${
                                status === 'approved'
                                ? `
                                    <a
                                        href="/posts/${post.id}"
                                        class="text-sm font-semibold text-gray-900 hover:underline"
                                    >
                                        Yazıyı Gör →
                                    </a>
                                `
                                : ''
                            }

                        </div>

                    `;


                    postsContainer.appendChild(article);

                });

            }

            const comments =
                commentsData.data ?? [];

            commentsCount.textContent =
                comments.length + ' yorum';


            commentsContainer.innerHTML = '';


            if (comments.length === 0) {

                commentsContainer.innerHTML = `
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-6">
                        <p class="text-sm text-gray-500">
                            Henüz yaptığın bir yorum bulunmuyor.
                        </p>
                    </div>
                `;

            } else {

                comments.forEach(function (comment) {

                    const status =
                        comment.status ?? 'pending';


                    const statusText =
                        status === 'approved'
                            ? 'Onaylandı'
                            : 'Bekliyor';


                    const statusClass =
                        status === 'approved'
                            ? 'bg-green-50 text-green-700'
                            : 'bg-yellow-50 text-yellow-700';


                    const commentDate =
                        comment.created_at
                            ? new Date(
                                comment.created_at
                            ).toLocaleDateString('tr-TR')
                            : '';


                    const article =
                        document.createElement('article');


                    article.className =
                        'rounded-xl border border-gray-200 p-6';


                    article.innerHTML = `

                        <div class="flex items-start justify-between gap-4">

                            <div class="flex-1">

                                <p class="text-sm leading-7 text-gray-700">
                                    ${comment.content ?? ''}
                                </p>

                            </div>


                            <span class="shrink-0 rounded-full px-3 py-1 text-xs font-medium ${statusClass}">
                                ${statusText}
                            </span>

                        </div>


                        <div class="mt-5 flex flex-col gap-2 border-t border-gray-100 pt-4 sm:flex-row sm:items-center sm:justify-between">

                            <p class="text-sm text-gray-500">

                                ${
                                    comment.post?.title
                                        ? `Yazı: ${comment.post.title}`
                                        : 'Yazı bilgisi bulunamadı.'
                                }

                            </p>


                            <span class="text-xs text-gray-400">
                                ${commentDate}
                            </span>

                        </div>

                    `;


                    commentsContainer.appendChild(article);

                });

            }


        } catch (error) {

            console.error(error);


            postsContainer.innerHTML = `
                <div class="rounded-xl border border-red-200 bg-red-50 p-6">
                    <p class="text-sm text-red-600">
                        Yazılar yüklenirken bir hata oluştu.
                    </p>
                </div>
            `;


            commentsContainer.innerHTML = `
                <div class="rounded-xl border border-red-200 bg-red-50 p-6">
                    <p class="text-sm text-red-600">
                        Yorumlar yüklenirken bir hata oluştu.
                    </p>
                </div>
            `;

        }

    }


    loadDashboardData();

});

</script>

@endsection
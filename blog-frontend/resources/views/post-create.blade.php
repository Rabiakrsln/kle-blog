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

            <form id="post-form" class="mt-10">

                <div>
                    <label
                        for="category_id"
                        class="text-sm font-semibold text-gray-900"
                    >
                        Kategori
                    </label>

                    <select
                        id="category_id"
                        class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                    >
                        <option value="">Kategori seç</option>
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
                        type="text"
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
                        rows="3"
                        class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                        placeholder="Yazının kısa özeti"
                    ></textarea>
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
                        rows="10"
                        class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                        placeholder="Yazını buraya yaz..."
                    ></textarea>
                </div>

                <p
                    id="post-message"
                    class="mt-6 hidden rounded-xl px-4 py-3 text-sm"
                ></p>

                <div class="mt-8 flex justify-end">
                    <button
                        id="post-button"
                        type="submit"
                        class="rounded-xl bg-black px-6 py-3 text-sm font-medium text-white hover:bg-gray-800"
                    >
                        Yazıyı Gönder
                    </button>
                </div>

            </form>

        </div>

    </div>
</section>


<script>

document.addEventListener('DOMContentLoaded', async function () {

    const form = document.getElementById('post-form');
    const button = document.getElementById('post-button');
    const message = document.getElementById('post-message');
    const categorySelect = document.getElementById('category_id');

    const API_URL = 'http://localhost:8000/api';


    function showMessage(text, type) {

        message.textContent = text;

        message.classList.remove(
            'hidden',
            'bg-red-50',
            'text-red-600',
            'bg-green-50',
            'text-green-600'
        );

        if (type === 'success') {

            message.classList.add(
                'bg-green-50',
                'text-green-600'
            );

        } else {

            message.classList.add(
                'bg-red-50',
                'text-red-600'
            );
        }
    }

    try {

        const response = await fetch(
            API_URL + '/categories',
            {
                headers: {
                    'Accept': 'application/json'
                }
            }
        );

        const data = await response.json();

        if (!response.ok) {
            throw new Error('Kategoriler alınamadı.');
        }

        const categories = data.data || [];

        categories.forEach(function (category) {

            const option = document.createElement('option');

            option.value = category.id;
            option.textContent = category.name;

            categorySelect.appendChild(option);

        });

    } catch (error) {

        console.error(error);

        showMessage(
            'Kategoriler yüklenirken bir hata oluştu.',
            'error'
        );

    }

    form.addEventListener('submit', async function (event) {

        event.preventDefault();


        const token = localStorage.getItem('token');


        if (!token) {

            showMessage(
                'Yazı oluşturmak için giriş yapmalısın.',
                'error'
            );

            return;
        }


        const categoryId =
            categorySelect.value;

        const title =
            document.getElementById('title').value.trim();

        const excerpt =
            document.getElementById('excerpt').value.trim();

        const content =
            document.getElementById('content').value.trim();


        if (!categoryId || !title || !content) {

            showMessage(
                'Kategori, başlık ve içerik alanları zorunludur.',
                'error'
            );

            return;
        }


        button.disabled = true;
        button.textContent = 'Gönderiliyor...';


        try {

            const response = await fetch(
                API_URL + '/posts',
                {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },

                    body: JSON.stringify({
                        category_id: Number(categoryId),
                        title: title,
                        excerpt: excerpt || null,
                        content: content
                    })
                }
            );


            const data = await response.json();


            if (!response.ok) {

                let errorMessage =
                    'Yazı oluşturulamadı.';


                if (response.status === 422 && data.errors) {

                    const errors =
                        Object.values(data.errors)
                            .flat();

                    errorMessage =
                        errors.join(' ');

                } else if (data.message) {

                    errorMessage =
                        data.message;
                }


                showMessage(
                    errorMessage,
                    'error'
                );

                return;
            }


            showMessage(
                'Yazın başarıyla gönderildi. Yönetici onayından sonra yayınlanacaktır.',
                'success'
            );


            form.reset();


            setTimeout(function () {

                window.location.href = '/dashboard';

            }, 1500);


        } catch (error) {

            console.error(error);

            showMessage(
                'Sunucuya bağlanırken bir hata oluştu.',
                'error'
            );

        } finally {

            button.disabled = false;
            button.textContent = 'Yazıyı Gönder';

        }

    });

});

</script>

@endsection
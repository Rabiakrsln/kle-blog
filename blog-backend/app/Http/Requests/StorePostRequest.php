<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Post::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
                    ->where(function ($query) {
                        $query->where('is_active', 1);
                    }),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'excerpt' => [
                'nullable',
                'string',
            ],

            'content' => [
                'required',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori seçimi zorunludur.',
            'category_id.integer' => 'Kategori ID geçerli olmalıdır.',
            'category_id.exists' => 'Seçilen kategori aktif değil veya mevcut değil.',
            'title.required' => 'Başlık zorunludur.',
            'title.string' => 'Başlık metin olmalıdır.',
            'title.max' => 'Başlık en fazla 255 karakter olabilir.',
            'content.required' => 'İçerik zorunludur.',
            'content.string' => 'İçerik metin olmalıdır.',
        ];
    }
}
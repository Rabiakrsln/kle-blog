<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Comment;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Comment::class) ?? false;
    }
    
    public function rules(): array
    {
        return [
            'post_id' => [
                'required',
                'integer',
                Rule::exists('posts', 'id')
                    ->where(function ($query) {
                        $query->where('status', 'approved')
                            ->whereNotNull('published_at');
                    }),
            ],

            'content' => [
                'required',
                'string',
                'max:5000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'post_id.required' => 'Yazı seçimi zorunludur.',
            'post_id.integer' => 'Yazı ID geçerli olmalıdır.',
            'post_id.exists' => 'Bu yazıya yorum yapılamaz.',
            'content.required' => 'Yorum içeriği zorunludur.',
            'content.string' => 'Yorum metin olmalıdır.',
            'content.max' => 'Yorum en fazla 5000 karakter olabilir.',
        ];
    }
}
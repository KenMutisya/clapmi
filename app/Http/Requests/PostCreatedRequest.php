<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCreatedRequest extends FormRequest
{
    public function rules(): array
    {
        return [
                'title'    => ['required','unique:posts,title'],
                'category_id' => ['required','exists:categories,id'],
                'status'   => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
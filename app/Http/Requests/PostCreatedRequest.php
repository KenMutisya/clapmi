<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCreatedRequest extends FormRequest
{
    public function rules(): array
    {
        return [
                'title'    => ['required','unique:posts,title'],
                'category' => ['required','exists:categories,name'],
                'status'   => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
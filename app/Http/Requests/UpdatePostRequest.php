<?php

namespace App\Http\Requests;

use App\Models\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'require',
            'category' => 'nullable|exists:categories,id',
            'status' => "nullable|in:Draft,published,Archived",
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
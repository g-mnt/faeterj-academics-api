<?php

namespace App\Http\Requests;

use App\ArticleStatusesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ArticleUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'pdf' => ['sometimes', 'file'], 
            'status' => ['sometimes',  new Enum(ArticleStatusesEnum::class)]
        ];
    }
}

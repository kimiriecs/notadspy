<?php

namespace App\Modules\AdSpy\Http\Request;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreAdvertRequest
 *
 * @package App\Modules\AdSpy\Http\Request
 */
class StoreAdvertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'url' => 'url:http,https'
        ];
    }
}

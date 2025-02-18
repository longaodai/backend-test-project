<?php

namespace App\Http\Requests\Api\Contact;

use App\Repositories\Tag\TagRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $this->validateCustomRules();

        return [
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|string|email|max:255',
            'phone' => 'bail|required|string|max:20',
            'tags' => 'bail|nullable|array|validate_tags',
        ];
    }

    /**
     * Custom validate
     */
    private function validateCustomRules()
    {
        Validator::extend('validate_tags', function ($attribute, $value, $parameters) {
            $repository = app(TagRepositoryInterface::class);
            $data = $repository->all(['ids' => $value]);

            return count($value) == $data->count();
        });
    }

    /**
     * Message for validation
     *
     * @return array
     *
     * @author longvc <vochilong.work@gmail.com>
     */
    public function messages()
    {
        return [
            'validate_user_id' => __('validation.exists', ['attribute' => 'user_id']),
        ];
    }
}

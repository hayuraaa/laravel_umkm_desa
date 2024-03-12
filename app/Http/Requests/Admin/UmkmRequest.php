<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UmkmRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST': {
                    return [
                        'title' => ['required'],
                        'addres' => ['required'],
                        'unit' => ['required'],
                        'description' => ['required'],
                        'detail' => ['required'],
                        'price' => ['required'],
                        'agent_id' => ['required'],
                        'banner'     => ['image', 'required'],
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'title' => ['required'],
                        'addres' => ['required'],
                        'unit' => ['required'],
                        'description' => ['required'],
                        'detail' => ['required'],
                        'price' => ['required'],
                        'agent_id' => ['required'],
                        'banner'     => ['image'],
                    ];
                }
            default:
                break;
        }
    }
}

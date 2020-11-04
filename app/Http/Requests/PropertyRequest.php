<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET': {
                return [];
            }
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'owner_email' => 'required|email',
                    'street' => 'required|string|max:150',
                    'number' => 'nullable|integer',
                    'complement' => 'nullable|string|max:180',
                    'district' => 'required|string|max:150',
                    'city' => 'required|string|max:150',
                    'state' => 'required|string|max:150',                ];
            }
            case 'PUT': {
                return [
                    'owner_email' => 'required|email',
                    'street' => 'required|string|max:150',
                    'number' => 'nullable|integer',
                    'complement' => 'nullable|string|max:180',
                    'district' => 'required|string|max:150',
                    'city' => 'required|string|max:150',
                    'state' => 'required|string|max:150',
                ];
            }
            default:
                return [];
        }
    }

    public function messages()
    {
        return [
            'owner_email.required' => 'E-mail do proprietário é obrigatório',
            'owner_email.email'    => 'E-mail do proprietário deve ser um e-mail válido',
            'street.required'      => 'Rua é obrigatório',
            'district.required'    => 'Bairro é obrigatório',
            'city.required'        => 'Cidade é obrigatório' ,
            'state.required'       => 'Estado é obrigatório' ,
        ];
    }

    public function attributes()
    {
        return [
            'owner_email' => 'E-mail do proprietário',
            'street'      => 'Rua',
            'number'      => 'Número',
            'complement'  => 'Complemento',
            'district'    => 'Bairro',
            'city'        => 'Cidade',
            'state'       => 'Estado',
        ];
    }
}

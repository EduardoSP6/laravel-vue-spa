<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
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
                    'property_id'      => 'required|numeric|exists:properties,id',
                    'person_type'      => 'required|numeric',
                    'document'         => 'required|numeric',
                    'contractor_email' => 'required|email',
                    'contractor_name'  => 'required|string|max:150',
                ];
            }
            case 'PUT': {
                return [
                    'property_id'      => 'required|numeric|exists:properties,id',
                    'person_type'      => 'required|numeric',
                    'document'         => 'required|numeric',
                    'contractor_email' => 'required|email',
                    'contractor_name'  => 'required|string|max:150',
                ];
            }
            default:
                return [];
        }
    }

    public function messages()
    {
        return [
            'property_id.required'      => 'Imóvel é obrigatório',
            'person_type.required'      => 'Tipo de pessoa é obrigatório',
            'document.required'         => 'Documento é obrigatório',
            'document.numeric'         => 'Documento deve conter um valor numérico',
            'contractor_email.required' => 'E-mail do contratante é obrigatório',
            'contractor_email.email'    => 'E-mail do contratante deve ser um e-mail válido',
        ];
    }

    public function attributes()
    {
        return [
            'property_id'      => 'Imóvel',
            'person_type'      => 'Tipo de pessoa',
            'document'         => 'Documento',
            'contractor_email' => 'E-mail do contratante',
            'contractor_name'  => 'Nome do contratante',
        ];
    }
}

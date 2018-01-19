<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadTicketRequest extends FormRequest
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
    public function messages(){
        return [
            'demand_draft.required' => 'Choose the file to be uploaded',
            'demand_draft.mimetypes' => 'The ticket must be a scanned pdf of the attested ticket'
        ];
    }
    public function rules()
    {
        return [
            'demand_draft' => 'required|mimetypes:application/pdf'
        ];
    }
}

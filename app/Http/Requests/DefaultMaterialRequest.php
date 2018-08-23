<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DefaultMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => 'required',
            'contractor_id' => 'required',
            'seam_id' => 'required',
            'material_type' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'customer_id' => 'Customer',
            'contractor_id' => 'Contractor',
            'seam_id' => 'Seam',
            'material_type' => 'Material Type',
        ];
    }
}

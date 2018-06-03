<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetStatusRequest extends FormRequest
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
        $assetStatus = $this->route('assetStatus');

        return [
            'code' => [
                'required',
                Rule::unique('asset_statuses')->ignore($assetStatus ? $assetStatus->id : 0)
            ]
        ];
    }

    public function attributes()
    {
        return [
            'code' => 'Code',
            'description' => 'Description'
        ];
    }
}

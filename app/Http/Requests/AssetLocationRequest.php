<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetLocationRequest extends FormRequest
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
        $assetLocation = $this->route('assetLocation');

        return [
            'name' => [
                'required',
                Rule::unique('asset_locations')->ignore($assetLocation ? $assetLocation->id : 0)
            ]
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'pic' => 'PIC'
        ];
    }
}

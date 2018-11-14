<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetVendorRequest extends FormRequest
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
        $assetVendor = $this->route('assetVendor');

        return [
            'name' => [
                'required',
                Rule::unique('asset_vendors')
                    ->ignore($assetVendor ? $assetVendor->id : 0)
            ]
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetRequest extends FormRequest
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
        $asset = $this->route('asset');

        return [
            'name' => 'required',
            'trademark' => 'required',
            'version' => 'required',
            'sn' => 'required',
            'lifetime' => 'required',
            'price' => 'required',
            'year' => 'required',
            'asset_location_id' => 'required',
            'asset_status_id' => 'required',
            'reg_no' => [
                'required',
                Rule::unique('assets')->ignore($asset ? $asset->id : 0)
            ]
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'reg_no' => 'Registration Number',
            'trademark' => 'Trademark',
            'version' => 'Version',
            'sn' => 'SN',
            'lifetime' => 'Lifetime',
            'price' => 'Price',
            'year' => 'Year',
            'asset_location_id' => 'Location',
            'asset_status_id' => 'Status'
        ];
    }
}

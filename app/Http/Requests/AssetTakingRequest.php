<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetTakingRequest extends FormRequest
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
        $assetTaking = $this->route('assetTaking');

        return [
            'date' => 'required|date',
            'asset_id' => 'required',
            'old_asset_location_id' => 'required',
            'old_asset_status_id' => 'required',
            'new_asset_location_id' => 'required',
            'new_asset_status_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'date' => 'Date',
            'asset_id' => 'Asset',
            'old_asset_location_id' => 'Current Location',
            'old_asset_status_id' => 'Current Status',
            'new_asset_location_id' => 'New Location',
            'new_asset_status_id' => 'New Status',
        ];
    }
}

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
        return auth()->check();
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
            'asset_location_id' => 'required',
            'asset_status_id' => 'required'
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

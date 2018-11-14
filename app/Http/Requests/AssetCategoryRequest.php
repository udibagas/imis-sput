<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetCategoryRequest extends FormRequest
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
        $assetCategory = $this->route('assetCategory');

        return [
            'code' => [
                'required',
                Rule::unique('asset_categories')
                    ->ignore($assetCategory ? $assetCategory->id : 0)
            ],
            'name' => [
                'required',
                Rule::unique('asset_categories')
                    ->ignore($assetCategory ? $assetCategory->id : 0)
            ]
        ];
    }
}

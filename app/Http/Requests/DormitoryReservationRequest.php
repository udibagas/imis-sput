<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DormitoryReservationRequest extends FormRequest
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
        $dormitoryReservation = $this->route('dormitoryReservation');

        return [
            'permit_number' => [
                'required',
                Rule::unique('dormitory_reservations')->ignore($dormitoryReservation ? $dormitoryReservation->id : 0)
            ],
            'employee_id' => ['required', function($value, $attribute, $fail) {
                // TODO : pikirkan nanti
            }],
            'dormitory_room_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'need' => 'required',
        ];
    }
}

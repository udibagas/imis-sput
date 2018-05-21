<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Absensi;

class AbsensiRequest extends FormRequest
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
        $absensi = $this->route('absensi');

        return [
            'in' => ['required', function($attribute, $value, $fail) {
                if (strtotime($value) > strtotime(now())) {
                    $fail("Absen di masa depan?");
                }
            }],
            'employee_id' => ['required', function($attribute, $value, $fail) use ($absensi) {
                $in = date('Y-m-d', strtotime($this->in));

                $sudah = Absensi::where('employee_id', $value)
                    ->whereRaw("DATE(`in`) = '$in'")
                    ->whereNotIn('id', [$absensi ? $absensi->id : 0])
                    ->count();

                if ($sudah) {
                    $fail("Karyawan sudah absen hari ini");
                }
            }],
            'out' => [function($attribute, $value, $fail) {
                if ($value != '' && strtotime($value) <= strtotime($this->in)) {
                    $fail("Time Out mundur.");
                }
            }],
        ];
    }
}

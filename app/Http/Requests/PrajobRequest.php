<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Prajob;

class PrajobRequest extends FormRequest
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
        $prajob = $this->route('prajob');

        return [
            'employee_id' => ['required', function($attribute, $value, $fail) use ($prajob) {
                $sudah = Prajob::where('employee_id', $value)
                    ->where('tgl', $this->tgl)
                    ->whereNotIn('id', [$prajob ? $prajob->id : 0])
                    ->count();

                if ($sudah) {
                    $fail("Karyawan sudah fatique check hari ini");
                }
            }],
            'tgl' => ['required','date', function($attribute, $value, $fail) {
                if (strtotime($value) > strtotime(now())) {
                    $fail("Fatique check di masa depan?");
                }
            }],
            'shift' => 'required',
            'jam_tidur' => 'required|date_format:"H:i"',
            'jam_bangun' => 'required|date_format:"H:i"',
            'minum_obat' => 'required',
            'ada_masalah' => 'required',
            'siap_bekerja' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'tgl' => 'Date',
            'employee_id' => 'Employee',
            'shift' => 'Shift',
            'jam_tidur' => 'Jam Mulai Tidur',
            'jam_bangun' => 'Jam bangun',
            'bpm' => 'BPM',
            'spo' => 'SPO',
            'minum_obat' => '',
            'ada_masalah' => '',
            'siap_bekerja' => ''
        ];
    }

    public function messages()
    {
        return [
            'minum_obat.required' => 'Pilih YA atau TIDAK',
            'ada_masalah.required' => 'Pilih YA atau TIDAK',
            'siap_bekerja.required' => 'Pilih YA atau TIDAK',
            'jam_tidur.date_format' => 'Harus dengan format jam:menit (contoh 21:00)',
            'jam_bangun.date_format' => 'Harus dengan format jam:menit (contoh 04:00)',
        ];
    }
}

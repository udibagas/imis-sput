<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use QRCode;

class IsengController extends Controller
{
    public function cetakTiket()
    {
        return view('iseng.tiket', [
            'employees' => Employee::take(10)->get()
        ]);
    }

    public function cetakPoin()
    {
        $poins = [];

        for ($i = 10; $i <= 100; $i+10)
        {
            $poins[] = QRCode::text($i)
                ->setMargin(2)
                ->setSize(5)
                ->svg();
        }

        return view('iseng.poin', ['poins' => $poins]);
    }
}

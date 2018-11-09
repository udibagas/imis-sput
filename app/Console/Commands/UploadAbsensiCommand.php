<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Absensi;
use Carbon\Carbon;

class UploadAbsensiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absensi:upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload absensi harian';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 072017423201805182001205
        // 072017423       --> NRP
        // 2018            --> Tahun
        // 05              --> Bulan
        // 18              --> Tanggal
        // 2001            --> Jam 20 : 01
        // 2               --> Kode Out (Kalo In jadi 1)
        // 05              --> Lokasi Unit Finger

        $absensi = Absensi::selectRaw('absensis.*, employees.NRP AS nrp')
            ->join('employees', 'employees.id', '=', 'absensis.employee_id')
            ->where('absensis.date', date('Y-m-d'))
            ->get();

        $huruf = range('A', 'Z');
        $line = '';

        $fileName = date('Ymd').'.txt';
        $file = fopen($fileName, 'a');

        foreach ($absensi as $a)
        {
            if (preg_match('/[A-Z][A-Z][0-9][0-9][0-9][0-9][0-9]/', $a->nrp))
            {
                $nrp = sprintf("%02d", array_search(substr($a->nrp, 0, 1), $huruf) + 1)
                    .sprintf("%02d", array_search(substr($a->nrp, 1, 1), $huruf) + 1)
                    .substr($a->nrp, 2);

                if ($a->in) {
                    $date = new Carbon($a->in);
                    $line .= $nrp;
                    $line .= $date->format('YmdHi');
                    $line .= '1';
                    $line .= $a->terminal_no . "\n";
                }

                if ($a->out) {
                    $date = new Carbon($a->out);
                    $line .= $nrp;
                    $line .= $date->format('YmdHi');
                    $line .= '2';
                    $line .= $a->terminal_no . "\n";
                }

                fwrite($file, $line);
            }
        }

        fclose($file);

        if ($line != '') {
            $ftpCon = ftp_connect(env('FTP_HOST', '10.13.20.124'), env('FTP_PORT', '25'));
            $ftpLogin = ftp_login($ftpCon, env('FTP_USER', 'anonymous'), env('FTP_PASS', ''));
            $upload = ftp_put($ftpCon, $fileName, $fileName, FTP_BINARY);

            if ($upload) {
                unlink($fileName);
            }

            ftp_close($ftpCon);
        }
    }
}

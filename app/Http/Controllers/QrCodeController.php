<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Peserta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function scan_qr()
    {
        $pesertas = Peserta::all();
        return view('qrcode.index', [
            'pesertas' => $pesertas
        ]);
    }

    public function validasi_qr(Request $request)
    {
        $uuid = $request->uuid;
        $peserta = Peserta::where('id', $uuid)->first();

        $now = Carbon::now();
        $tanggal = $now->toDateTimeString();
        $jam = $now->toTimeString();

        if ($peserta) {
            $exsistPesertaId = Absen::where('peserta_id', $peserta->id)->count();

            if ($exsistPesertaId == 0) {
                Absen::create([
                    'peserta_id' => $peserta->id,
                    'tgl_absen' => $tanggal,
                    'jam_absen' => $jam,
                ]);
                return response()->json([
                    'message' => 'Berhasil Absen Qr code',
                    'data' => $peserta,
                    'success' => true,
                ]);
            } else {
                $currentAbsen = Absen::where('peserta_id', $peserta->id)->first();
                $tgl1 = Carbon::now()->format('Y-m-d H:s:i');
                $tgl2 = Carbon::parse($currentAbsen->created_at)->format('Y-m-d H:s:i');

                $to = Carbon::createFromFormat('Y-m-d H:s:i', $tgl1);
                $from = Carbon::createFromFormat('Y-m-d H:s:i', $tgl2);

                $diff_in_hours = $to->diffInMinutes($from);

                if ($diff_in_hours >= 1440) {
                    Absen::create([
                        'peserta_id' => $peserta->id,
                        'tgl_absen' => $tanggal,
                        'jam_absen' => $jam,
                    ]);

                    return response()->json([
                        'message' => 'Berhasil Absen Qr code',
                        'data' => $peserta,
                        'success' => true,
                    ]);
                } else {
                    return response()->json([
                        'message' => 'Sudah absen Kembali lagi besok',
                        'success' => 'absen expired',
                    ]);
                }
            }
        } else {
            return response()->json([
                'message' => 'Invalid QR code',
                'success' => false,
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use App\Models\Peserta;
use Illuminate\Http\Request;
use PDF;


class ReportController extends Controller
{
    public function index()
    {
        $acaras = Acara::all();
        return view('report.index', compact('acaras'));
    }

    public function cekReport(Request $request)
    {
        $request->validate([
            'acara_id' => 'required|exists:acaras,id',
        ]);

        return response()->json([
            'status' => 'success',
            'data' => ['uuid' => $request->acara_id]
        ]);
    }

    public function pdfReport(Request $request, $uuid)
    {
        $acara = Acara::findOrFail($uuid);
        $peserta = Peserta::with('absen')->where('acara_id', $uuid)->get(); 
        // dd($peserta);
        $pdf = PDF::loadview('report.pdf_peserta_daftar', [
            'pesertas' => $peserta,
            'acara' => $acara
        ]);
        return $pdf->stream();
    }
}

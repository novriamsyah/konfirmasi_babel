<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use App\Models\Instansi;
use App\Models\Peserta;
use Carbon\Carbon;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $acaras = Acara::orderBy('created_at', 'desc')
        ->paginate(6);
        return view('landing_page.index', compact('acaras'));
    }

    public function ajaxSearch(Request $request)
    {
        $query = Acara::query();

        if ($request->search) {
            $query->where('nama', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filter) {
            switch ($request->filter) {
                case 'hari':
                    $query->whereDate('tgl_mulai', Carbon::today());
                    break;
                case 'minggu':
                    $startOfWeek = Carbon::now()->startOfWeek();
                    $endOfWeek = Carbon::now()->endOfWeek();
                    $query->whereBetween('tgl_mulai', [$startOfWeek, $endOfWeek]);
                    break;
                case 'bulan':
                    $query->whereMonth('tgl_mulai', Carbon::now()->month);
                    break;
            }
        }

        $acaras = $query
        ->orderBy('created_at', 'desc')
        ->paginate(6);

        return view('landing_page.partials.acara_list', compact('acaras'))->render();
    }

    public function konfirmasiPeserta(Request $request)
    {
        // Validasi input
        $request->validate([
            'acara_id' => 'required|exists:acaras,id',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:15',
            'organisasi' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kode_unik' => 'nullable|string|max:255',
        ]);

        // Cek apakah email sudah terdaftar
        $existsEmail = Peserta::where('acara_id', $request->acara_id)
            ->where('email', $request->email)
            ->exists();

        if ($existsEmail) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Peserta dengan email ini sudah terdaftar pada acara ini.'
            ], 422);
        }

        // Cek kode surat jika ada
        if ($request->kode_surat && $request->kode_surat != $request->kode_unik) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Nomor surat/undangan yang kamu masukan tidak sesuai.'
            ], 422);
        }

        // Buat peserta baru
        Peserta::create([
            'acara_id' => $request->acara_id,
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'organisasi' => $request->organisasi,
            'jabatan' => $request->jabatan,
            'kode_unik' => $request->kode_unik,
        ]);

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Konfirmasi kehadiran berhasil dikirim.'
        ]);
    }

    public function indexKartuPeserta(Request $request)
    {
        $acaras = Acara::all();
        return view('landing_page.kartu.index', compact('acaras'));
    }

    public function cekKartuPeserta(Request $request)
    {
        $request->validate([
            'acara_id' => 'required|exists:acaras,id',
            'email' => 'required|email'
        ]);

        $peserta = Peserta::where('acara_id', $request->acara_id)
            ->where('email', $request->email)
            ->first();

        if ($peserta) {
            return response()->json([
                'status' => 'success',
                'data' => ['uuid' => $peserta->id]
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Kartu pendaftaran tidak ditemukan.'
            ]);
        }
    }

    public function unduhKartuPeserta(Request $request, $uuid)
    {

        $peserta = Peserta::with('acara')->where('id', $uuid)->first();
        $qrcode = base64_encode(QrCode::format('svg')->size(90)->errorCorrection('H')->generate($peserta->id));

        $pdf = PDF::loadview('landing_page.kartu.pdf_kartu_peserta', [
            'peserta' => $peserta,
            'qrcode' => $qrcode,
        ]);
        return $pdf->stream();
    }

    public function contact()
    {
        return view('landing_page.contact');
    }
}

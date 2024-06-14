<?php

namespace App\Http\Controllers;

use App\Helpers\ImageManager;
use App\Models\Acara;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AcaraController extends Controller
{
    use ImageManager;

    public function datatable()
    {
        $datatableData = Acara::query();


        return datatables()->of($datatableData)
            ->addColumn('action', function ($row) {
                return view('acara.action', ['id' => $row->id]);
            })
            ->addColumn('nama_instansi', function ($row) {
                return $row->instansi->nama;
            })
            ->addColumn('tanggal_acara', function ($row) {
                return date('d M', strtotime($row->tgl_mulai)) . ' - ' . date('d M Y', strtotime($row->tgl_selesai));
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function index()
    {
        return view('acara.index');
    }

    public function create(Request $request)
    {
        $instansis = DB::table('instansis')->get();
        return view('acara.create', compact('instansis'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            'nama' => 'required|string|max:255',
            'instansi_id' => 'required|exists:instansis,id',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'durasi' => 'required|string|greater_than_zero',
            'lokasi' => 'required|string',
            'link' => 'nullable|string',
            'sifat' => 'required|string',
            'kuota' => 'required|string',
            'rahasia'=>'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'catatan' => 'nullable|string',
            'kode' => 'nullable|string|max:255',
        ]);

        $path = 'file/surat/';

        if ($file = $request->file('file')) {
            $fileData = $this->uploads($file, $path);
            $fileNama = $fileData['fileNameDB'];
        }

        // dd($request->all());
        $save = Acara::create([
            'nama' => $request->nama,
            'instansi_id' => $request->instansi_id,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'durasi' => $request->durasi,
            'lokasi' => $request->lokasi,
            'link' => $request->link,
            'sifat' => $request->sifat,
            'rahasia' => $request->rahasia,
            'file' => $fileNama,
            'catatan' => $request->catatan,
            'kuota' => $request->kuota,
            'kode' => $request->kode,
        ]);

        if ($save) {
            return redirect()->route('acara.index')->with('success', 'Acara berhasil ditambahkan.');
        } else {
            return redirect()->route('acara.create')->with('failed', 'Acara gagal ditambahkan.');
        }
        

    }

    public function edit(Request $request, $id)
    {
        $instansis = DB::table('instansis')->get();
        $acara = Acara::findOrFail($id);
        // dd($acara);
        return view('acara.edit', compact('acara', 'instansis'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama' => 'required|string|max:255',
            'instansi_id' => 'required|exists:instansis,id',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'durasi' => 'required|string|max:255',
            'lokasi' => 'required|string',
            'link' => 'nullable|string',
            'sifat' => 'required|string',
            'kuota' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'catatan' => 'nullable|string',
            'rahasia' => 'required|string',
            'kode' => 'nullable|string|max:255',
        ]);

        $path = 'file/surat/';
        $hasFile = $request->file('file');

        $acara = Acara::findOrFail($id);

        // dd($hasFile);

        if ($hasFile) {
            $filePath = $path . $acara->file;

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $file = $request->file('file');
            $fileData = $this->uploads($file, $path);
            $fileDB = $fileData['fileNameDB'];
            $validate['file'] = $fileDB;
        }

        $acara->update($validate);

        if ($acara) {
            return redirect()->route('acara.index')->with('success', 'Acara berhasil diperbarui.');
        } else {
            return redirect()->route('acara.edit', $id)->with('failed', 'Acara gagal diperbarui.');
        }
    }

    public function destroy($id)
    {
        $acara = Acara::findOrFail($id);
        $acara->delete();

        return redirect()->route('acara.index')->with('success', 'Acara berhasil dihapus.');
    }
}

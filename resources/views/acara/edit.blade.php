@extends('layouts.horizontal_dashboard.app')
@push('plugin-css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
@endpush

@push('css')
<style>
    .hilang {
        display: none;
    }
</style>
@endpush
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Edit Acara</h4>
    
    <div class="row mb-4">
        <div class="col-md">
            <div class="card">
                <h5 class="card-header">Edit Acara</h5>
                <p class="fw-bold px-4" style="font-size: 13px;"><span class="text-danger" style="font-size: 15px;">( * )</span>  Input yang wajib diisi !</p>
                <div class="card-body">
                    <form action="{{ route('acara.update', $acara->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Acara <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $acara->nama) }}" id="nama" placeholder="Masukan Acara" />
                            @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="instansi" class="form-label">Instansi <span class="text-danger">*</span></label>
                            <select id="instansi" name="instansi_id" class="select2 form-select form-select-lg @error('instansi_id') is-invalid @enderror" data-allow-clear="true">
                                <option value="">-- Pilih Instansi --</option>
                                @foreach ($instansis as $instansi)
                                <option value="{{ $instansi->id }}" {{ $acara->instansi_id == $instansi->id ? 'selected' : '' }}>{{ $instansi->nama }}</option>
                                @endforeach
                            </select>
                            @error('instansi_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="flatpickr-date" class="form-label">Tanggal Mulai Acara <span class="text-danger">*</span></label>
                            <input type="text" name="tgl_mulai" class="form-control @error('tgl_mulai') is-invalid @enderror" value="{{ old('tgl_mulai', $acara->tgl_mulai) }}" placeholder="YYYY-MM-DD" id="flatpickr-date" />
                            @error('tgl_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="flatpickr-date1" class="form-label">Tanggal Selesai Acara <span class="text-danger">*</span></label>
                            <input type="text" name="tgl_selesai" class="form-control @error('tgl_selesai') is-invalid @enderror" value="{{ old('tgl_selesai', $acara->tgl_selesai) }}" placeholder="YYYY-MM-DD" id="flatpickr-date1" />
                            @error('tgl_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- <div class="mb-3">
                            <label class="form-label" for="durasi">Durasi Acara (Menit) <span class="text-danger">*</span></label>
                            <input type="number" inputmode="numeric" name="durasi" class="form-control @error('durasi') is-invalid @enderror" value="{{ old('durasi', $acara->durasi) }}" id="durasi" placeholder="Masukan Durasi Acara" />
                            @error('durasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> -->
                        <div class="mb-3">
                            <label class="form-label" for="durasi">Durasi Acara (hari : jam : menit) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" inputmode="numeric" class="form-control" id="durasi_hari" placeholder="Hari" min="0" />
                                <span class="input-group-text">:</span>
                                <input type="number" inputmode="numeric" class="form-control" id="durasi_jam" placeholder="Jam" min="0" max="23" />
                                <span class="input-group-text">:</span>
                                <input type="number" inputmode="numeric" class="form-control" id="durasi_menit" placeholder="Menit" min="0" max="59" />
                            </div>
                            @error('durasi')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input tersembunyi untuk menyimpan total durasi dalam menit -->
                        <input type="hidden" name="durasi" id="durasi_total" value="">

                        <!-- Output Durasi Total -->
                        <div id="totalDurationOutput" class="mt-3 mb-3" style="font-size: 14px;">
                            Total Durasi Acara dalam Menit: <span id="totalDuration">0</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="lokasi">Lokasi Acara <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" rows="3">{{ old('lokasi', $acara->lokasi) }}</textarea>
                            @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="link">Link Berkas Acara</label>
                            <input type="text" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $acara->link) }}" id="link" placeholder="https://berkas.acara" />
                            @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="sifat" class="form-label">Sifat Acara <span class="text-danger">*</span></label>
                            <select id="sifat" name="sifat" class="form-select @error('sifat') is-invalid @enderror">
                                <option value="">-- Pilih Sifat Acara --</option>
                                <option value="offline" {{ old('sifat', $acara->sifat) == 'offline' ? 'selected' : '' }}>Offline</option>
                                <option value="online" {{ old('sifat', $acara->sifat) == 'online' ? 'selected' : '' }}>Online</option>
                            </select>
                            @error('sifat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kuota">Kuota Peserta <span class="text-danger">*</span></label>
                            <input type="number" inputmode="numeric" value="{{ old('kuota', $acara->kuota) }}" name="kuota" class="form-control" id="kuota" placeholder="kuota Peserta" />
                            @error('kuota')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">File Surat/Udangan<span class="text-danger">*</span></label>
                            <input class="form-control" name="file" type="file" id="formFile" accept=".pdf, .png, .jpg, .jpeg">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="catatan">Keterangan/catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3"="">{{ old('catatan', $acara->catatan) }}</textarea>
                            @error('catatan')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="acaraRahasia" class="form-label">Acara rahasia? <span class="text-danger">*</span></label>
                            <select id="acaraRahasia" name="rahasia" class="form-select">
                                <option value="">-- Pilih --</option>
                                <option value="tidak"  {{ old('rahasia', $acara->rahasia) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                <option value="ya" {{ old('rahasia', $acara->rahasia) == 'ya' ? 'selected' : '' }}>Ya</option>
                            </select>
                            @error('rahasia')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="divNomorSurat" class="mb-5">
                            <label class="form-label" for="kode">Nomor Surat/Undangan</label>
                            <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $acara->kode) }}" id="kode" placeholder="Kode Kegitan" />
                            @error('kode')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('plugin-script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>

<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>
@endpush
@push('script')
<script src="{{ asset('assets/js/forms-pickers.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#instansi').select2();
    });

    document.addEventListener('DOMContentLoaded', function() {

        let acaraRahasiaSelect = document.getElementById('acaraRahasia');
        let divNomorSurat = document.getElementById('divNomorSurat');

        function toggleDiv() {
            if (acaraRahasiaSelect.value === 'ya') {
                divNomorSurat.classList.remove('hilang');
            } else {
                divNomorSurat.classList.add('hilang');
            }
        }
        toggleDiv();

        acaraRahasiaSelect.addEventListener('change', toggleDiv);
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Ambil elemen input
        let inputHari = document.getElementById('durasi_hari');
        let inputJam = document.getElementById('durasi_jam');
        let inputMenit = document.getElementById('durasi_menit');
        let totalDurationDisplay = document.getElementById('totalDuration');
        let hiddenTotalDurationInput = document.getElementById('durasi_total');

        // Ambil nilai menit dari database (misal: 1865 menit, Anda bisa mendapatkan nilai ini dari server side)
        let initialTotalMinutes = {{ $acara->durasi }}; // Ganti dengan nilai yang diambil dari database

        // Fungsi untuk membagi nilai menit menjadi hari, jam, dan menit
        function splitDuration(totalMinutes) {
            let hari = Math.floor(totalMinutes / (24 * 60));
            let jam = Math.floor((totalMinutes % (24 * 60)) / 60);
            let menit = totalMinutes % 60;
            return {
                hari: hari,
                jam: jam,
                menit: menit
            };
        }

        // Fungsi untuk menghitung total durasi dalam menit
        function calculateTotalDuration() {
            let hari = parseInt(inputHari.value) || 0;
            let jam = parseInt(inputJam.value) || 0;
            let menit = parseInt(inputMenit.value) || 0;
            return (hari * 24 * 60) + (jam * 60) + menit;
        }

        // Fungsi untuk memperbarui tampilan total durasi
        function updateTotalDuration() {
            let totalDuration = calculateTotalDuration();
            totalDurationDisplay.textContent = totalDuration;
            hiddenTotalDurationInput.value = totalDuration;
        }

        // Inisialisasi form edit dengan nilai dari database
        let initialDurasi = splitDuration(initialTotalMinutes);
        inputHari.value = initialDurasi.hari;
        inputJam.value = initialDurasi.jam;
        inputMenit.value = initialDurasi.menit;
        updateTotalDuration(); // Perbarui nilai total saat inisialisasi

        // Event listener untuk perubahan pada input
        inputHari.addEventListener('input', updateTotalDuration);
        inputJam.addEventListener('input', updateTotalDuration);
        inputMenit.addEventListener('input', updateTotalDuration);
    });
</script>
<script>
    @if($message = Session::get('success'))
    Swal.fire({
        title: 'Good job!',
        text: '{{ $message }}',
        icon: 'success',
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false
    });
    @endif

    @if($message = Session::get('failed'))
    Swal.fire({
        title: 'Error!',
        text: '{{ $message }}',
        icon: 'error',
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false
    });
    @endif
</script>
@endpush
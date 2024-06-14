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

    .input-group-text {
        background-color: #f8f9fa;
    }

    .form-control:focus {
        box-shadow: none;
    }
</style>
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Acara</h4>
    <div class="row mb-4">
        <div class="col-md">
            <div class="card">
                <h5 class="card-header">Tambah Acara</h5>
                <p class="fw-bold px-4" style="font-size: 13px;"><span class="text-danger" style="font-size: 15px;">( * )</span>  Input yang wajib diisi !</p>
                <div class="card-body">
                    <form class="" action="{{ route('acara.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="nama">Name Acara <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Acara" />
                            @error('nama')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="instansi" class="form-label">Instansi <span class="text-danger">*</span></label>
                            <select id="instansi" name="instansi_id" class="select2 form-select form-select-lg" data-allow-clear="true">
                                <option value="">-- Plih Instansi --</option>
                                @foreach ($instansis as $instansi)
                                <option value="{{ $instansi->id }}">{{$instansi->nama}}</option>
                                @endforeach
                            </select>
                            @error('instansi_id')
                            <div class="text-danger" style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="flatpickr-date" class="form-label">Tanggal Mulai Acara <span class="text-danger">*</span></label>
                            <input type="text" name="tgl_mulai" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date" />
                            @error('tgl_mulai')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="flatpickr-date1" class="form-label">Tanggal Selesai Acara <span class="text-danger">*</span></label>
                            <input type="text" name="tgl_selesai" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date1" />
                            @error('tgl_selesai')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- <div class="mb-3">
                            <label class="form-label" for="durasi">Durasi Acara ( Menit ) <span class="text-danger">*</span></label>
                            <input type="number" inputmode="numeric" name="durasi" class="form-control" id="durasi" placeholder="Masukan Durasi Acara" />
                            @error('durasi')
                            <div class="text-danger">{{ $message }}</div>
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
                        <input type="hidden" name="durasi" id="durasi_total" value="">

                        <!-- Output Durasi Total -->
                        <div id="totalDurationOutput" class="mt-3 mb-3" style="font-size: 14px;">
                            Total Durasi Acara dalam Menit: <span id="totalDuration">0</span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="lokasi">Lokasi Acara <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="lokasi" name="lokasi" rows="3"=""></textarea>
                            @error('lokasi')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="link">Link Berkas Acara (jika ada)</label>
                            <input type="text" name="link" class="form-control" id="link" placeholder="https://berkas.acara" />
                            @error('link')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="sifat" class="form-label">Sifat Acara <span class="text-danger">*</span></label>
                            <select id="sifat" name="sifat" class="form-select">
                                <option value="">-- Pilih Sifat Acara --</option>
                                <option value="offline">Offline</option>
                                <option value="online">Online</option>
                            </select>
                            @error('sifat')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label" for="kuota">Kuota Peserta <span class="text-danger">*</span></label>
                            <input type="number" inputmode="numeric" name="kuota" class="form-control" id="kuota" placeholder="kuota Peserta" />
                            @error('kuota')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">File Surat/Undangan<span class="text-danger">*</span></label>
                            <input class="form-control" name="file" type="file" id="formFile" accept=".pdf, .png, .jpg, .jpeg">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="catatan">Keterangan/catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3"=""></textarea>
                            @error('catatan')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="acaraRahasia" class="form-label">Acara rahasia? <span class="text-danger">*</span></label>
                            <select id="acaraRahasia" name="rahasia" class="form-select">
                                <!-- <option value="">-- Pilih --</option> -->
                                <option value="tidak">Tidak</option>
                                <option value="ya">Ya</option>
                            </select>
                            @error('rahasia')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div id="divNomorSurat" class="mb-5 hilang">
                            <label class="form-label" for="kode">Nomor Surat/Undangan</label>
                            <input type="text" name="kode" class="form-control" id="kode" placeholder="Kode Kegiatan" />
                            @error('kode')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Tambah</button>
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

        function calculateTotalDuration() {
            let hari = parseInt(inputHari.value) || null;
            let jam = parseInt(inputJam.value) || null;
            let menit = parseInt(inputMenit.value) || null;
            return (hari * 24 * 60) + (jam * 60) + menit;
        }

        function updateTotalDuration() {
            let totalDuration = calculateTotalDuration();
            totalDurationDisplay.textContent = totalDuration;
            hiddenTotalDurationInput.value = totalDuration;
        }

        inputHari.addEventListener('input', updateTotalDuration);
        inputJam.addEventListener('input', updateTotalDuration);
        inputMenit.addEventListener('input', updateTotalDuration);

        updateTotalDuration();
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
@extends('layouts.horizontal_dashboard.app')

@push('plugin-css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Beranda /</span> Laporan</h4>
    <div class="card">
        <h5 class="card-header">Cari Laporan Kegiatan</h5>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-10 col-xs-12">
                    <div class="mb-3">
                        <label for="acara" class="form-label">Kegiatan/Acara</label>
                        <select id="acara" name="acara_id" class="select2 form-select form-select-lg" data-allow-clear="true">
                            <option value="">-- Pilih Kegiatan/Acara --</option>
                            @foreach ($acaras as $acara)
                            <option value="{{ $acara->id }}">{{$acara->nama}}</option>
                            @endforeach
                        </select>
                        @error('acara_id')
                        <div class="text-danger" style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div id="download-button" class="mt-3 mb-3" style="display: none;">
                <p style="font-weight: bold;">Silahkan <span class="text-primary">Unduh</span> lampiran kartu pendaftaran dibawah ini!</p>
                <button type="button" id="unduh" class="btn btn-primary">
                    <span class="ti-xs ti ti-download me-1"></span>Unduh
                </button>
            </div>
            <div class="mb-3" id="not-found" style="display: none;">
            <div class="mt-3 d-flex align-items-center">
                <img src="{{ asset('assets/svg/icons/not-found.svg') }}" alt="not found" width="50">
                <p style="font-weight: bold;">Maaf, kartu pendaftaran tidak ditemukan, coba lagi!</p>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endpush

@push('script')
<script>
    $(document).ready(function() {
        $('#acara').select2();

        $('#acara').on('change', function() {
            let acara_id = $('#acara').val();

            if(acara_id) {
                $.ajax({
                    url: "{{ route('cek.report') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        acara_id: acara_id,
                    },
                    success: function(response) {
                        // console.log(response);
                        if(response.status === 'success') {
                            $('#download-button').show();
                            $('#unduh').attr('data-uuid', response.data.uuid);
                            $('#not-found').hide();
                        } else {
                            $('#download-button').hide();
                            $('#not-found').show();
                        }
                    },
                    error: function() {
                        $('#download-button').hide();
                        $('#not-found').show();
                    }
                });
            } else {
                $('#download-button').hide();
                $('#not-found').hide();
            }
        });

        $('#unduh').on('click', function() {
            let uuid = $(this).attr('data-uuid');
            window.location.href = "{{ url('/report/acara/pdf') }}/" + uuid;
        });
    });
</script>
@endpush

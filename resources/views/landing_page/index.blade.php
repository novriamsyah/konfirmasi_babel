@extends('layouts.horizontal_dashboard.app')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-academy.css') }}" />
<style>
    .line-clamp-3 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 4;
    }

    @media screen and (max-width: 768px) {
        .app-academy-md-25 img {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="app-academy">
        <div class="card p-0 mb-4">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between p-0 pt-4">
                <div class="app-academy-md-25 card-body py-0">
                    <img src="{{ asset('assets/img/illustrations/bulb-light.png') }}" class="img-fluid app-academy-img-height scaleX-n1-rtl" alt="Bulb in hand" data-app-light-img="illustrations/bulb-light.png" data-app-dark-img="illustrations/bulb-dark.png" height="90" />
                </div>
                <div class="app-academy-md-50 card-body d-flex align-items-md-center flex-column text-md-center">
                    <h3 class="card-title mb-4 lh-sm px-md-2 lh-lg">
                        Konfirmasi Kehadiran Pada Kegiatan Pemerintah 
                        <span class="text-primary fw-medium text-wrap">Provinsi Kepulauan Bangka Belitung</span>.
                    </h3>
                    <p class="mb-3">
                        Dapatkan Informasi Terbaru dan Konfirmasi Kehadiran pada Kegiatan Resmi Pemerintah Provinsi Kepulauan Bangka Belitung
                    </p>
                    <div class="d-flex align-items-center justify-content-between app-academy-md-80 mb-4">
                        <input type="text" id="search" name="search" placeholder="Cari kegiatan disini ..." class="form-control me-2" />
                        <button type="submit" class="btn btn-primary btn-icon"><i class="ti ti-search"></i></button>
                    </div>
                </div>
                <div class="app-academy-md-25 d-flex align-items-end justify-content-end">
                    <img src="{{ asset('assets/img/illustrations/pencil-rocket.png') }}" alt="pencil rocket" height="188" class="scaleX-n1-rtl" />
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex flex-wrap justify-content-between gap-3">
                <div class="card-title mb-0 me-1">
                    <h5 class="mb-1">Kegiatan Terdaftar</h5>
                    <p class="text-muted mb-0">Pilih kegiatan yang ingin diikuti</p>
                </div>
                <div class="d-flex justify-content-md-end align-items-center gap-3 flex-wrap">

                    <select class="select2 form-select" id="filter">
                        <option value="">Semua</option>
                        <option value="hari">Hari ini</option>
                        <option value="minggu">Minggu ini</option>
                        <option value="bulan">Bulan ini</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div id="acara-list" class="row gy-4 mb-4">
                    @include('landing_page.partials.acara_list', ['acaras' => $acaras])
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection

@push('script')
<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->
<script>
    $(document).ready(function() {

        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this,
                    args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }

        function fetch_data(page, search = "", filter = "") {
            $.ajax({
                url: "{{ route('landing.ajaxSearch') }}",
                method: "GET",
                data: {
                    search: search,
                    filter: filter,
                    page: page
                },
                success: function(data) {
                    // console.log(data);
                    $('#acara-list').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    $('#acara-list').html('<p>Data tidak ditemukan.</p>');
                }
            });
        }

        $('#search').on('keyup', debounce(function() {
            let search = $(this).val();
            let filter = $('#filter').val();
            // console.log(search, filter);
            fetch_data(1, search, filter);
        }, 500));

        $('#filter').on('change', function() {
            let search = $('#search').val();
            let filter = $(this).val();
            // console.log(search, filter);
            fetch_data(1, search, filter);
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let search = $('#search').val();
            let filter = $('#filter').val();
            fetch_data(page, search, filter);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(document).on('submit', '.confirmationForm', function(e) {
            e.preventDefault();

            let form = $(this);
            let actionUrl = "{{ route('konfirmasi.peserta') }}";
            let formData = form.serialize();

            $.ajax({
                url: actionUrl,
                method: "POST",
                data: formData,
                beforeSend: function() {
                    form.find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Good job!',
                            text: response.message,
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        }).then(function() {
                            form[0].reset();
                            form.closest('.modal').modal('hide');
                            // location.reload();
                            let redirectUrl = "{{ route('get.kartu.peserta') }}";
                            window.location.href = redirectUrl;

                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            form.find('span.' + key + '_error').text(value[0]);
                        });
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON.message,
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    }
                }
            });
        });
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
@if ($acaras->count() > 0 || !$acaras->isEmpty())

@foreach ($acaras as $acara)

@php
    // Menghitung perbedaan waktu antara tgl_mulai dan waktu sekarang dalam detik
    $diffInSeconds = strtotime($acara->tgl_mulai) - time();
    
    // Menentukan apakah perbedaan waktu sudah mencapai 5 menit atau lebih (300 detik)
    $isButtonDisabled = $diffInSeconds <= -300; // 300 detik = 5 menit

    $formattedDuration = convertMinutesToDuration($acara->durasi);
@endphp

<div class="col-sm-6 col-lg-4 mb-3">
    <div class="card h-100 border p-2">
        <div class="card-body">
            <h4 class="mb-2 pb-1 line-clamp-3">{{ $acara->nama }}</h4>
            <p class="small">
                <strong>Penyelenggara :</strong>&nbsp;{{ $acara->instansi->nama }}
            </p>
            <div class="row mb-3 mt-3 g-3">
                <div class="col-sm-6 col-xs-12">
                    <div class="d-flex">
                        <div class="avatar flex-shrink-0 me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-calendar-event ti-md"></i></span>
                        </div>
                        <div>
                            <h6 class="mb-0 text-nowrap">{{ date('d M Y', strtotime($acara->tgl_mulai)) }}</h6>
                            <small>Tanggal</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="d-flex">
                        <div class="avatar flex-shrink-0 me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-clock ti-md"></i></span>
                        </div>
                        <div>
                            <h6 class="mb-0 text-nowrap">{{ $formattedDuration }}</h6>
                            <small>Durasi</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="d-flex">
                        <div class="avatar flex-shrink-0 me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-target ti-md"></i></span>
                        </div>
                        <div>
                            <h6 class="mb-0 text-nowrap">{{ $acara->kuota }} Orang</h6>
                            <small>Kuota</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="d-flex">
                        <div class="avatar flex-shrink-0 me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-user ti-md"></i></span>
                        </div>
                        <div>
                            <h6 class="mb-0 text-nowrap">{{ $acara->pesertas->count() }} Orang</h6>
                            <small>Terdaftar</small>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-dark w-40 mt-4 me-2" data-bs-toggle="modal" data-bs-target="#backDropModal{{ $acara->id }}">
                Lihat
            </button>
            @if ($isButtonDisabled)
            <!-- <p></p> -->
            <button type="button" class="btn btn-danger disabled w-40 mt-4 me-2">Berakhir</button>
            @else
            <button type="button" class="btn btn-primary w-40 mt-4" data-bs-toggle="modal" data-bs-target="#backDropModalConfirm{{ $acara->id }}">
                Konfirmasi
            </button>
            @endif
            
        </div>
    </div>
</div>

<!-- MODAL LIHAT -->
<div class="modal fade" id="backDropModal{{ $acara->id }}" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Detail Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 class="mb-2 pb-1">{{ $acara->nama }}</h4>
                <p class="small">
                    <strong>Penyelenggara :</strong>&nbsp;{{ $acara->instansi->nama }}
                </p>
                <div class="row mb-5 mt-4 g-3">
                    <div class="col-sm-6 col-xs-12">
                        <div class="d-flex">
                            <div class="avatar flex-shrink-0 me-2">
                                <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-calendar-event ti-md"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-0 text-nowrap">{{ $acara->tgl_mulai }}</h6>
                                <small>Tanggal</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="d-flex">
                            <div class="avatar flex-shrink-0 me-2">
                                <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-clock ti-md"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-0 text-nowrap">{{$formattedDuration}}</h6>
                                <small>Durasi</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                    <div class="d-flex">
                        <div class="avatar flex-shrink-0 me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-target ti-md"></i></span>
                        </div>
                        <div>
                            <h6 class="mb-0 text-nowrap">{{ $acara->kuota }} Orang</h6>
                            <small>Kuota</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="d-flex">
                        <div class="avatar flex-shrink-0 me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-user ti-md"></i></span>
                        </div>
                        <div>
                            <h6 class="mb-0 text-nowrap">{{ $acara->pesertas->count() }} Orang</h6>
                            <small>Terdaftar</small>
                        </div>
                    </div>
                </div>
                </div>
                <hr>
                <p class="mb-3">
                    <strong>Lokasi/Link :</strong>&nbsp;{{ $acara->lokasi }}
                </p>
                @if ($acara->link != null)
                <p class="mb-3">
                    <strong>Link Berkas :</strong>&nbsp;<span style="color: blue; text-decoration: underline;">{{ $acara->link }}</span>
                </p>
                @endif
                <p class="mb-3">
                    <strong>Dilaksakan :</strong>&nbsp;{{ $acara->sifat }}
                </p>
                <p class="mb-3">
                    <strong>Catatan :</strong>&nbsp;{{ $acara->catatan }}
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL KONFIRMASI -->
<div class="modal fade" id="backDropModalConfirm{{ $acara->id }}" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="confirmationForm" class="modal-content confirmationForm">
            @csrf
            <input type="hidden" name="acara_id" value="{{ $acara->id }}">
            <input type="hidden" name="kode_surat" value="{{ $acara->kode ?? '' }}">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">
                    <span style="font-weight: bold;">Form Konfirmasi Kehadiran: </span><br><br>{{ $acara->nama }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBackdrop{{ $acara->id }}" class="form-label">Nama</label>
                        <input type="text" id="nameBackdrop{{ $acara->id }}" name="nama" class="form-control" placeholder="Masukan nama" />
                        <span class="text-danger error-text nama_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="emailBackdrop{{ $acara->id }}" class="form-label">Email</label>
                        <input type="text" id="emailBackdrop{{ $acara->id }}" name="email" class="form-control" placeholder="Masukan Email" />
                        <span class="text-danger error-text email_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="teleponBackdrop{{ $acara->id }}" class="form-label">Telepon</label>
                        <input type="text" id="teleponBackdrop{{ $acara->id }}" name="telepon" class="form-control" placeholder="Masukan Telepon" />
                        <span class="text-danger error-text telepon_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="organisasiBackdrop{{ $acara->id }}" class="form-label">Organisasi</label>
                        <input type="text" id="organisasiBackdrop{{ $acara->id }}" name="organisasi" class="form-control" placeholder="Masukan Organisasi" />
                        <span class="text-danger error-text organisasi_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="jabatanBackdrop{{ $acara->id }}" class="form-label">Jabatan</label>
                        <input type="text" id="jabatanBackdrop{{ $acara->id }}" name="jabatan" class="form-control" placeholder="Masukan Jabatan" />
                        <span class="text-danger error-text jabatan_error"></span>
                    </div>
                </div>
                @if ($acara->kode)
                <div class="row">
                    <div class="col mb-3">
                        <label for="kodeUnikBackdrop{{ $acara->id }}" class="form-label">Nomor Surat/Undangan</label>
                        <input type="text" id="kodeUnikBackdrop{{ $acara->id }}" name="kode_unik" class="form-control" placeholder="000/XX/UND/Yxz/2024" />
                        <span class="text-danger error-text kode_unik_error"></span>
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
        </form>
    </div>
</div>
@endforeach
<nav class="d-flex align-items-center justify-content-center py-3">
    {{ $acaras->links() }}
</nav>

@else
<div class="d-flex flex-column align-items-center justify-content-center">
    <img src="{{ asset('assets/svg/icons/not-found.svg') }}" style="display: block;" alt="not found" width="100">
    <p class="d-flex align-items-center justify-content-center" style="font-weight: bold;">Maaf Data tidak ditemukan !!!</p>
</div>
@endif
@extends('layouts.horizontal_dashboard.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Beranda /</span> Acara</h4>
    <div class="card">
        <div class="d-flex d-flex-row align-items-center ">
            <h5 class="card-header">Acara Terdaftar</h5>
            <a href="{{ route('acara.create') }}" role="button" class="btn btn-icon btn-success waves-effect waves-light">
                <span class="ti ti-plus"></span>
            </a>
        </div>
        <div class="table-responsive text-wrap p-4">
            <table id="dataAcara" class="table table-striped dataTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Acara</th>
                        <th>Tgl. Acara</th>
                        <th>Penyelenggara</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                </tbody>
            </table>
            <form action="" method="POST" id="deleteForm">

                @csrf
                @method('DELETE')
                <input type="submit" value="Hapus" style="display: none">
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    $(function() {
        $('#dataAcara').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            paging: true,
            ajax: "{{ route('acara.datatable') }}",
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama',
                    searchable: true
                },
                {
                    data: 'tanggal_acara',
                    searchable: true
                },
                {
                    data: 'nama_instansi',
                    searchable: true,
                },
                {
                    data: 'lokasi',
                    searchable: true,
                },
                {
                    data: 'action'
                }
            ]
        })
    })
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
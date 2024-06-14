<!DOCTYPE html>
<html>

<head>
    <title>{{ $acara->nama }}</title>
    <style type="text/css">
        html {
            margin: 0;
            padding: 0;
            font-family: "Nunito", sans-serif;
        }

        .header {
            width: 100%;
            height: auto;
            background-color: #f7f7f7;
            padding-bottom: 50px;
        }

        .judul {
            justify-content: center;
            align-items: center;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .table-header tr td {
            padding: 5px;
            color: #000;
            font-size: 14pt;
        }

        .table-content tr th {
            padding: 8px;
            font-size: 10pt;
            color: #000;
            border-bottom: 1px solid #ddd;
        }

        .table-content tr td {
            padding: 8px;
            font-size: 9.4pt;
            color: #454545;
            border-bottom: 1px solid #ddd;
        }

        .body-content {
            margin-top: 50px;
        }

        .badge {
            border-radius: 2px;
            color: #fff;
            display: inline-block;
            line-height: 1;
            min-width: 10px;
            font-size: 10px;
            font-weight: bold;
            padding: 3px 7px;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }

        .badge-primary {
            background-color: #7571f9;
        }

        .badge-success {
            background-color: #22c55e;
        }

        .badge-danger {
            background-color: #ef4444;
        }
    </style>
</head>

<body>
    <div class="body-content">
        <div class="text-center" style="margin-bottom: 50px;">
            <h4>Rekap Registrasi Peserta : {{ $acara->nama }}</h4>
        </div>
        <table style="width: 100%; border-collapse: collapse; padding-right: 50px; padding-left: 50px;" class="table-content">
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Organisasi</th>
                <th>Jabatan</th>
                <th>Absen</th>
            </tr>
            
                @foreach($pesertas as $peserta)
                <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $peserta->nama }}</td>
                <td class="text-center">{{ $peserta->email }}</td>
                <td class="text-center">{{ $peserta->telepon }}</td>
                <td class="text-justify">{{ $peserta->organisasi }} </td>
                <td class="text-center">{{ $peserta->jabatan }}</td>
                @if ($peserta->absen)
                <td class="text-center">Hadir</td>
                @else
                <td class="text-center">Belum Hadir</td>
                @endif
               
                
                </tr>
                
                @endforeach
            
        </table>
    </div>
</body>
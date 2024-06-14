@extends('layouts.horizontal_dashboard.app')

@push('css')
<style>
    .main-bg {
        background: linear-gradient(90deg, rgba(76, 131, 186, 1) 0%, rgba(76, 131, 186, 1) 35%, rgba(192, 211, 231, 1) 100%);
        display: flex;
        min-height: 100vh;
    }

    @media (max-width: 768px) {
        #reader__scan_region {
            height: 350px;
        }

        #reader__scan_region img {
            height: 350px;
        }

        #reader__scan_region video {
            height: 350px;
        }

    }

    @media (min-width: 768px) and (max-width: 992px) {
        #reader__scan_region {
            height: 700px;
        }

        #reader__scan_region img {
            height: 700px;
            width: 200px;
        }

        #reader__scan_region video {
            height: 700px;
        }

    }

    @media (min-width: 992px) {
        #reader {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 90%;
        
        }

        #reader__scan_region  {
            border: 1px solid #e6e6e6;
        }

        #reader__scan_region img {
            width: 250px;
        }
    }

    #html5-qrcode-button-camera-start {
        background-color: #22c55e;
        border-radius: 10px;
        border-color: #00c112;
        color: #ffffff;
        font-weight: bold;
        padding: 10px 15px;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    #html5-qrcode-button-camera-stop {
        background-color: #ef4444;
        border-radius: 10px;
        border-color: #dc2626;
        color: #fff;
        font-weight: bold;
        padding: 10px 15px;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    #html5-qrcode-button-camera-permission {
        background-color: #f97316;
        border-radius: 10px;
        border-color: #ea580c;
        color: #fff;
        font-weight: bold;
        padding: 10px 15px;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    #html5-qrcode-select-camera{
        padding: 10px 5px;
    }

    #reader video {
        max-width: 100%;
        max-height: 100%;
    }
</style>
@endpush

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card h-100">
        <div class="card-body">

            <audio id="successAudio" src="{{ asset('assets/music/access_granted.mp3') }}" preload="auto"></audio>
            <audio id="deniedAudio" src="{{ asset('assets/music/access_denied.mp3') }}" preload="auto"></audio>
            <audio id="thankAudio" src="{{ asset('assets/music/thanks.mp3') }}" preload="auto"></audio>
            <h5 class="card-title text-center">Scan Qrcode Disini</h5>
            <div id="reader"></div>
            <div>
                <p id="read-result"></p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('plugin-script')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
@endpush

@push('script')
<script>
    function onScanSuccess(decodedText, decodedResult) {
        let uuid = decodedText;
        $.ajax({
            url: "{{ route('validasi-qr') }}",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                uuid: uuid,
            },
            success: function(res) {
                if (res.success === true) {
                    const successAudio = document.getElementById('successAudio');
                    successAudio.play();
                    Swal.fire({
                        title: 'Good job!',
                        text: res.message,
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                } else if (res.success == 'absen expired') {
                    const thankAudio = document.getElementById('thankAudio');
                    thankAudio.play();
                    Swal.fire({
                        title: 'Warning!',
                        text: res.message,
                        icon: 'warning',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false,
                    });
                } else {
                    const deniedAudio = document.getElementById('deniedAudio');
                    deniedAudio.play();
                    Swal.fire({
                        title: 'Error!',
                        text: res.message,
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                }
            },
            error: function(res) {
                console.log(res)
            }
        });

        setTimeout(function() {
            html5QrcodeScanner.restart();
        }, 5000); // 5000 milliseconds = 5 seconds
    }

    function onScanFailure(error) {
        console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: {
                width: 400,
                height: 400
            }
        },
        /* verbose= */
        false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endpush

@extends('layouts.horizontal_dashboard.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<section id="landingContact" class="section-py bg-body landing-contact">
  <div class="container">
    <div class="text-center mb-3 pb-1">
      <span class="badge bg-label-primary" style="font-size: 14pt;">Hubungi Kami</span>
    </div>
    <h3 class="text-center mb-1"><span class="section-title">Jika anda mempunyai pertanyaan</span></h3>
    <p class="text-center mb-4 mb-lg-5 pb-md-3">Silahkan hubungi kami</p>
    <div class="row gy-4">
      <div class="col-lg-5">
        <div class="contact-img-box position-relative border p-2 h-100">
          <img src="../../assets/img/front-pages/landing-page/contact-customer-service.png" alt="contact customer service" class="contact-img w-100 scaleX-n1-rtl" />
          <div class="pt-3 px-4 pb-1">
            <div class="row gy-3 gx-md-4">
              <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="d-flex align-items-center">
                  <div class="badge bg-label-primary rounded p-2 me-2"><i class="ti ti-mail ti-sm"></i></div>
                  <div>
                    <p class="mb-0">Email</p>
                    <h5 class="mb-0">
                      <a href="mailto:example@gmail.com" class="text-heading">info@babelprov.go.id</a>
                    </h5>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="d-flex align-items-center">
                  <div class="badge bg-label-success rounded p-2 me-2">
                    <i class="ti ti-phone-call ti-sm"></i>
                  </div>
                  <div>
                    <p class="mb-0">Whatsapp</p>
                    <h5 class="mb-0"><a href="tel:+1234-568-963" class="text-heading">085273597324</a></h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
              <div class="accordion" id="accordionExample">
                <div class="card accordion-item active">
                  <h2 class="accordion-header" id="headingOne">
                    <button
                      type="button"
                      class="accordion-button"
                      data-bs-toggle="collapse"
                      data-bs-target="#accordionOne"
                      aria-expanded="true"
                      aria-controls="accordionOne">
                      Bagaimana cara melakukan konfirmasi keikutsertaan pada kegiatan pemerintahan Provinsi?
                    </button>
                  </h2>

                  <div id="accordionOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Coming soon...
                    </div>
                  </div>
                </div>
                <div class="card accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button
                      type="button"
                      class="accordion-button collapsed"
                      data-bs-toggle="collapse"
                      data-bs-target="#accordionTwo"
                      aria-expanded="false"
                      aria-controls="accordionTwo">
                      Bagaimana cara mencetak kartu bukti pendaftaran kegiatan?
                    </button>
                  </h2>
                  <div
                    id="accordionTwo"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Coming soon...
                    </div>
                  </div>
                </div>
                <div class="card accordion-item">
                  <h2 class="accordion-header" id="headingThree">
                    <button
                      type="button"
                      class="accordion-button collapsed"
                      data-bs-toggle="collapse"
                      data-bs-target="#accordionThree"
                      aria-expanded="false"
                      aria-controls="accordionThree">
                      Bagaimana cara mencari Acara/Kegiatan pada aplikasi ini?
                    </button>
                  </h2>
                  <div
                    id="accordionThree"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Coming soon...
                    </div>
                  </div>
                </div>
                <div class="card accordion-item">
                  <h2 class="accordion-header" id="headingFour">
                    <button
                      type="button"
                      class="accordion-button collapsed"
                      data-bs-toggle="collapse"
                      data-bs-target="#accordionFour"
                      aria-expanded="false"
                      aria-controls="accordionFour">
                      Jika telah mendaftar apa yang saya lakukan setelahnya?
                    </button>
                  </h2>
                  <div
                    id="accordionFour"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingFour"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Coming soon...
                    </div>
                  </div>
                </div>
              </div>
            </div>
    </div>
  </div>
</section>
</div>
<!-- Contact Us: End -->
@endsection
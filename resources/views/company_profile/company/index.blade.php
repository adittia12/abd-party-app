@extends('company_profile.frontend.master')

@section('title')
    CP - ABD
@endsection

@section('style')
    @include('company_profile.company.components.css.style')
@endsection

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section">

        <div class="container d-flex flex-column justify-content-center align-items-center text-center position-relative"
            data-aos="zoom-out">
            <img src="{{ asset('admin/assets/img/logo_abd-removebg-preview.png') }}" width="380px" class="img-fluid animated"
                alt="">
            <h1>Welcome to <span>ABD-KAUM</span></h1>
            <p>ABD Rental merupakan perusahaan jasa yang bergerak di bidang sewa tenda, dekorasi, wedding organizer,
                sewa kursi, dan sewa alat pesta lainnya. Berdiri di Karawang, Jawa Barat, sejak 1985, kami secara konsisten
                mengembangkan usaha dengan totalitas. Alhamdulillah, kerja keras kami berbuah manis, ditandai dengan adanya
                peningkatan pada jumlah pengguna jasa kami hingga saat ini.</p>
        </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

        @include('company_profile.company.components.profile.profile')

    </section><!-- /About Section -->

    <!-- Clients Section -->
    <section id="clients" class="clients section">

        <div class="container justify-content-center" data-aos="fade-up">

            <div class="row gy-4">

                @foreach ($dataClient as $item)
                    <div class="col-xl-2 col-md-3 col-6 client-logo">
                        <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid" alt="{{ $item->client_name }}">
                    </div><!-- End Client Item -->
                @endforeach

            </div>

        </div>

    </section><!-- /Clients Section -->


    <!-- Services Section -->
    <section id="services" class="services section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Services</h2>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-5">

                @if ($dataService->isNotEmpty())
                    @foreach ($dataService as $serviceItem)
                        <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                            <div class="service-item">
                                <div class="img">
                                    <img src="{{ asset('storage/' . $serviceItem->name_photo) }}"
                                        class="img-fluid uniform-image" alt="">
                                </div>
                                <div class="details position-relative">
                                    <div class="icon">
                                        <i class="bi bi-info-circle"></i>
                                    </div>
                                    <a href="#" class="stretched-link">
                                        <h3>{{ $serviceItem->title }}</h3>
                                    </a>
                                    <p>{{ $serviceItem->description }}</p>
                                </div>
                            </div>
                        </div><!-- End Service Item -->
                    @endforeach
                @else
                    <div class="alert alert-danger" role="alert">
                        Data tidak ada
                    </div>
                @endif
            </div>

        </div>

    </section><!-- /Services Section -->

    <!-- Features Section -->
    <section id="features" class="features section">
        @include('company_profile.company.components.service_item.service_item')
    </section><!-- /Features Section -->


    <!-- Documentation Section -->
    <section id="gallery" class="portfolio section">

        @include('company_profile.company.components.gallery.documentation')

    </section><!-- /Documentation Section -->

    <!-- Legal Section -->
    <section id="legal" class="portfolio section">

        @include('company_profile.company.components.legal.data_legal')

    </section><!-- /Legal Section -->

    <!-- Testimonials Section -->
    @if ($dataComentar->isNotEmpty())
        <section id="testimonials" class="testimonials section dark-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Comentar</h2>
            </div><!-- End Section Title -->

            <img src="{{ asset('company-profile/assets/img/testimonials-bg.jpg') }}" class="testimonials-bg" alt="">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
    {
      "loop": true,
      "speed": 600,
      "autoplay": {
        "delay": 5000
      },
      "slidesPerView": "auto",
      "pagination": {
        "el": ".swiper-pagination",
        "type": "bullets",
        "clickable": true
      }
    }
  </script>
                    <div class="swiper-wrapper">

                        @foreach ($dataComentar as $comentarItem)
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <img src="{{ asset('company-profile/assets/img/testimonials/avatar-1.png') }}"
                                        class="testimonial-img" alt="">
                                    <h3>{{ $comentarItem->name }}</h3>
                                    <h4>{{ $comentarItem->title }}</h4>
                                    <p>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        <span>{{ $comentarItem->description }}</span>
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </p>
                                </div>
                            </div><!-- End testimonial item -->
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>

        </section><!-- /Testimonials Section -->
    @endif

    <!-- Contact Section -->
    <section id="contact" class="contact section">

        @include('company_profile.company.components.contacts.contact')

    </section><!-- /Contact Section -->
@endsection

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
    <h2>Contact</h2>
</div><!-- End Section Title -->

<!-- Google Maps -->
<div class="mb-5">
    <iframe style="width: 100%; height: 400px;"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.6477426917627!2d107.28935747533372!3d-6.309923261751014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6977e30f97e07b%3A0x6cb36ca96859dd3d!2sABD%20Rental%20Sewa%20Tenda%20Karawang!5e0!3m2!1sen!2sid!4v1725090197055!5m2!1sen!2sid"
        frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div><!-- End Google Maps -->

<div class="container" data-aos="fade">
    <div class="row gy-5 gx-lg-5">
        <div class="col-lg-4">
            <div class="info">
                <h3>Get in touch</h3>

                <div class="info-item d-flex">
                    <i class="bi bi-geo-alt flex-shrink-0"></i>
                    <div>
                        <h4>Location:</h4>
                        <p>Jl. KH. Ahmad Dahlan Kaum I No. 7 RT/RW 16/08 (Belakang Masjid Agung) Karawang, Jawa Barat
                            INDONESIA - 41311 (0267) 401440</p>
                    </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex">
                    <i class="bi bi-envelope flex-shrink-0"></i>
                    <div>
                        <h4>Email:</h4>
                        <p>abdulbasitabdkaum1@gmail.com</p>
                    </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex">
                    <i class="bi bi-phone flex-shrink-0"></i>
                    <div>
                        <h4>Call:</h4>
                        <p>Bpk. Abdul Basit <br><b>08562003009</b></p>
                    </div>
                </div><!-- End Info Item -->
            </div>
        </div>

        <div class="col-lg-8">
            <form action="{{ route('store_coment') }}" method="post" role="form">
                @csrf
                <div class="form-group mt-3">
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                        id="title" placeholder="Ketik Judul" value="{{ old('title') }}">
                    @if ($errors->has('title'))
                        <span class="text-danger text-sm">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="name" placeholder="Ketika Nama Anda" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="text-danger text-sm">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Message"
                        rows="8">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger text-sm">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="text-center mt-3"><button class="btn btn-primary" type="submit">Send Message</button></div>
            </form>
        </div><!-- End Contact Form -->
    </div>
</div>

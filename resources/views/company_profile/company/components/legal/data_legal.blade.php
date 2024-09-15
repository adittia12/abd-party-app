<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
    <h2>Data & Legal Company</h2>
</div><!-- End Section Title -->

<div class="container-fluid">

    <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

        <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li hidden data-filter="*" class="filter-active">All</li>
        </ul><!-- End Portfolio Filters -->

        <div class="row g-0 isotope-container" data-aos="fade-up" data-aos-delay="200">

            @foreach ($dataLegal as $legalItem)
                <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                    <div class="portfolio-content h-100">
                        <img src="{{ asset('storage/' . $legalItem->document) }}" class="img-fluid"
                            alt="{{ $legalItem->title }}">
                        <div class="portfolio-info">
                            <a href="{{ asset('storage/' . $legalItem->document) }}"
                                data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i
                                    class="bi bi-zoom-in"></i></a>
                        </div>
                    </div>
                </div><!-- End Portfolio Item -->
            @endforeach


        </div><!-- End Portfolio Container -->
    </div>
</div>

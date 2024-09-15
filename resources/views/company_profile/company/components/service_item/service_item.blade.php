<div class="container" data-aos="fade-up">

    <ul class="nav nav-tabs row gy-4 d-flex justify-content-center" id="features-tab-list">

        <li class="nav-item col-6 col-md-4 col-lg-2">
            <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1">
                <i class="bi bi-info-square" style="color: #6610f2;"></i>
                <h4>Service Area</h4>
            </a>
        </li><!-- End Tab 1 Nav -->
        <li class="nav-item col-6 col-md-4 col-lg-2">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-2">
                <i class="bi bi-layout-wtf" style="color: #20c997;"></i>
                <h4>Service Strategy</h4>
            </a>
        </li><!-- End Tab 1 Nav -->
        <li class="nav-item col-6 col-md-4 col-lg-2">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-3">
                <i class="bi bi-list-check" style="color: #df1529;"></i>
                <h4>Workforce Skills</h4>
            </a>
        </li><!-- End Tab 1 Nav -->
    </ul>

    <div class="tab-content">

        <div class="tab-pane fade active show" id="features-tab-1">
            <div class="row gy-4">
                <div class="col-lg-8 order-2 order-lg-1 service-area-container" data-aos="fade-up" data-aos-delay="100">
                    <h3>Service Area</h3>
                    <ul class="service-list">
                        @if ($dataServiceArea->isNotEmpty())
                            @foreach ($dataServiceArea as $areaItem)
                                @if ($areaItem->area)
                                    <li><i class="bi bi-check-circle-fill"></i> <span>{{ $areaItem->area }}</span>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <div class="alert alert-danger" role="alert">
                                Data tidak ada
                            </div>
                        @endif
                    </ul>
                </div>

                <div class="col-lg-4 order-1 order-lg-2 text-center" data-aos="fade-up" data-aos-delay="200">
                    <img src="{{ asset('company-profile/assets/img/map.svg') }}" alt="" class="img-fluid">
                </div>
            </div>
        </div><!-- End Tab Content 1 -->

        <div class="tab-pane fade" id="features-tab-2">
            <div class="row gy-4">
                <div class="col-lg-8 order-2 order-lg-1">
                    <h3>Service Strategy</h3>
                    <ul class="service-list">
                        @if ($dataServiceStrategy->isNotEmpty())
                            @foreach ($dataServiceStrategy as $strategyItem)
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>
                                        <span>{{ $strategyItem->title }}</span>
                                        <p class="description">{{ $strategyItem->description }}</p>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <div class="alert alert-danger" role="alert">
                                Data tidak ada
                            </div>
                        @endif
                    </ul>
                </div>

                <div class="col-lg-4 order-1 order-lg-2 text-center">
                    <img src="{{ asset('company-profile/assets/img/strategy.svg') }}" alt="" class="img-fluid">
                </div>
            </div>
        </div><!-- End Tab Content 2 -->

        <div class="tab-pane fade" id="features-tab-3">
            <div class="row gy-4">
                <div class="col-lg-8 order-2 order-lg-1 skills-list-container">
                    <h3>Workforce Skills</h3>
                    <ul class="skills-list">
                        @if ($dataSkill->isNotEmpty())
                            @foreach ($dataSkill as $skillItem)
                                <li><i class="bi bi-check-circle-fill"></i> <span>{{ $skillItem->skill }}</span>
                                </li>
                            @endforeach
                        @else
                            <div class="alert alert-danger" role="alert">
                                Data tidak ada
                            </div>
                        @endif
                    </ul>
                </div>

                <div class="col-lg-4 order-1 order-lg-2 text-center">
                    <img src="{{ asset('company-profile/assets/img/skill.svg') }}" alt="" class="img-fluid">
                </div>
            </div>
        </div><!-- End Tab Content 3 -->
    </div>

</div>

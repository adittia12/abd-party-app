@extends('frontend.layout.master')

@section('title')
    Dashboard | ABD
@endsection

@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Admin</h4>
                        </div>
                        <div class="card-body">
                            10
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Barang Rental</h4>
                        </div>
                        <div class="card-body">
                            {{ $productCount }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Reports</h4>
                        </div>
                        <div class="card-body">
                            1,201
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Online Users</h4>
                        </div>
                        <div class="card-body">
                            47
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Realisasi Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="transactionsChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
@section('script')
    <script>
        $(document).ready(function() {
            function formatRupiahData(amount) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(amount);
            }

            function formatRupiahWithUnits(amount) {
                if (amount >= 1000000000) {
                    return (amount / 1000000000).toFixed(0) + 'M'; // M untuk milyar
                } else if (amount >= 1000000) {
                    return (amount / 1000000).toFixed(0) + 'jt'; // jt untuk juta
                } else if (amount >= 1000) {
                    return (amount / 1000).toFixed(0) + 'k';
                } else {
                    return amount.toFixed(0);
                }
            }

            document.addEventListener("DOMContentLoaded", function() {
                var ctx = document.getElementById("transactionsChart").getContext("2d");
                var gradient = ctx.createLinearGradient(0, 0, 0, 225);
                gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
                gradient.addColorStop(1, "rgba(215, 227, 244, 0)");

                // Line chart
                new Chart(document.getElementById("transactionsChart"), {
                    type: "line",
                    data: {
                        labels: <?php echo json_encode($labelsTransaction); ?>,
                        datasets: [{
                            label: "Realisasi Transaksi",
                            fill: true,
                            backgroundColor: gradient,
                            borderColor: window.theme.primary,
                            data: <?php echo json_encode($dataTransaction); ?> // Data tetap dalam bentuk numerik
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                        tooltips: {
                            intersect: false,
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    return formatRupiahData(tooltipItem
                                        .yLabel
                                    ); // Menampilkan nilai tooltip dalam format Rupiah
                                }
                            }
                        },
                        hover: {
                            intersect: true
                        },
                        plugins: {
                            filler: {
                                propagate: false
                            }
                        },
                        scales: {
                            xAxes: [{
                                reverse: true,
                                gridLines: {
                                    color: "rgba(0,0,0,0.0)"
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    stepSize: 1000,
                                    callback: function(value, index, values) {
                                        return formatRupiahWithUnits(
                                            value
                                        ); // Menampilkan label sumbu Y dalam format dengan satuan
                                    }
                                },
                                display: true,
                                borderDash: [3, 3],
                                gridLines: {
                                    color: "rgba(0,0,0,0.0)"
                                }
                            }]
                        }
                    }
                });
            });
        });
    </script>
@endsection
@endsection

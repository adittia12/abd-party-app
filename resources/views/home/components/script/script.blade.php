<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function() {
        if (typeof window.theme === 'undefined') {
            window.theme = {};
        }
        if (typeof window.theme.primary === 'undefined') {
            window.theme.primary = '#007bff'; // Ganti dengan warna default yang Anda inginkan
        }

        function formatRupiahData(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(amount);
        }

        function formatRupiah(amount) {
            if (amount >= 1000000000) {
                return (amount / 1000000000).toFixed(0) + 'jt';
            } else if (amount >= 1000000) {
                return (amount / 1000000).toFixed(0) + 'jt';
            } else if (amount >= 1000) {
                return (amount / 1000).toFixed(0) + 'k';
            } else {
                return amount.toFixed(0);
            }
        }

        let labels = @json($dataTransaction['labels']);
        let datasets = @json($dataTransaction['datasets']);

        let ctx = document.getElementById("transactionsChart").getContext("2d");
        let gradient = ctx.createLinearGradient(0, 0, 0, 225);
        gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
        gradient.addColorStop(1, "rgba(215, 227, 244, 0)");

        let transactionsChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: "Total Nominal",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: window.theme.primary,
                    data: datasets
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
                            return formatRupiahData(tooltipItem.yLabel);
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
                            color: "rgba(0,0,0,0.1)",
                            drawBorder: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            min: 0, // Set nilai minimum sumbu Y
                            maxTicksLimit: 5, // Batasan maksimum jumlah nilai sumbu Y yang ditampilkan
                            callback: function(value, index, values) {
                                return formatRupiah(
                                    value); // Gunakan fungsi format jika diperlukan
                            }
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0.1)",
                            drawBorder: false
                        }
                    }]
                }
            }
        });

        // Event handler untuk form filter
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            var month = $('#filteringMonth').val();
            var year = $('#filterYear').val();
            $.get('', {
                filteringMonth: month,
                filterYear: year
            }, function(data) {
                transactionsChart.data.labels = data.labels;
                transactionsChart.data.datasets[0].data = data.datasets;
                transactionsChart.update();
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#filterYearCuti').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let donutOrderLabels = @json($donutOrder['labels']);
        let donutOrderData = @json($donutOrder['datasets']);

        var ctx = document.getElementById("doughnut-order").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: donutOrderData,
                    backgroundColor: [
                        '#3df2f5',
                        '#63ed7a',
                        '#ffa426',
                        '#fc544b',
                        '#6777ef',
                    ],
                    label: 'Jumlah Status Order'
                }],
                labels: donutOrderLabels,
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });
    });
</script>

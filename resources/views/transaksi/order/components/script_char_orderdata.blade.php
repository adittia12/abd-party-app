{{-- Chart Config --}}
<script>
    const labels = @json($dataChartOrder->pluck('tanggal'));
    const data = @json($dataChartOrder->pluck('total_order'));

    const ctx = document.getElementById('ordersChart').getContext('2d');
    const ordersChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Order',
                data: data,
                backgroundColor: 'rgba(13, 110, 253, 0.7)', // Bootstrap Primary semi-transparent
                borderRadius: 8,
                borderSkipped: false,
                hoverBackgroundColor: 'rgba(13, 110, 253, 1)',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#000',
                    bodyColor: '#000',
                    borderColor: '#ddd',
                    borderWidth: 1
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#495057',
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    },
                    grid: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Tanggal Order',
                        color: '#6c757d',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#495057',
                        stepSize: 1,
                        precision: 0
                    },
                    grid: {
                        color: '#e9ecef'
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Order',
                        color: '#6c757d',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });
</script>

// ----------------------------------------------------------------
// File: resources/js/charts/dashboard-charts.js
// Description: Initializes ApexCharts for the main dashboard view.
// ----------------------------------------------------------------

document.addEventListener('DOMContentLoaded', function () {
    // Check if the chart container exists
    const chartElement = document.getElementById('dashboard-chart');
    if (!chartElement) {
        // console.error('Dashboard chart container not found.');
        return;
    }

    // Example data for Monthly Platform Performance (Revenue & Bookings)
    const chartOptions = {
        series: [
            {
                name: 'Revenue (USD)',
                type: 'area',
                data: [3000, 4500, 5000, 4800, 5500, 6200, 7000, 6800, 7500, 8000, 7800, 8500]
            },
            {
                name: 'Total Bookings',
                type: 'line',
                data: [450, 600, 720, 700, 850, 950, 1050, 1000, 1150, 1250, 1200, 1300]
            }
        ],
        chart: {
            height: 380,
            type: 'line',
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        colors: ['#3b82f6', '#10b981'], // Blue 500 and Green 500
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: [4, 2]
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 100]
            }
        },
        title: {
            text: 'Year-to-Date Performance',
            align: 'left',
            style: {
                fontSize: '16px',
                color: '#1e293b'
            }
        },
        xaxis: {
            categories: [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ],
            title: {
                text: 'Month'
            }
        },
        yaxis: [
            {
                title: {
                    text: 'Revenue (USD)'
                },
                labels: {
                    formatter: function (val) {
                        return '$' + val.toFixed(0);
                    }
                }
            },
            {
                opposite: true,
                title: {
                    text: 'Total Bookings'
                }
            }
        ],
        tooltip: {
            shared: true,
            intersect: false
        },
        grid: {
            borderColor: '#e2e8f0' // Slate 200
        }
    };

    // Initialize and render the chart
    const chart = new ApexCharts(chartElement, chartOptions);
    chart.render();
});
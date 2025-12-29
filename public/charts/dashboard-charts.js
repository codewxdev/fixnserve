document.addEventListener('DOMContentLoaded', function () {

    // Helper function to create and render an ApexChart
    function renderChart(elementId, options) {
        const element = document.getElementById(elementId);
        if (element) {
            const chart = new ApexCharts(element, options);
            chart.render();
        }
    }

    // --- NEW CHARTS (ADDED AT THE TOP) ---

    // NEW Chart 1: Orders by Module
    const ordersByModuleOptions = {
        series: [{
            name: 'Orders',
            data: [18420, 7380, 5240, 22160, 24890]
        }],
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: false,
                columnWidth: '45%',
                distributed: true // Adds color variety per bar
            }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: ['Home & Maint.', 'Professionals', 'Consultants', 'Mart', 'Captains (Deliveries)'],
            labels: { style: { fontSize: '12px' } }
        },
        yaxis: {
            title: { text: 'Number of Orders' }
        },
        colors: ['#3b82f6', '#06b6d4', '#f59e0b', '#f97316', '#ef4444'], // Custom colors for modules
        legend: { show: false }
    };
    renderChart('orders-by-module-chart', ordersByModuleOptions);


    // NEW Chart 2: GMV Growth Trend
    const gmvGrowthTrendOptions = {
        series: [{
            name: 'GMV ($)',
            data: [3200000, 3500000, 3900000, 4200000, 4500000, 4850000] // Trending up to $4.85M
        }],
        chart: {
            type: 'area', // Area chart looks better for trends
            height: 350,
            toolbar: { show: false },
            zoom: { enabled: false }
        },
        dataLabels: { enabled: false },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        xaxis: {
            categories: ['Month 1', 'Month 2', 'Month 3', 'Month 4', 'Month 5', 'Current'],
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return "$" + (value / 1000000).toFixed(2) + "M";
                }
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 90, 100]
            }
        },
        colors: ['#10b981'], // Emerald green for money/growth
        tooltip: {
            y: {
                formatter: function (val) {
                    return "$" + val.toLocaleString();
                }
            }
        }
    };
    renderChart('gmv-growth-trend-chart', gmvGrowthTrendOptions);


    // --- EXISTING CHARTS ---

    // 1. Monthly Revenue Bar Chart
    const monthlyRevenueBarChartOptions = {
        series: [{
            name: 'Monthly Revenue (USD)',
            data: [3000, 4500, 5000, 4800, 5500, 6200, 7000, 6800, 7500, 8000, 7800, 8500]
        }],
        chart: { type: 'bar', height: 350, toolbar: { show: false } },
        plotOptions: { bar: { horizontal: false, columnWidth: '35%', endingShape: 'rounded' } },
        dataLabels: { enabled: false },
        stroke: { show: true, width: 2, colors: ['transparent'] },
        xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], title: { text: 'Month' } },
        yaxis: { title: { text: 'Revenue (USD)' }, labels: { formatter: (val) => '$' + val.toFixed(0) } },
        fill: { opacity: 1 },
        tooltip: { y: { formatter: (val) => '$' + val.toFixed(2) } },
        colors: ['#3b82f6']
    };
    renderChart('monthly-revenue-bar-chart', monthlyRevenueBarChartOptions);

    // 11. Provider Category Coverage
    const providerCategoryCoverageOptions = {
        series: [{ name: 'Active Providers', data: [120, 85, 50, 30] }, { name: 'Total Requests', data: [780, 520, 390, 310] }],
        chart: { type: 'bar', height: 350, toolbar: { show: false } },
        plotOptions: { bar: { horizontal: false, columnWidth: '55%', endingShape: 'rounded' } },
        dataLabels: { enabled: false },
        stroke: { show: true, width: 2, colors: ['transparent'] },
        xaxis: { categories: ['AC Repair', 'Plumbing', 'Cleaning', 'Electrical'] },
        yaxis: [{ title: { text: 'Active Providers' } }, { opposite: true, title: { text: 'Total Requests' } }],
        legend: { position: 'top' },
        colors: ['#3b82f6', '#f59e0b']
    };
    renderChart('provider-category-coverage-chart', providerCategoryCoverageOptions);

    // 2. Yearly Revenue
    const yearlyRevenueOverviewOptions = {
        series: [{ name: 'Revenue (USD)', type: 'area', data: [3000, 4500, 5000, 4800, 5500, 6200, 7000, 6800, 7500, 8000, 7800, 8500] }, { name: 'Target Revenue (USD)', type: 'line', data: [3500, 4000, 5500, 5200, 6000, 6500, 7500, 7200, 8000, 8500, 8200, 9000] }],
        chart: { height: 350, type: 'line', toolbar: { show: false } },
        colors: ['#3b82f6', '#f59e0b'],
        stroke: { curve: 'smooth', width: [4, 2] },
        fill: { opacity: [0.35, 1], type: 'solid' },
        dataLabels: { enabled: false },
        xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], title: { text: 'Month' } },
        yaxis: { title: { text: 'Revenue (USD)' }, labels: { formatter: (val) => '$' + val.toFixed(0) } },
        tooltip: { y: { formatter: (val) => '$' + val.toFixed(2) } }
    };
    renderChart('yearly-revenue-overview-chart', yearlyRevenueOverviewOptions);

    // 3. Revenue Category Pie
    const revenuePerCategoryOptions = {
        series: [44, 55, 13, 43, 22],
        chart: { type: 'donut', height: 350 },
        labels: ['AC Repair', 'Plumbing', 'Cleaning', 'Electrical', 'Other Services'],
        responsive: [{ breakpoint: 480, options: { chart: { width: 200 }, legend: { position: 'bottom' } } }],
        colors: ['#10b981', '#3b82f6', '#f97316', '#ef4444', '#a855f7'],
        legend: { position: 'bottom' },
        plotOptions: { pie: { donut: { labels: { show: true, total: { showAlways: true, show: true, label: 'Total %', formatter: function (w) { return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toFixed(0) + '%' } } } } } }
    };
    renderChart('revenue-per-category-chart', revenuePerCategoryOptions);

    // 7. Rider Perf (Full Width)
    const riderDeliveryPerformanceOptions = {
        series: [{ name: 'Avg. Delivery Time (mins)', data: [25, 22, 28, 24, 21, 19, 20, 23, 26, 25, 22, 21] }],
        chart: { height: 350, type: 'line', toolbar: { show: false } },
        colors: ['#6366f1'],
        dataLabels: { enabled: false },
        stroke: { curve: 'straight' },
        xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], title: { text: 'Month' } },
        yaxis: { title: { text: 'Avg. Time (minutes)' } },
        markers: { size: 5, hover: { sizeOffset: 6 } }
    };
    renderChart('rider-delivery-performance-chart', riderDeliveryPerformanceOptions);

    // 8. Successful/Failed
    const successfulFailedDeliveriesOptions = {
        series: [{ name: 'Successful', data: [400, 550, 680, 650, 800, 900, 1000, 950, 1100, 1200, 1150, 1250] }, { name: 'Failed', data: [50, 50, 40, 50, 50, 50, 50, 50, 50, 50, 50, 50] }],
        chart: { type: 'bar', height: 350, stacked: true, toolbar: { show: false } },
        plotOptions: { bar: { horizontal: false } },
        xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], title: { text: 'Month' } },
        yaxis: { title: { text: 'Number of Deliveries' } },
        fill: { opacity: 1 },
        legend: { position: 'top' },
        colors: ['#10b981', '#ef4444'],
        tooltip: { y: { formatter: (val) => val.toFixed(0) + ' deliveries' } }
    };
    renderChart('successful-failed-deliveries-chart', successfulFailedDeliveriesOptions);

    // Heatmap
    const riderActivityHeatmap = {
        series: [42, 47, 52, 58, 65],
        chart: { type: 'polarArea', height: 350 },
        labels: ['Rose A', 'Rose B', 'Rose C', 'Rose D', 'Rose E'],
        responsive: [{ breakpoint: 480, options: { chart: { width: 200 }, legend: { position: 'bottom' } } }],
        legend: { position: 'bottom' },
        plotOptions: { pie: { donut: { labels: { show: true, total: { showAlways: true, show: true, label: 'Total %', formatter: function (w) { return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toFixed(0) + '%' } } } } } },
    };
    renderChart('rider-activity-heatmap', riderActivityHeatmap);

    // 4. Service Volume (Full Width)
    const monthlyServiceVolumeOptions = {
        series: [{ name: 'Total Orders', data: [450, 600, 720, 700, 850, 950, 1050, 1000, 1150, 1250, 1200, 1300] }],
        chart: { height: 350, type: 'line', toolbar: { show: false } },
        colors: ['#f97316'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], title: { text: 'Month' } },
        yaxis: { title: { text: 'Number of Orders' } }
    };
    renderChart('monthly-service-volume-chart', monthlyServiceVolumeOptions);

    // 5. Category Perf
    const categoryPerformanceComparisonOptions = {
        series: [{ data: [780, 520, 390, 310, 240, 180] }],
        chart: { type: 'bar', height: 350, toolbar: { show: false } },
        plotOptions: { bar: { horizontal: true, distributed: true } },
        dataLabels: { enabled: true },
        xaxis: { categories: ['AC Repair', 'Plumbing', 'Cleaning', 'Electrical', 'Pest Control', 'Gardening'], title: { text: 'Total Orders' } },
        colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#a855f7', '#6366f1'],
    };
    renderChart('category-performance-comparison-chart', categoryPerformanceComparisonOptions);

    // 6. Orders Status
    const ordersStatusChartOptions = {
        series: [4281, 15, 230],
        chart: { width: 400, type: 'pie' },
        labels: ['Completed', 'Live', 'Pending'],
        responsive: [{ breakpoint: 480, options: { chart: { width: 200 }, legend: { position: 'bottom' } } }],
        colors: ['#10b981', '#f59e0b', '#3b82f6'],
        legend: { position: 'bottom' },
        tooltip: { y: { formatter: (val) => val.toFixed(0) + ' orders' } }
    };
    renderChart('orders-status-chart', ordersStatusChartOptions);

    // 9. Funnel
    const providerConversionFunnelOptions = {
        series: [{ name: 'Providers', data: [500, 350, 200, 120] }],
        chart: { type: 'bar', height: 350, toolbar: { show: false } },
        plotOptions: { bar: { horizontal: true, barHeight: '80%', endingShape: 'rounded' } },
        dataLabels: { enabled: true, formatter: (val, opt) => val.toFixed(0), offsetX: 40 },
        xaxis: { categories: ['Signup', 'KYC Submitted', 'KYC Approved', 'Active on Platform'], labels: { show: false } },
        yaxis: { labels: { style: { fontSize: '12px', fontWeight: 600 } } },
        grid: { show: false },
        colors: ['#a855f7'],
        tooltip: { y: { formatter: (val) => val.toFixed(0) + ' providers' } }
    };
    renderChart('provider-conversion-funnel-chart', providerConversionFunnelOptions);

    // 10. Top Providers
    const topProvidersChartOptions = {
        series: [{ data: [9.5, 9.2, 8.8, 8.5, 8.1] }],
        chart: { type: 'bar', height: 350, toolbar: { show: false } },
        plotOptions: { bar: { horizontal: true, dataLabels: { position: 'top' } } },
        dataLabels: { enabled: true, formatter: (val) => val.toFixed(1), style: { colors: ['#fff'] }, offsetX: -10 },
        xaxis: { categories: ['ProFix Plumbing', 'QuickSpark Electric', 'AC Master', 'Home Clean', 'Pest Away'], title: { text: 'Average Rating (out of 10)' } },
        colors: ['#10b981'],
    };
    renderChart('top-providers-chart', topProvidersChartOptions);

});
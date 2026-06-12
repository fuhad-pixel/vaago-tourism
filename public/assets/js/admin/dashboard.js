document.addEventListener("DOMContentLoaded", function() {
    // Sidebar Toggle Logic
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            document.body.classList.toggle('sidebar-collapsed');
        });
    }

    // Close mobile sidebar on outside click (backdrop)
    const sidebarWrapper = document.querySelector('.admin-sidebar-wrapper');
    if (sidebarWrapper) {
        sidebarWrapper.addEventListener('click', function(e) {
            // Check if it's mobile view (wrapper width is 100%) and target is the wrapper itself
            if (e.target === sidebarWrapper && window.innerWidth <= 992 && document.body.classList.contains('sidebar-collapsed')) {
                document.body.classList.remove('sidebar-collapsed');
            }
        });
    }

    // Sidebar Submenu Logic
    const submenuToggles = document.querySelectorAll('.submenu-toggle');
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            parent.classList.toggle('open');
            const submenu = parent.querySelector('.submenu');
            const icon = this.querySelector('.submenu-icon');
            if (parent.classList.contains('open')) {
                $(submenu).slideDown(300); // Use jQuery for smooth slide since it is available globally now
                if(icon) icon.style.transform = 'rotate(180deg)';
            } else {
                $(submenu).slideUp(300);
                if(icon) icon.style.transform = 'rotate(0deg)';
            }
        });
    });

    // Common Sparkline Options
    var sparklineOptions = {
        chart: {
            type: 'area',
            height: 40,
            sparkline: { enabled: true }
        },
        stroke: { curve: 'smooth', width: 2 },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0,
                stops: [0, 100]
            }
        },
        tooltip: {
            fixed: { enabled: false },
            x: { show: false },
            y: { title: { formatter: function (seriesName) { return '' } } },
            marker: { show: false }
        }
    };

    // KPI 1 - Orange
    const spark1El = document.querySelector("#spark1");
    if (spark1El) {
        var spark1 = new ApexCharts(spark1El, {
            ...sparklineOptions,
            colors: ['#F15A29'],
            series: [{ data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54] }]
        });
        spark1.render();
    }

    // KPI 2 - Teal
    var spark2 = new ApexCharts(document.querySelector("#spark2"), {
        ...sparklineOptions,
        colors: ['#00B8A9'],
        series: [{ data: [12, 14, 2, 47, 42, 15, 47, 75, 65, 19, 14] }]
    });
    spark2.render();

    // KPI 3 - Blue
    var spark3 = new ApexCharts(document.querySelector("#spark3"), {
        ...sparklineOptions,
        colors: ['#2D8CFF'],
        series: [{ data: [47, 45, 74, 14, 56, 74, 14, 11, 7, 39, 82] }]
    });
    spark3.render();

    // KPI 4 - Purple
    var spark4 = new ApexCharts(document.querySelector("#spark4"), {
        ...sparklineOptions,
        colors: ['#A855F7'],
        series: [{ data: [15, 75, 47, 65, 14, 2, 41, 54, 4, 27, 15] }]
    });
    spark4.render();


    // Main Revenue Chart
    const revenueEl = document.querySelector("#revenueChart");
    if (revenueEl) {
        var revenueOptions = {
            series: [{
                name: 'Revenue',
                data: [31000, 40000, 28000, 51000, 42000, 109000, 100000]
            }],
            chart: {
                height: 300,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            },
            colors: ['#F15A29'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.5,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return "$" + (value / 1000) + "k";
                    }
                }
            },
            grid: {
                borderColor: '#F3F4F6',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } }
            }
        };
        var revenueChart = new ApexCharts(revenueEl, revenueOptions);
        revenueChart.render();
    }


    // Travel Categories Donut
    const categoryEl = document.querySelector("#categoryChart");
    if (categoryEl) {
        var categoryOptions = {
            series: [44, 55, 41, 17, 15],
            labels: ['Luxury', 'Adventure', 'Family', 'Honeymoon', 'Business'],
            chart: {
                type: 'donut',
                height: 300,
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            },
            colors: ['#F15A29', '#00B8A9', '#2D8CFF', '#A855F7', '#F59E0B'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            name: { show: true },
                            value: { show: true },
                            total: {
                                show: true,
                                showAlways: true,
                                label: 'Total',
                                color: '#111827'
                            }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            stroke: { width: 0 },
            legend: {
                position: 'bottom'
            }
        };
        var categoryChart = new ApexCharts(categoryEl, categoryOptions);
        categoryChart.render();
    }
});

/* ==========================================================================
   CUSTOM CONFIRM MODAL LOGIC
   ========================================================================== */
let confirmModalCallback = null;

window.showConfirmModal = function(title, message, callback) {
    const overlay = document.getElementById('customConfirmOverlay');
    const titleEl = document.getElementById('customConfirmTitle');
    const messageEl = document.getElementById('customConfirmMessage');
    
    if (!overlay) return;
    
    titleEl.textContent = title || 'Confirm Action';
    messageEl.textContent = message || 'Are you sure you want to proceed?';
    confirmModalCallback = callback;
    
    overlay.classList.add('show');
}

window.hideConfirmModal = function() {
    const overlay = document.getElementById('customConfirmOverlay');
    if (overlay) {
        overlay.classList.remove('show');
    }
    confirmModalCallback = null;
}

document.addEventListener('DOMContentLoaded', function() {
    const cancelBtn = document.getElementById('customConfirmCancelBtn');
    const proceedBtn = document.getElementById('customConfirmProceedBtn');
    const overlay = document.getElementById('customConfirmOverlay');
    
    if (cancelBtn) {
        cancelBtn.addEventListener('click', hideConfirmModal);
    }
    
    if (proceedBtn) {
        proceedBtn.addEventListener('click', function() {
            if (typeof confirmModalCallback === 'function') {
                confirmModalCallback();
            }
            hideConfirmModal();
        });
    }
    
    if (overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                hideConfirmModal();
            }
        });
    }

    // Global listener for forms with 'delete-confirm-form' class
    $(document).on('submit', '.delete-confirm-form', function(e) {
        e.preventDefault();
        const form = this;
        const message = $(this).data('message') || 'Are you sure you want to delete this item?';
        const title = $(this).data('title') || 'Confirm Deletion';
        
        showConfirmModal(title, message, function() {
            form.submit();
        });
    });
});

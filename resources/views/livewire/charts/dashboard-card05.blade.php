<div class="flex flex-col col-span-full sm:col-span-6 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Registro de accidentes por género</h2>
    </header>
    <div id="dashboard-bars-chart-legend" class="px-5 py-3">
        <ul class="flex flex-wrap"></ul>
    </div>
    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="overflow-x: auto; padding-right: 15px; padding-left: 15px;">
            <canvas id="chart-bars" width="595" height="248"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const darkMode = localStorage.getItem('dark-mode') === 'true';

        const textColor = {
            light: '#94a3b8',
            dark: '#64748B'
        };

        const gridColor = {
            light: '#f1f5f9',
            dark: '#334155'
        };

        const tooltipBodyColor = {
            light: '#1e293b',
            dark: '#f1f5f9'
        };

        const tooltipBgColor = {
            light: '#ffffff',
            dark: '#334155'
        };

        const tooltipBorderColor = {
            light: '#e2e8f0',
            dark: '#475569'
        };

        var ctx = document.getElementById("chart-bars").getContext("2d");
        const labels = {!! $labels !!};
        const counts = {!! $counts !!};

        // Definir un tamaño máximo para las barras
        const maxBarThickness = 6;

        // Generar colores aleatorios
        const randomColors = Array.from({
            length: counts.length
        }, () => getRandomColor());

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    label: "Registro de accidentes por género",
                    tension: 0.9,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: randomColors,
                    data: counts,
                    maxBarThickness: maxBarThickness
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: darkMode ? textColor.dark : textColor.light,
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 500,
                            beginAtZero: true,
                            padding: 10,
                            font: {
                                size: 10, // Tamaño de la fuente reducido
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: darkMode ? textColor.dark : textColor.light,
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: darkMode ? textColor.dark : textColor.light,
                        },
                        ticks: {
                            display: true,
                            color: darkMode ? textColor.dark : textColor.light,
                            padding: 10,
                            font: {
                                size: 10, // Tamaño de la fuente reducido
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        // Función para generar un color aleatorio
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    });
</script>

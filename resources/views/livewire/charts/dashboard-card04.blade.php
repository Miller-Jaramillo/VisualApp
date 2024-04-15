<div class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Cantidad de accidentes por Clase y Genero</h2>
    </header>
    <div id="dashboard-card-04-legend" class="px-5 py-3">
        <ul class="flex flex-wrap"></ul>
    </div>
    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="overflow-x: auto; padding-right: 15px; padding-left: 15px;">
            <canvas id="chart-line" width="800" height="300"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('livewire:load', function() {
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

        var ctx2 = document.getElementById('chart-line').getContext('2d');
        var data = @json($data);

        var accidentTypes = [...new Set(data.map(item => item.clase_accidente))];

        var datasets = data.reduce(function(acc, item) {
            var existing = acc.find(dataset => dataset.label === item.genero);
            if (existing) {
                existing.data.push(item.total);
            } else {
                acc.push({
                    label: item.genero,
                    data: [item.total],
                    backgroundColor: getRandomColor(),
                });
            }
            return acc;
        }, []);

        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: accidentTypes,
                datasets: datasets,
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                        ticks: {
                            color: darkMode ? textColor.dark : textColor.light,
                            font: {
                                size: 10,
                            },
                        },
                    },
                    y: {
                        stacked: true,
                        ticks: {
                            color: darkMode ? textColor.dark : textColor.light,
                            font: {
                                size: 10,
                            },
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                    },


                },

                hoverOffset: 8,
            },
        });
    });




    function getRandomColor() {
        var r = Math.floor(Math.random() * 256);
        var g = Math.floor(Math.random() * 256);
        var b = Math.floor(Math.random() * 256);
        var a = 0.6;
        return `rgba(${r}, ${g}, ${b}, ${a})`;
    }


</script>

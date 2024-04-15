<div class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Gráfico de Burbujas</h2>
    </header>





    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="max-width: 100%; overflow: hidden; margin: auto;">
            <canvas id="chart-bubbles" width="800" height="400"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('livewire:load', function() {
        const ctx = document.getElementById('chart-bubbles').getContext('2d');
        let chart;

        Livewire.on('updateGraficoBusrbujas', ({ data }) => {
            updateGraficoBurbujas(data);
        });

        function updateGraficoBurbujas(data) {
            const groupedData = groupBy(data, 'lesion');

            const bubbleChartConfig = {
                type: 'bubble',
                data: {
                    datasets: Object.keys(groupedData).map((lesion, index) => ({
                        label: lesion,
                        data: groupedData[lesion].map(item => ({
                            x: item.edad,
                            y: index + 1,
                            r: item.total * 5,
                        })),
                        backgroundColor: getRandomColor(),
                        borderColor: 'rgba(255,255,255,0.7)',
                    })),
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Edad',
                            },
                            min: 0,
                            max: 100,
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Tipo de Lesión',
                            },
                            ticks: {
                                stepSize: 1,
                                callback: (value, index) => Object.keys(groupedData)[index],
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                        },
                    },
                },
            };

            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, bubbleChartConfig);
        }

        function getRandomColor() {
            return `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.7)`;
        }

        function groupBy(arr, key) {
            return arr.reduce((acc, obj) => {
                const property = obj[key];
                acc[property] = acc[property] || [];
                acc[property].push(obj);
                return acc;
            }, {});
        }
    });
</script>

<div
    class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Gráfico de Burbujas - Año {{ $year }}</h2>
    </header>


    <!-- Botón de ojo para ocultar/mostrar información -->
    <button id="btnMostrarInformacionBurbujas"
        class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
        <i class="far fa-eye"></i> Mostrar Información
    </button>

    <!-- Información importante inicialmente oculta -->
    <div id="informacionImportateBurbujas" class="px-5 py-4 text-xs" style="display: none;">
        <p>Análisis de la gráfica de burbujas:</p>

        <li> <strong>Resultados obtenidos en el año {{ $year }}.</strong></li>

        <li><strong>Tipo de lesión con más accidentes:</strong> {{ $lesionMasAccidentes }} - {{ $data->where('lesion', $lesionMasAccidentes)->sum('total') }} accidentes</li>
        <li><strong>Tipo de lesión con menos accidentes:</strong> {{ $lesionMenosAccidentes }} - {{ $data->where('lesion', $lesionMenosAccidentes)->sum('total') }} accidentes</li>

        <li><strong>Edad promedio por tipo de lesión:</strong></li>
        @foreach ($edadPromedioPorLesion as $lesion => $edadPromedio)
            <li>{{ $lesion }}: {{ intval($edadPromedio) }}</li>
        @endforeach

        <li><strong>Tipo de lesión con menor edad promedio:</strong> {{ $lesionMenorEdad }}</li>
        <li><strong>Tipo de lesión con mayor edad promedio:</strong> {{ $lesionMayorEdad }}</li>


        <li> <strong>Total de accidentes:</strong> {{ $data->sum('total') }}</li>
    </div>








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

        Livewire.on('updateGraficoBusrbujas', ({
            data
        }) => {
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


    // Agregar evento clic al botón de ojo
    const btnMostrarInformacionBurbujas = document.getElementById('btnMostrarInformacionBurbujas');
    const informacionImportateBurbujas = document.getElementById('informacionImportateBurbujas');

    btnMostrarInformacionBurbujas.addEventListener('click', function() {
        // Alternar la visibilidad de la información importante
        const isInfoVisible = informacionImportateBurbujas.style.display !== 'none';
        informacionImportateBurbujas.style.display = isInfoVisible ? 'none' : 'block';

        // Actualizar el texto del botón
        btnMostrarInformacionBurbujas.innerHTML = isInfoVisible ?
            '<i class="far fa-eye"></i> Mostrar Información' :
            '<i class="far fa-eye-slash"></i> Ocultar Información';
    });

    // Agregar evento clic al documento para ocultar la información al hacer clic en otro lugar
    document.addEventListener('click', function(event) {
        if (event.target !== btnMostrarInformacionBurbujas && event.target.closest(
                '#informacionImportateBurbujas') === null) {
            informacionImportateBurbujas.style.display = 'none';
            // Restaurar el texto del botón
            btnMostrarInformacionBurbujas.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
        }
    });
</script>

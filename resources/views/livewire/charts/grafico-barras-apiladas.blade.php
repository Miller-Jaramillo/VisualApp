<div
    class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Distribución de Accidentes por Tipo de Víctima y Clase de Accidente  -  Año {{ $year }}.</h2>
        <p class="text-slate-600 text-justify text-xs dark:text-slate-400 mt-2">
            Este gráfico de barras apiladas muestra la distribución de accidentes según el tipo de víctima y la clase de accidente ocurridos en el año {{ $year }}. Cada barra representa una clase de accidente, dividida en segmentos que representan los diferentes tipos de víctimas involucradas.
            Los segmentos de cada barra muestran la cantidad de accidentes ocurridos para cada combinación de tipo de víctima y clase de accidente. Utiliza los controles de selección para ver la distribución de accidentes en diferentes años.
        </p>
    </header>







   <!-- Botón de ojo para ocultar/mostrar información -->
   <button id="toggleInfoButtonBarrasApiladas"
   class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
   <i class="far fa-eye"></i> Mostrar Información
</button>

    <!-- Información importante inicialmente oculta -->

    <div id="informacionImportanteBarrasApiladas" class="px-5 py-4 text-xs" style="display: none;">
        <p>Análisis de la gráfica de distribución de Accidentes por Tipo de Víctima y Clase de Accidente :</p>
        <div>
            <li> <strong>Resultados obtenidos en el año {{ $year }}.</strong></li>
            <li> <strong>Tipo de víctima con más accidentes:</strong> {{ $this->tipoVictimaConMasAccidentes() }}</li>
            <li> <strong>Tipo de víctima con menos accidentes:</strong> {{ $this->tipoVictimaConMenosAccidentes() }}</li>
            <li> <strong>Clase de accidente con más accidentes:</strong> {{ $this->claseAccidenteConMasAccidentes() }}</li>
            <li> <strong>Clase de accidente con menos accidentes:</strong> {{ $this->claseAccidenteConMenosAccidentes() }}</li>
            <li> <strong>Total de accidentes:</strong> {{ $data->sum('total') }}</li>
        </div>
    </div>






    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="max-width: 100%; overflow: hidden; margin: auto;">
            <canvas id="chart-stacked-bars" width="800" height="300"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('livewire:load', function() {
        const ctx = document.getElementById('chart-stacked-bars').getContext('2d');
        let chart;

        Livewire.on('updateChartBarrasApiladas', ({
            data
        }) => {
            updateChart(data);
        });

        function updateChart(data) {
            if (chart) {
                chart.destroy();
            }

            const groupedData = groupBy(data, 'tipo_victima');

            const stackedBarChartConfig = {
                type: 'bar',
                data: {
                    labels: [...new Set(data.map(item => item.clase_accidente))],
                    datasets: Object.keys(groupedData).map((tipoVictima, index) => ({
                        label: tipoVictima,
                        data: data.filter(item => item.tipo_victima === tipoVictima).map(item =>
                            item.total),
                        backgroundColor: getRandomColor(),
                    })),
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,
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
            };

            chart = new Chart(ctx, stackedBarChartConfig);
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



        // Agregar evento clic al botón de ojo
        const toggleInfoButtonBarrasApiladas = document.getElementById('toggleInfoButtonBarrasApiladas');
        const informacionImportanteBarrasApiladas = document.getElementById('informacionImportanteBarrasApiladas');

        toggleInfoButtonBarrasApiladas.addEventListener('click', function() {
            // Alternar la visibilidad de la información importante
            const isInfoVisible = informacionImportanteBarrasApiladas.style.display !== 'none';
            informacionImportanteBarrasApiladas.style.display = isInfoVisible ? 'none' : 'block';

            // Actualizar el texto del botón
            toggleInfoButtonBarrasApiladas.innerHTML = isInfoVisible ?
                '<i class="far fa-eye"></i> Mostrar Información' :
                '<i class="far fa-eye-slash"></i> Ocultar Información';
        });

        // Agregar evento clic al documento para ocultar la información al hacer clic en otro lugar
        document.addEventListener('click', function(event) {
            if (event.target !== toggleInfoButtonBarrasApiladas && event.target.closest('#informacionImportanteBarrasApiladas') === null) {
                informacionImportanteBarrasApiladas.style.display = 'none';
                // Restaurar el texto del botón
                toggleInfoButtonBarrasApiladas.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
            }
        });



        Livewire.emit('updateChartBarrasApiladas', {
            data: @json($data)
        });
    });
</script>

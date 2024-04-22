<div
    class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Distribución de accidentes por día según género -
            Año {{ $year }}</h2>

            <p class="text-slate-600 text-xs dark:text-slate-400 text-justify mt-2">
            Este gráfico de barras muestra la distribución de accidentes registrados durante el año Año {{ $year }}, clasificados por día de la semana y género de las víctimas.
            Cada barra representa un día de la semana, y la altura de la barra indica la cantidad de accidentes registrados para ese día. Se resalta el día con la mayor y menor cantidad de accidentes, así como el género más y menos accidentado. Esta visualización proporciona una visión detallada de cómo se distribuyen los accidentes según el día de la semana y el género de las víctimas en el año seleccionado.
            </p>

    </header>






    <!-- Botón de ojo para ocultar/mostrar información -->
    <button id="btnMostrarInformacionAccidentesDia"
        class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
        <i class="far fa-eye"></i> Mostrar Información
    </button>

    <!-- Información importante inicialmente oculta -->
    <div id="informacionImportanteAccidentesDia" class="px-5 py-4 text-xs" style="display: none;">
        <p>Análisis de la gráfica de distribución de accidentes por día según género:</p>
        <li> <strong>Resultados obtenidos en el año {{ $year }}.</strong></li>

        <li> <strong>Días que representa la gráfica con su total de accidentes:</strong>
            @foreach($dias as $dia)
                {{ $dia }}: {{ $totalAccidentesPorDia[$dia] }} accidentes |
            @endforeach
        </li>




        <li> <strong>Días con más accidentes en la semana:</strong>
            @foreach($diaMasAccidentado as $diaMas)
                {{ $diaMas }}
            @endforeach
        </li>
        <li> <strong>Días con menos accidentes en la semana:</strong>
            @foreach($diaMenosAccidentado as $diaMenos)
                {{ $diaMenos }}
            @endforeach
        </li>




        <li> <strong>Género más accidentado de la semana:</strong> {{ $generoMasAccidentado }} con {{ $totalAccidentesGeneroMasAccidentado }} accidentes</li>
        <li> <strong>Género menos accidentado de la semana:</strong> {{ $generoMenosAccidentado }} con {{ $totalAccidentesGeneroMenosAccidentado }} accidentes</li>




        <li> <strong>Total de accidentes:</strong> {{ $data->sum('total') }}</li>
    </div>



    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="overflow-x: auto; padding-right: 15px; padding-left: 15px;">
            <canvas id="chart-barras-accidente-dia" width="800" height="300"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('livewire:load', function() {
        const ctx = document.getElementById('chart-barras-accidente-dia').getContext('2d');
        let chart;

        Livewire.on('updateBarrasAccidentesDia', ({
            data
        }) => {
            updateBarrasAccidentesDia(data);
        });

        function updateBarrasAccidentesDia(data) {
            const dia = [...new Set(data.map(item => item.dia))];
            const generos = [...new Set(data.map(item => item.genero))];

            const datasets = generos.map(genero => {
                const counts = dia.map(clase =>
                    data.find(item => item.dia === clase && item.genero === genero)
                    ?.total ?? 0
                );

                return {
                    label: genero,
                    data: counts,
                    backgroundColor: getRandomColor(),
                };
            });

            const config = {
                type: 'bar',
                data: {
                    labels: dia,
                    datasets: datasets,
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
                },
            };

            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, config);
        }

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        Livewire.hook('afterDomUpdate', () => {
            updateBarrasAccidentesDia(@this.data);
        });






    });


    // Agregar evento clic al botón de ojo
    const btnMostrarInformacionAccidentesDia = document.getElementById('btnMostrarInformacionAccidentesDia');
            const informacionImportanteAccidentesDia = document.getElementById('informacionImportanteAccidentesDia');

            btnMostrarInformacionAccidentesDia.addEventListener('click', function() {
                // Alternar la visibilidad de la información importante
                const isInfoVisible = informacionImportanteAccidentesDia.style.display !== 'none';
                informacionImportanteAccidentesDia.style.display = isInfoVisible ? 'none' : 'block';

                // Actualizar el texto del botón
                btnMostrarInformacionAccidentesDia.innerHTML = isInfoVisible ?
                    '<i class="far fa-eye"></i> Mostrar Información' :
                    '<i class="far fa-eye-slash"></i> Ocultar Información';
            });

            // Agregar evento clic al documento para ocultar la información al hacer clic en otro lugar
            document.addEventListener('click', function(event) {
                if (event.target !== btnMostrarInformacionAccidentesDia && event.target.closest('#informacionImportanteAccidentesDia') === null) {
                    informacionImportanteAccidentesDia.style.display = 'none';
                    // Restaurar el texto del botón
                    btnMostrarInformacionAccidentesDia.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
                }
            });
</script>

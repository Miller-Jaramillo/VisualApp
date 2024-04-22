<div
    class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Distribución de Accidentes por Clase y Género -
            Año {{ $year }}</h2>

            <p class="text-slate-600 text-justify text-xs dark:text-slate-400 mt-2">


                Este gráfico de barras apiladas muestra la distribución de accidentes según la clase de accidente y el género de las víctimas para el año seleccionado.
                Cada barra representa una clase de accidente, dividida en segmentos que representan la cantidad de accidentes para cada género. El gráfico proporciona una visualización clara y detallada de cómo se distribuyen los accidentes entre diferentes clases y géneros, lo que puede ayudar a identificar patrones y áreas de enfoque para la prevención de accidentes.


            </p>

    </header>





    <!-- Botón de ojo para ocultar/mostrar información -->
    <button id="btnMostrarInformacion"
        class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
        <i class="far fa-eye"></i> Mostrar Información
    </button>

    <!-- Información importante inicialmente oculta -->
    <div id="informacionImportanteClaseGenero" class="px-5 py-4 text-xs" style="display: none;">
        <p>Análisis de la gráfica de distribución de Accidentes por Clase y Género:</p>
        <li> <strong>Resultados obtenidos en el año {{ $year }}.</strong></li>

        <li> <strong>Total de accidentes:</strong> {{ $data->sum('total') }}</li>
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
        const ctx = document.getElementById('chart-line').getContext('2d');
        let chart;

        Livewire.on('updateClaseGenero', ({
            data
        }) => {
            updateClaseGenero(data);
        });

        function updateClaseGenero(data) {
            const clasesAccidente = [...new Set(data.map(item => item.clase_accidente))];
            const generos = [...new Set(data.map(item => item.genero))];

            const datasets = generos.map(genero => {
                const counts = clasesAccidente.map(clase =>
                    data.find(item => item.clase_accidente === clase && item.genero === genero)
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
                    labels: clasesAccidente,
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
            updateClaseGenero(@this.data);
        });






    });


    // Agregar evento clic al botón de ojo
    const btnMostrarInformacion = document.getElementById('btnMostrarInformacion');
            const informacionImportanteClaseGenero = document.getElementById('informacionImportanteClaseGenero');

            btnMostrarInformacion.addEventListener('click', function() {
                // Alternar la visibilidad de la información importante
                const isInfoVisible = informacionImportanteClaseGenero.style.display !== 'none';
                informacionImportanteClaseGenero.style.display = isInfoVisible ? 'none' : 'block';

                // Actualizar el texto del botón
                btnMostrarInformacion.innerHTML = isInfoVisible ?
                    '<i class="far fa-eye"></i> Mostrar Información' :
                    '<i class="far fa-eye-slash"></i> Ocultar Información';
            });

            // Agregar evento clic al documento para ocultar la información al hacer clic en otro lugar
            document.addEventListener('click', function(event) {
                if (event.target !== btnMostrarInformacion && event.target.closest('#informacionImportanteClaseGenero') === null) {
                    informacionImportanteClaseGenero.style.display = 'none';
                    // Restaurar el texto del botón
                    btnMostrarInformacion.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
                }
            });
</script>

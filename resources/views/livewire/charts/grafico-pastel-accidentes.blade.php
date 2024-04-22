<div
    class="flex flex-col col-span-full sm:col-span-6 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">

        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Distribución de Accidentes por Género  -Año:
            {{ $year }}</h2>
        <p class="text-slate-600 text-justify text-xs dark:text-slate-400 mt-2">Este gráfico de pastel muestra la distribución de accidentes registrados en el año {{ $year }} según el género de las víctimas.
            Las dos categorías representadas son "Mujeres" y "Hombres", con cada porción del pastel indicando el porcentaje de accidentes en los que estuvieron involucradas víctimas de ese género. Este gráfico proporciona una perspectiva visual clara de cómo se distribuyen los accidentes viales entre hombres y mujeres durante el año seleccionado.</p>

    </header>
    <!-- Agrega un elemento select para seleccionar el registro -->

    <!-- Botón de ojo para ocultar/mostrar información -->
    <button id="toggleInfoButtonPastel"
        class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
        <i class="far fa-eye"></i> Mostrar Información
    </button>

    <!-- Información importante inicialmente oculta -->
    <div id="informacionImportantePastel" class="px-5 py-4 text-xs" style="display: none;">
        <div>
            <p>Análisis de la gráfica de distribución de Accidentes por Género :</p>
            <li> <strong>Resultados obtenidos en el año {{ $year }}.</strong></li>

            <li>Cantidad de mujeres accidentadas: {{ $conteoMujeres }}</li>
            <li>Cantidad de hombres accidentados: {{ $conteoHombres }}</li>

        </div>
    </div>

    <div id="dashboard-pie-chart-legend" class="px-5 py-3">
        <ul class="flex flex-wrap"></ul>
    </div>
    <div class="grow">
        <div style="max-width: 100%; overflow: hidden; margin: auto;">
            <canvas id="chart-pie" width="500" height="0"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('livewire:load', function() {
        const ctx = document.getElementById("chart-pie").getContext("2d");
        let pieChart;

        // Agregar oyente de eventos Livewire para actualizar el gráfico
        Livewire.on('updateChart', ({
            labels,
            counts
        }) => {
            updateChart(labels, counts);
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

        // Función para actualizar el gráfico con los nuevos datos
        function updateChart(labels, counts) {
            const randomColors = Array.from({
                length: counts.length
            }, () => getRandomColor());

            if (!pieChart) {
                // Inicializar el gráfico si aún no existe
                pieChart = new Chart(ctx, {
                    type: "pie",
                    data: {
                        labels: labels,
                        datasets: [{
                            data: counts,
                            backgroundColor: randomColors,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                            }
                        },
                        hoverOffset: 8,
                    },
                });
            } else {
                // Actualizar solo los datos del gráfico sin recrearlo
                pieChart.data.labels = labels;
                pieChart.data.datasets[0].data = counts;
                pieChart.data.datasets[0].backgroundColor = randomColors;
                pieChart.update();
            }

            // Agregar leyendas al elemento legend
            const legend = document.getElementById('dashboard-pie-chart-legend');
            legend.innerHTML = ''; // Limpiar las leyendas antes de agregar las nuevas
            labels.forEach((label, index) => {
                const color = randomColors[index];
                const listItem = document.createElement('li');
                listItem.innerHTML =
                    `<span style="display:inline-block;width:15px;height:15px;background-color:${color};margin-right:5px;"></span>${label}: ${counts[index]} &nbsp;&nbsp;`;
                legend.querySelector('ul').appendChild(listItem);
            });
        }



        // Llamar a la función de inicialización
        updateChart(@json($labels), @json($counts));
    });


    // Agregar evento clic al botón para mostrar/ocultar información
    document.addEventListener('click', function(event) {
        const toggleInfoButtonPastel = document.getElementById('toggleInfoButtonPastel');
        const informacionImportantePastel = document.getElementById('informacionImportantePastel');

        if (event.target === toggleInfoButtonPastel) {
            const isInfoVisible = informacionImportantePastel.style.display !== 'none';
            informacionImportantePastel.style.display = isInfoVisible ? 'none' : 'block';
            toggleInfoButtonPastel.innerHTML = isInfoVisible ?
                '<i class="far fa-eye"></i> Mostrar Información' :
                '<i class="far fa-eye-slash"></i> Ocultar Información';
        } else if (event.target !== informacionImportantePastel && !informacionImportantePastel.contains(event
                .target)) {
            informacionImportantePastel.style.display = 'none';
            toggleInfoButtonPastel.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
        }
    });
</script>

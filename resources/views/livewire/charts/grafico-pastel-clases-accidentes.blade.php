<div class="flex flex-col col-span-full sm:col-span-6 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 ">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Distribución de Accidentes por Clase - Año: {{ $year }}</h2>
        <p class="text-slate-600 text-justify text-xs dark:text-slate-400 mt-2">
            Este gráfico de pastel muestra la distribución de accidentes registrados en el año {{ $year }} según la clase de accidente. Cada segmento del gráfico representa una clase de accidente, y el tamaño del segmento indica la proporción de accidentes en esa clase con respecto al total.
            La clase de accidente con el segmento más grande es la más común durante el año {{ $year }}, proporcionando una visualización clara de las clases de accidentes más frecuentes.

        </p>
    </header>

    <!-- Botón de ojo para ocultar/mostrar información -->
    <button id="toggleInfoButtonPastelClases" class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
        <i class="far fa-eye"></i> Mostrar Información
    </button>

    <!-- Información importante inicialmente oculta -->
    <div id="informacionImportantePastelClasesAnual" class="px-5 py-4 text-xs" style="display: none;">
        <!-- Información adicional -->
        <div>
            <strong>Resultados obtenidos en el año {{ $year }}.</strong>
            <li class="flex flex-col text-xs" id="additional-info-pie2"></li>
            <p  class="mt-2"> <b>  Análisis de la gráfica de distribución de Accidentes por Clase</b></p>
            <li><b>Clase con más accidentes:</b> {{ $labels[array_search(max($counts), $counts)] }} ({{ max($counts) }} accidentes)</li>
            <li><b>Clase con menos accidentes:</b> {{ $labels[array_search(min($counts), $counts)] }} ({{ min($counts) }} accidentes)</li>
            {{-- <li>La clase "{{ $labels[array_search(max($counts), $counts)] }}" tiene la mayor cantidad de accidentes, lo que indica que es la más común.</li>
            <li>La clase "{{ $labels[array_search(min($counts), $counts)] }}" tiene la menor cantidad de accidentes, lo que indica que es la menos común.</li> --}}
        </div>
        <li class="flex flex-col text-xs" id="additional-info-pie2">
    </div>

    <!-- Información adicional dinámica -->
    <div id="informacionImportantePastelClases" class="px-5 py-4 text-xs" style="display: none;">
        <!-- Información adicional -->
        <div>
            <p>Datos actuales del gráfico de pastel:</p>
            <ul class="flex flex-col text-xs" id="additional-info-pie2">
            </ul>
        </div>
    </div>
    <div class="grow mt-2">
        <div style="max-width: 100%; overflow: hidden; margin: auto;">
            <canvas id="chart-pie2" width="300" height="0"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('livewire:load', function() {
        window.livewire.on('updateChartDona', ({ labels, counts }) => {
            var ctx = document.getElementById("chart-pie2").getContext("2d");

            const randomColors = Array.from({ length: counts.length }, getRandomColor);

            if (window.pieChart) {
                window.pieChart.data.labels = labels;
                window.pieChart.data.datasets[0].data = counts;
                window.pieChart.data.datasets[0].backgroundColor = randomColors;
                window.pieChart.update();
            } else {
                window.pieChart = new Chart(ctx, {
                    type: "doughnut",
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
                            },
                        },
                        hoverOffset: 8,
                    },
                });
            }

            // Actualizar la información adicional dinámica
            const additionalInfo = document.getElementById('additional-info-pie2');
            additionalInfo.innerHTML = `
                ${labels.map((label, index) => `
                    <li><b>${label}:</b> ${counts[index]} accidentes</li>
                `).join('')}
            `;

        });

        // Función para generar un color aleatorio mejorada
        function getRandomColor() {
            return `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.7)`;
        }

        // Llamar a la función de inicialización con los datos del año 2024
        window.livewire.emit('yearSelected', '2024');
    });

    // Agregar evento clic al botón para mostrar/ocultar información
    document.addEventListener('click', function(event) {
        const toggleInfoButtonPastelClases = document.getElementById('toggleInfoButtonPastelClases');
        const informacionImportantePastelClasesAnual = document.getElementById('informacionImportantePastelClasesAnual');
        const informacionImportantePastelClases = document.getElementById('informacionImportantePastelClases');

        if (event.target === toggleInfoButtonPastelClases) {
            const isInfoVisible = informacionImportantePastelClasesAnual.style.display !== 'none';
            informacionImportantePastelClasesAnual.style.display = isInfoVisible ? 'none' : 'block';
            informacionImportantePastelClases.style.display = isInfoVisible ? 'block' : 'none';
            toggleInfoButtonPastelClases.innerHTML = isInfoVisible ?
                '<i class="far fa-eye"></i> Mostrar Información' :
                '<i class="far fa-eye-slash"></i> Ocultar Información';
        } else if (event.target !== informacionImportantePastelClasesAnual && !informacionImportantePastelClasesAnual.contains(event.target)) {
            informacionImportantePastelClasesAnual.style.display = 'none';
            informacionImportantePastelClases.style.display = 'block';
            toggleInfoButtonPastelClases.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
        }
    });
</script>

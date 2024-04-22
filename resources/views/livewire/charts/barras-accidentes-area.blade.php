<div class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Distribución de accidentes por área - Año
            {{ $year }}</h2>
        <p class="text-slate-600 text-justify text-xs dark:text-slate-400 mt-2">Este gráfico de barras muestra la distribución de accidentes por área en el año  {{ $year }}. Cada barra representa una área y su altura indica la cantidad de accidentes registrados en esa área durante el año seleccionado.
            Además, se destacan el área con la mayor cantidad de accidentes y el área con la menor cantidad de accidentes, brindando una visión general de la distribución de incidentes en diferentes áreas.</p>
    </header>


    <!-- Botón de ojo para ocultar/mostrar información -->
    <button id="btnInformacionAccidentesAreas"
        class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
        <i class="far fa-eye"></i> Mostrar Información
    </button>

    <!-- Información importante inicialmente oculta -->
    <div id="informacionImportanteAccidentesArea" class="px-5 py-4 text-xs" style="display: none;">
        <p>Análisis de la gráfica distribución de accidentes por área:</p>
        <li> <strong>Resultados obtenidos en el año {{ $year }}.</strong></li>
        <li>
            <strong>Areas con más accidentes:</strong>
            @foreach ($areaConMasAccidentes as $index => $area)
                {{ $area }} ({{ $conteoAreas[$area] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>

        <li>
            <strong>Areas con menos accidentes:</strong>
            @foreach ($areaConMenosAccidentes as $index => $area)
                {{ $area }} ({{ $conteoAreas[$area] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>
    </div>

    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="overflow-x: auto; padding-right: 15px; padding-left: 15px;">
            <canvas id="barrasAreas" width="800" height="300"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            const ctx = document.getElementById('barrasAreas').getContext('2d');
            let chart;

            // Agregar oyente de eventos Livewire para actualizar el gráfico
            Livewire.on('updateBarrasArea', ({
                data
            }) => {
                updateBarrasArea(data);
            });

            function updateBarrasArea(data) {
                const areas = data;

                const conteoAreas = {};
                areas.forEach(area => {
                    conteoAreas[area] = (conteoAreas[area] || 0) + 1;
                });

                const labels = Object.keys(conteoAreas).sort((a, b) => a - b);
                const counts = labels.map(area => conteoAreas[area]);

                const histogramaConfig = {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Cantidad de Accidentes',
                            data: counts,
                            backgroundColor:  getRandomColor(),
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Area'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Cantidad de Accidentes'
                                },
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.dataset.label || '';
                                        const valor = context.parsed.y;
                                        return label + ': ' + valor;
                                    }
                                }
                            }
                        }
                    }
                };

                if (chart) {
                    chart.destroy();
                }

                chart = new Chart(ctx, histogramaConfig);

                document.getElementById('areaConMasAccidentes').textContent = 'Area con más accidentes: ' +
                    getMaxArea(conteoAreas);
                document.getElementById('areaConMenosAccidentes').textContent = 'Area con menos accidentes: ' +
                    getMinArea(conteoAreas);
            }

            function getMaxArea(conteoAreas) {
                let maxAccidentes = 0;
                let areaMaxAccidentes = null;
                for (const area in conteoAreas) {
                    if (conteoAreas[area] > maxAccidentes) {
                        maxAccidentes = conteoAreas[area];
                        areaMaxAccidentes = area;
                    }
                }
                return areaMaxAccidentes;
            }

            function getMinArea(conteoAreas) {
                let minAccidentes = Infinity;
                let areaMinAccidentes = null;
                for (const area in conteoAreas) {
                    if (conteoAreas[area] < minAccidentes) {
                        minAccidentes = conteoAreas[area];
                        areaMinAccidentes = area;
                    }
                }
                return areaMinAccidentes;
            }

            updateBarrasArea(@json($areas));


            function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }


        });

        // Agregar evento clic al botón para mostrar/ocultar información
        document.addEventListener('click', function(event) {
            const btnInformacionAccidentesAreas = document.getElementById('btnInformacionAccidentesAreas');
            const informacionImportanteAccidentesArea = document.getElementById('informacionImportanteAccidentesArea');

            if (event.target === btnInformacionAccidentesAreas) {
                const isInfoVisible = informacionImportanteAccidentesArea.style.display !== 'none';
                informacionImportanteAccidentesArea.style.display = isInfoVisible ? 'none' : 'block';
                btnInformacionAccidentesAreas.innerHTML = isInfoVisible ?
                    '<i class="far fa-eye"></i> Mostrar Información' :
                    '<i class="far fa-eye-slash"></i> Ocultar Información';
            } else if (event.target !== informacionImportanteAccidentesArea && !informacionImportanteAccidentesArea.contains(event.target)) {
                informacionImportanteAccidentesArea.style.display = 'none';
                btnInformacionAccidentesAreas.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
            }
        });
    </script>
</div>

<div class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100"> Distribución de accidentes por sector- Año
            {{ $year }}</h2>
        <p class="text-slate-600 text-justify text-xs dark:text-slate-400 mt-2">Este gráfico de barras muestra la distribución de accidentes registrados en el año  {{ $year }} según el sector en el que ocurrieron.
            Cada barra representa un sector y su altura indica la cantidad de accidentes asociados a ese sector. Además, se resalta el sector con más accidentes y el sector con menos accidentes, proporcionando una visión general de cómo se distribuyen los accidentes en diferentes sectores durante el año seleccionado.</p>
    </header>


    <!-- Botón de ojo para ocultar/mostrar información -->
    <button id="btnInformacionAccidentesSector"
        class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
        <i class="far fa-eye"></i> Mostrar Información
    </button>

    <!-- Información importante inicialmente oculta -->
    <div id="informacionImportanteAccidentesSector" class="px-5 py-4 text-xs" style="display: none;">
        <p>Análisis de la gráfica de distribución de accidentes por sector:</p>
        <li> <strong>Resultados obtenidos en el año {{ $year }}.</strong></li>
        <li>
            <strong>Sectores con más accidentes:</strong>
            @foreach ($sectorConMasAccidentes as $index => $sector)
                {{ $sector }} ({{ $conteoSectors[$sector] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>

        <li>
            <strong>Sectores con menos accidentes:</strong>
            @foreach ($sectorConMenosAccidentes as $index => $sector)
                {{ $sector }} ({{ $conteoSectors[$sector] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>
    </div>

    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="overflow-x: auto; padding-right: 15px; padding-left: 15px;">
            <canvas id="barrasSector" width="800" height="300"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            const ctx = document.getElementById('barrasSector').getContext('2d');
            let chart;

            // Agregar oyente de eventos Livewire para actualizar el gráfico
            Livewire.on('updateBarrasSector', ({
                data
            }) => {
                updateBarrasSector(data);
            });

            function updateBarrasSector(data) {
                const sectors = data;

                const conteoSectors = {};
                sectors.forEach(sector => {
                    conteoSectors[sector] = (conteoSectors[sector] || 0) + 1;
                });

                const labels = Object.keys(conteoSectors).sort((a, b) => a - b);
                const counts = labels.map(sector => conteoSectors[sector]);

                const histogramaConfig = {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Cantidad de Accidentes',
                            data: counts,
                            backgroundColor: getRandomColor(),
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
                                    text: 'Sector'
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

                document.getElementById('sectorConMasAccidentes').textContent = 'Sector con más accidentes: ' +
                    getMaxSector(conteoSectors);
                document.getElementById('sectorConMenosAccidentes').textContent = 'Sector con menos accidentes: ' +
                    getMinSector(conteoSectors);
            }

            function getMaxSector(conteoSectors) {
                let maxAccidentes = 0;
                let sectorMaxAccidentes = null;
                for (const sector in conteoSectors) {
                    if (conteoSectors[sector] > maxAccidentes) {
                        maxAccidentes = conteoSectors[sector];
                        sectorMaxAccidentes = sector;
                    }
                }
                return sectorMaxAccidentes;
            }

            function getMinSector(conteoSectors) {
                let minAccidentes = Infinity;
                let sectorMinAccidentes = null;
                for (const sector in conteoSectors) {
                    if (conteoSectors[sector] < minAccidentes) {
                        minAccidentes = conteoSectors[sector];
                        sectorMinAccidentes = sector;
                    }
                }
                return sectorMinAccidentes;
            }

            updateBarrasSector(@json($sectors));


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
            const btnInformacionAccidentesSector = document.getElementById('btnInformacionAccidentesSector');
            const informacionImportanteAccidentesSector = document.getElementById('informacionImportanteAccidentesSector');

            if (event.target === btnInformacionAccidentesSector) {
                const isInfoVisible = informacionImportanteAccidentesSector.style.display !== 'none';
                informacionImportanteAccidentesSector.style.display = isInfoVisible ? 'none' : 'block';
                btnInformacionAccidentesSector.innerHTML = isInfoVisible ?
                    '<i class="far fa-eye"></i> Mostrar Información' :
                    '<i class="far fa-eye-slash"></i> Ocultar Información';
            } else if (event.target !== informacionImportanteAccidentesSector && !informacionImportanteAccidentesSector.contains(event.target)) {
                informacionImportanteAccidentesSector.style.display = 'none';
                btnInformacionAccidentesSector.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
            }
        });
    </script>
</div>

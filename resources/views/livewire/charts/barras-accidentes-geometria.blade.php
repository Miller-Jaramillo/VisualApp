<div class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Distribución de accidentes según geometría de la vía - Año
            {{ $year }}</h2>
        <p class="text-slate-600 text-xs text-justify dark:text-slate-400 mt-2">Este gráfico de barras muestra la distribución de accidentes registrados en el año {{ $year }} según la geometría de la vía en la que ocurrieron.
            Cada barra representa un tipo de geometría de la vía y su altura indica la cantidad de accidentes asociados a esa geometría. Además, se resalta la geometría de la vía con la mayor cantidad de accidentes y la geometría con la menor cantidad, proporcionando una visión general de cómo influye la geometría de las vías en la seguridad vial durante el año seleccionado.</p>
    </header>


    <!-- Botón de ojo para ocultar/mostrar información -->
    <button id="btnInformacionAccidentesGeometria"
        class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
        <i class="far fa-eye"></i> Mostrar Información
    </button>

    <!-- Información importante inicialmente oculta -->
    <div id="informacionImportanteAccidentesGeometria" class="px-5 py-4 text-xs" style="display: none;">
        <p>Análisis de la gráfica de distribución de accidentes según geometría de la vía :</p>
        <li> <strong>Resultados obtenidos en el año {{ $year }}.</strong></li>
        <li>
            <strong>Geometrias de la via con más accidentes:</strong>
            @foreach ($geometriaConMasAccidentes as $index => $geometria)
                {{ $geometria }} ({{ $conteoGeometrias[$geometria] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>

        <li>
            <strong>Geometrias de la via  con menos accidentes:</strong>
            @foreach ($geomtriaConMenosAccidentes as $index => $geometria)
                {{ $geometria }} ({{ $conteoGeometrias[$geometria] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>
    </div>

    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="overflow-x: auto; padding-right: 15px; padding-left: 15px;">
            <canvas id="barrasGeometrias" width="800" height="300"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            const ctx = document.getElementById('barrasGeometrias').getContext('2d');
            let chart;

            // Agregar oyente de eventos Livewire para actualizar el gráfico
            Livewire.on('updateBarrasGeometria', ({
                data
            }) => {
                updateBarrasGeometria(data);
            });

            function updateBarrasGeometria(data) {
                const geometrias = data;

                const conteoGeometrias = {};
                geometrias.forEach(geometria => {
                    conteoGeometrias[geometria] = (conteoGeometrias[geometria] || 0) + 1;
                });

                const labels = Object.keys(conteoGeometrias).sort((a, b) => a - b);
                const counts = labels.map(geometria => conteoGeometrias[geometria]);

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
                                    text: 'Geometria'
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

                document.getElementById('geometriaConMasAccidentes').textContent = 'Geometria con más accidentes: ' +
                    getMaxGeometria(conteoGeometrias);
                document.getElementById('geometriaConMenosAccidentes').textContent = 'Geometria con menos accidentes: ' +
                    getMinGeometria(conteoGeometrias);
            }

            function getMaxGeometria(conteoGeometrias) {
                let maxAccidentes = 0;
                let geometriaMaxAccidentes = null;
                for (const geometria in conteoGeometrias) {
                    if (conteoGeometrias[geometria] > maxAccidentes) {
                        maxAccidentes = conteoGeometrias[geometria];
                        geometriaMaxAccidentes = geometria;
                    }
                }
                return geometriaMaxAccidentes;
            }

            function getMinGeometria(conteoGeometrias) {
                let minAccidentes = Infinity;
                let geometriaMinAccidentes = null;
                for (const geometria in conteoGeometrias) {
                    if (conteoGeometrias[geometria] < minAccidentes) {
                        minAccidentes = conteoGeometrias[geometria];
                        geometriaMinAccidentes = geometria;
                    }
                }
                return geometriaMinAccidentes;
            }

            updateBarrasGeometria(@json($geometrias));

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
            const btnInformacionAccidentesGeometria = document.getElementById('btnInformacionAccidentesGeometria');
            const informacionImportanteAccidentesGeometria = document.getElementById('informacionImportanteAccidentesGeometria');

            if (event.target === btnInformacionAccidentesGeometria) {
                const isInfoVisible = informacionImportanteAccidentesGeometria.style.display !== 'none';
                informacionImportanteAccidentesGeometria.style.display = isInfoVisible ? 'none' : 'block';
                btnInformacionAccidentesGeometria.innerHTML = isInfoVisible ?
                    '<i class="far fa-eye"></i> Mostrar Información' :
                    '<i class="far fa-eye-slash"></i> Ocultar Información';
            } else if (event.target !== informacionImportanteAccidentesGeometria && !informacionImportanteAccidentesGeometria.contains(event.target)) {
                informacionImportanteAccidentesGeometria.style.display = 'none';
                btnInformacionAccidentesGeometria.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
            }
        });
    </script>
</div>

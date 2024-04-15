<div class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Histograma de Edades de Víctimas de Accidentes - Año
            {{ $year }}</h2>
        <p class="text-slate-600 text-xs dark:text-slate-400 mt-2">El histograma de edades tiene como objetivo
            representar visualmente la distribución de edades de las víctimas de accidentes, permitiendo identificar
            patrones y tendencias en las edades de las víctimas.</p>
    </header>


    <!-- Botón de ojo para ocultar/mostrar información -->
    <button id="toggleInfoButtonHistograma"
        class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
        <i class="far fa-eye"></i> Mostrar Información
    </button>

    <!-- Información importante inicialmente oculta -->
    <div id="importantInfoHistograma" class="px-5 py-4 text-xs" style="display: none;">
        <p>Análisis de la gráfica de Histograma:</p>
        <li> <strong>Resultados obtenidos en el año {{ $year }}.</strong></li>
        <li>
            <strong>Edades con más accidentes:</strong>
            @foreach ($edadConMasAccidentes as $index => $edad)
                {{ $edad }} ({{ $conteoEdades[$edad] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>

        <li>
            <strong>Edades con menos accidentes:</strong>
            @foreach ($edadConMenosAccidentes as $index => $edad)
                {{ $edad }} ({{ $conteoEdades[$edad] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>

        <li >
            <strong>Edad promedio de las víctimas:</strong> {{ $edadPromedio }} años
        </li>

        <li>
            <strong>Edad mediana de las víctimas:</strong> {{ $edadMediana }} años
        </li>


    </div>

    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="overflow-x: auto; padding-right: 15px; padding-left: 15px;">
            <canvas id="chart-histograma-accidentes" width="800" height="300"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            const ctx = document.getElementById('chart-histograma-accidentes').getContext('2d');
            let chart;

            // Agregar oyente de eventos Livewire para actualizar el gráfico
            Livewire.on('updateChartHistograma', ({
                data
            }) => {
                updateChartHistograma(data);
            });

            function updateChartHistograma(data) {
                const edades = data;

                const conteoEdades = {};
                edades.forEach(edad => {
                    conteoEdades[edad] = (conteoEdades[edad] || 0) + 1;
                });

                const labels = Object.keys(conteoEdades).sort((a, b) => a - b);
                const counts = labels.map(edad => conteoEdades[edad]);

                const histogramaConfig = {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Cantidad de Accidentes',
                            data: counts,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
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
                                    text: 'Edad'
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

                document.getElementById('edadConMasAccidentes').textContent = 'Edad con más accidentes: ' +
                    getMaxEdad(conteoEdades);
                document.getElementById('edadConMenosAccidentes').textContent = 'Edad con menos accidentes: ' +
                    getMinEdad(conteoEdades);
            }

            function getMaxEdad(conteoEdades) {
                let maxAccidentes = 0;
                let edadMaxAccidentes = null;
                for (const edad in conteoEdades) {
                    if (conteoEdades[edad] > maxAccidentes) {
                        maxAccidentes = conteoEdades[edad];
                        edadMaxAccidentes = edad;
                    }
                }
                return edadMaxAccidentes;
            }

            function getMinEdad(conteoEdades) {
                let minAccidentes = Infinity;
                let edadMinAccidentes = null;
                for (const edad in conteoEdades) {
                    if (conteoEdades[edad] < minAccidentes) {
                        minAccidentes = conteoEdades[edad];
                        edadMinAccidentes = edad;
                    }
                }
                return edadMinAccidentes;
            }

            updateChartHistograma(@json($edades));
        });

        // Agregar evento clic al botón para mostrar/ocultar información
        document.addEventListener('click', function(event) {
            const toggleInfoButtonHistograma = document.getElementById('toggleInfoButtonHistograma');
            const importantInfoHistograma = document.getElementById('importantInfoHistograma');

            if (event.target === toggleInfoButtonHistograma) {
                const isInfoVisible = importantInfoHistograma.style.display !== 'none';
                importantInfoHistograma.style.display = isInfoVisible ? 'none' : 'block';
                toggleInfoButtonHistograma.innerHTML = isInfoVisible ?
                    '<i class="far fa-eye"></i> Mostrar Información' :
                    '<i class="far fa-eye-slash"></i> Ocultar Información';
            } else if (event.target !== importantInfoHistograma && !importantInfoHistograma.contains(event.target)) {
                importantInfoHistograma.style.display = 'none';
                toggleInfoButtonHistograma.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
            }
        });
    </script>
</div>

<div class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Distribución de accidentes por tipo de superficie de rodadura - Año
            {{ $year }}</h2>
        <p class="text-slate-600 text-xs text-justify dark:text-slate-400 mt-2">Este gráfico de barras muestra la distribución de accidentes ocurridos en el año  {{ $year }} según el tipo de superficie de rodadura en la que tuvieron lugar.
            Cada barra representa un tipo de superficie y su altura indica la cantidad de accidentes asociados a esa superficie. Además, se resalta el tipo de superficie con más accidentes y el tipo con menos accidentes, brindando una visión detallada de cómo se distribuyen los accidentes en diferentes tipos de superficie de rodadura durante el año seleccionado.</p>
    </header>


    <!-- Botón de ojo para ocultar/mostrar información -->
    <button id="btnInformacionAccidentesSuperficieRodadura"
        class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
        <i class="far fa-eye"></i> Mostrar Información
    </button>

    <!-- Información importante inicialmente oculta -->
    <div id="informacionImportanteAccidentesSuperficieRodadura" class="px-5 py-4 text-xs" style="display: none;">
        <p>Análisis de la gráfica de distribución de accidentes por tipo de superficie de rodadura:</p>
        <li> <strong>Resultados obtenidos en el año {{ $year }}.</strong></li>
        <li>
            <strong>Superficie de Rodadura con más accidentes:</strong>
            @foreach ($superficieConMasAccidentes as $index => $superficie)
                {{ $superficie }} ({{ $conteoSuperficies[$superficie] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>

        <li>
            <strong>Superficie de Rodadura con menos accidentes:</strong>
            @foreach ($superficieConMenosAccidentes as $index => $superficie)
                {{ $superficie }} ({{ $conteoSuperficies[$superficie] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>
    </div>

    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="overflow-x: auto; padding-right: 15px; padding-left: 15px;">
            <canvas id="barrasSuperficieRodadura" width="800" height="300"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            const ctx = document.getElementById('barrasSuperficieRodadura').getContext('2d');
            let chart;

            // Agregar oyente de eventos Livewire para actualizar el gráfico
            Livewire.on('updateBarrasSuperficieRodadura', ({
                data
            }) => {
                updateBarrasSuperficieRodadura(data);
            });

            function updateBarrasSuperficieRodadura(data) {
                const superficies = data;

                const conteoSuperficies = {};
                superficies.forEach(superficie => {
                    conteoSuperficies[superficie] = (conteoSuperficies[superficie] || 0) + 1;
                });

                const labels = Object.keys(conteoSuperficies).sort((a, b) => a - b);
                const counts = labels.map(superficie => conteoSuperficies[superficie]);

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
                                    text: 'Superficies de Rodadura'
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

                document.getElementById('superficieConMasAccidentes').textContent = 'Superficie con más accidentes: ' +
                    getMaxSuperficie(conteoSuperficies);
                document.getElementById('superficieConMenosAccidentes').textContent = 'Superficie con menos accidentes: ' +
                    getMinSuperficie(conteoSuperficies);
            }

            function getMaxSuperficie(conteoSuperficies) {
                let maxAccidentes = 0;
                let superficieMaxAccidentes = null;
                for (const superficie in conteoSuperficies) {
                    if (conteoSuperficies[superficie] > maxAccidentes) {
                        maxAccidentes = conteoSuperficies[superficie];
                        superficieMaxAccidentes = superficie;
                    }
                }
                return superficieMaxAccidentes;
            }

            function getMinSuperficie(conteoSuperficies) {
                let minAccidentes = Infinity;
                let superficieMinAccidentes = null;
                for (const superficie in conteoSuperficies) {
                    if (conteoSuperficies[superficie] < minAccidentes) {
                        minAccidentes = conteoSuperficies[superficie];
                        superficieMinAccidentes = superficie;
                    }
                }
                return superficieMinAccidentes;
            }

            updateBarrasSuperficieRodadura(@json($superficies));



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
            const btnInformacionAccidentesSuperficieRodadura = document.getElementById('btnInformacionAccidentesSuperficieRodadura');
            const informacionImportanteAccidentesSuperficieRodadura = document.getElementById('informacionImportanteAccidentesSuperficieRodadura');

            if (event.target === btnInformacionAccidentesSuperficieRodadura) {
                const isInfoVisible = informacionImportanteAccidentesSuperficieRodadura.style.display !== 'none';
                informacionImportanteAccidentesSuperficieRodadura.style.display = isInfoVisible ? 'none' : 'block';
                btnInformacionAccidentesSuperficieRodadura.innerHTML = isInfoVisible ?
                    '<i class="far fa-eye"></i> Mostrar Información' :
                    '<i class="far fa-eye-slash"></i> Ocultar Información';
            } else if (event.target !== informacionImportanteAccidentesSuperficieRodadura && !informacionImportanteAccidentesSuperficieRodadura.contains(event.target)) {
                informacionImportanteAccidentesSuperficieRodadura.style.display = 'none';
                btnInformacionAccidentesSuperficieRodadura.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
            }
        });
    </script>
</div>

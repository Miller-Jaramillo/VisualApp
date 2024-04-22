<div class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Distribución de accidentes según condiciones de iluminación  - Año
            {{ $year }}</h2>
        <p class="text-slate-600 text-justify text-xs dark:text-slate-400 mt-2">Este gráfico de barras muestra la distribución de accidentes registrados en el año {{ $year }} según las condiciones de iluminación en las que ocurrieron.
            Cada barra representa una condición de iluminación y su altura indica la cantidad de accidentes asociados a esa condición. Además, se resalta la condición de iluminación con más accidentes y la condición con menos accidentes, proporcionando una visión general de cómo influye la iluminación en la seguridad vial durante el año seleccionado.</p>
    </header>


    <!-- Botón de ojo para ocultar/mostrar información -->
    <button id="btnInformacionAccidentesIluminacionArtificial"
        class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
        <i class="far fa-eye"></i> Mostrar Información
    </button>

    <!-- Información importante inicialmente oculta -->
    <div id="informacionImportanteAccidentesIluminacionArtificial" class="px-5 py-4 text-xs" style="display: none;">
        <p>Análisis de la gráfica de Accidentes por Iluminacion Artificial:</p>
        <li> <strong>Resultados obtenidos en el año {{ $year }}.</strong></li>
        <li>
            <strong>Iluminacion Artificial con más accidentes:</strong>
            @foreach ($condicionConMasAccidentes as $index => $condicion)
                {{ $condicion }} ({{ $conteoCondicions[$condicion] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>

        <li>
            <strong>Iluminacion Artificial con menos accidentes:</strong>
            @foreach ($condicionConMenosAccidentes as $index => $condicion)
                {{ $condicion }} ({{ $conteoCondicions[$condicion] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>
    </div>

    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="overflow-x: auto; padding-right: 15px; padding-left: 15px;">
            <canvas id="barrasIluminacionArtificial" width="800" height="300"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            const ctx = document.getElementById('barrasIluminacionArtificial').getContext('2d');
            let chart;

            // Agregar oyente de eventos Livewire para actualizar el gráfico
            Livewire.on('updateBarrasIluminacionArtificial', ({
                data
            }) => {
                updateBarrasIluminacionArtificial(data);
            });

            function updateBarrasIluminacionArtificial(data) {
                const condicions = data;

                const conteoCondicions = {};
                condicions.forEach(condicion => {
                    conteoCondicions[condicion] = (conteoCondicions[condicion] || 0) + 1;
                });

                const labels = Object.keys(conteoCondicions).sort((a, b) => a - b);
                const counts = labels.map(condicion => conteoCondicions[condicion]);

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
                                    text: 'Iluminacion Artificial'
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

                document.getElementById('condicionConMasAccidentes').textContent = 'Condicion con más accidentes: ' +
                    getMaxCondicion(conteoCondicions);
                document.getElementById('condicionConMenosAccidentes').textContent = 'Condicion con menos accidentes: ' +
                    getMinCondicion(conteoCondicions);
            }

            function getMaxCondicion(conteoCondicions) {
                let maxAccidentes = 0;
                let condicionMaxAccidentes = null;
                for (const condicion in conteoCondicions) {
                    if (conteoCondicions[condicion] > maxAccidentes) {
                        maxAccidentes = conteoCondicions[condicion];
                        condicionMaxAccidentes = condicion;
                    }
                }
                return condicionMaxAccidentes;
            }

            function getMinCondicion(conteoCondicions) {
                let minAccidentes = Infinity;
                let condicionMinAccidentes = null;
                for (const condicion in conteoCondicions) {
                    if (conteoCondicions[condicion] < minAccidentes) {
                        minAccidentes = conteoCondicions[condicion];
                        condicionMinAccidentes = condicion;
                    }
                }
                return condicionMinAccidentes;
            }

            updateBarrasIluminacionArtificial(@json($condicions));



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
            const btnInformacionAccidentesIluminacionArtificial = document.getElementById('btnInformacionAccidentesIluminacionArtificial');
            const informacionImportanteAccidentesIluminacionArtificial = document.getElementById('informacionImportanteAccidentesIluminacionArtificial');

            if (event.target === btnInformacionAccidentesIluminacionArtificial) {
                const isInfoVisible = informacionImportanteAccidentesIluminacionArtificial.style.display !== 'none';
                informacionImportanteAccidentesIluminacionArtificial.style.display = isInfoVisible ? 'none' : 'block';
                btnInformacionAccidentesIluminacionArtificial.innerHTML = isInfoVisible ?
                    '<i class="far fa-eye"></i> Mostrar Información' :
                    '<i class="far fa-eye-slash"></i> Ocultar Información';
            } else if (event.target !== informacionImportanteAccidentesIluminacionArtificial && !informacionImportanteAccidentesIluminacionArtificial.contains(event.target)) {
                informacionImportanteAccidentesIluminacionArtificial.style.display = 'none';
                btnInformacionAccidentesIluminacionArtificial.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
            }
        });
    </script>
</div>

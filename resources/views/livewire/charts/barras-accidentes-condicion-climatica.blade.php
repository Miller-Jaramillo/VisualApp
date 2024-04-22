<div class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Distribución de accidentes según condiciones climáticas - Año
            {{ $year }}</h2>
        <p class="text-slate-600 text-xs dark:text-slate-400 mt-2 text-justify">Este gráfico de barras muestra la distribución de accidentes registrados en el año  {{ $year }} según las condiciones climáticas en las que ocurrieron. Cada barra representa una condición climática y su altura indica la cantidad de accidentes asociados a esa condición. Además, se resalta la condición climática con la mayor cantidad de accidentes y la que tiene la menor cantidad, proporcionando una visión general de cómo afectan las condiciones climáticas a la seguridad vial en el año seleccionado.</p>
    </header>


    <!-- Botón de ojo para ocultar/mostrar información -->
    <button id="btnInformacionAccidentesCondicon"
        class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
        <i class="far fa-eye"></i> Mostrar Información
    </button>

    <!-- Información importante inicialmente oculta -->
    <div id="informacionImportanteAccidentesCondicion" class="px-5 py-4 text-xs" style="display: none;">
        <p>Análisis de la gráfica de distribución de accidentes según condiciones climáticas:</p>
        <li> <strong>Resultados obtenidos en el año {{ $year }}.</strong></li>
        <li>
            <strong>Condiciones climáticas con más accidentes:</strong>
            @foreach ($condicionConMasAccidentes as $index => $condicion)
                {{ $condicion }} ({{ $conteoCondicions[$condicion] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>

        <li>
            <strong>Condiciones climáticas con menos accidentes:</strong>
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
            <canvas id="barrasCondicion" width="800" height="300"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            const ctx = document.getElementById('barrasCondicion').getContext('2d');
            let chart;

            // Agregar oyente de eventos Livewire para actualizar el gráfico
            Livewire.on('updateBarrasCondicion', ({
                data
            }) => {
                updateBarrasCondicion(data);
            });

            function updateBarrasCondicion(data) {
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
                                    text: 'Condicion Climatica'
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

            updateBarrasCondicion(@json($condicions));



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
            const btnInformacionAccidentesCondicon = document.getElementById('btnInformacionAccidentesCondicon');
            const informacionImportanteAccidentesCondicion = document.getElementById('informacionImportanteAccidentesCondicion');

            if (event.target === btnInformacionAccidentesCondicon) {
                const isInfoVisible = informacionImportanteAccidentesCondicion.style.display !== 'none';
                informacionImportanteAccidentesCondicion.style.display = isInfoVisible ? 'none' : 'block';
                btnInformacionAccidentesCondicon.innerHTML = isInfoVisible ?
                    '<i class="far fa-eye"></i> Mostrar Información' :
                    '<i class="far fa-eye-slash"></i> Ocultar Información';
            } else if (event.target !== informacionImportanteAccidentesCondicion && !informacionImportanteAccidentesCondicion.contains(event.target)) {
                informacionImportanteAccidentesCondicion.style.display = 'none';
                btnInformacionAccidentesCondicon.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
            }
        });
    </script>
</div>

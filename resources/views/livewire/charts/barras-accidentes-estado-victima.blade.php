<div class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Distribución de accidentes según estado de la víctima  - Año
            {{ $year }}</h2>
        <p class="text-slate-600 text-xs dark:text-slate-400 text-justify mt-2">Este gráfico de barras horizontales muestra la distribución de accidentes registrados en el año  {{ $year }} según el estado en el que se encontraban las víctimas.
            Cada barra representa un estado de la víctima y su longitud indica la cantidad de accidentes en los que se encontraban víctimas en ese estado. Se resalta el estado de la víctima con la mayor cantidad de accidentes y el estado con la menor cantidad, proporcionando una visión general de cómo influye el estado de las víctimas en la seguridad vial durante el año seleccionado. La información detallada sobre el análisis de los datos se puede encontrar al hacer clic en el botón "Mostrar Información".</p>
    </header>


    <!-- Botón de ojo para ocultar/mostrar información -->
    <button id="btnInformacionAccidentesEstado"
        class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
        <i class="far fa-eye"></i> Mostrar Información
    </button>

    <!-- Información importante inicialmente oculta -->
    <div id="informacionImportanteAccidentesEstado" class="px-5 py-4 text-xs" style="display: none;">
        <p>Análisis de la gráfica de distribución de accidentes según estado de la víctima:</p>
        <li> <strong>Resultados obtenidos en el año {{ $year }}.</strong></li>
        <li>
            <strong>Estado de la victima con más accidentes:</strong>
            @foreach ($estadoConMasAccidentes as $index => $estado)
                {{ $estado }} ({{ $conteoEstados[$estado] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>

        <li>
            <strong>Estado de la victima on menos accidentes:</strong>
            @foreach ($estadoConMenosAccidentes as $index => $estado)
                {{ $estado }} ({{ $conteoEstados[$estado] }} accidentes)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </li>
    </div>

    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="overflow-x: auto; padding-right: 15px; padding-left: 15px;">
            <canvas id="barrasEstado" width="800" height="300"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            const ctx = document.getElementById('barrasEstado').getContext('2d');
            let chart;

            // Agregar oyente de eventos Livewire para actualizar el gráfico
            Livewire.on('updateBarrasEstadoVictima', ({
                data
            }) => {
                updateBarrasEstadoVictima(data);
            });

            function updateBarrasEstadoVictima(data) {
                const estados = data;

                const conteoEstados = {};
                estados.forEach(estado => {
                    conteoEstados[estado] = (conteoEstados[estado] || 0) + 1;
                });

                const labels = Object.keys(conteoEstados).sort((a, b) => a - b);
                const counts = labels.map(estado => conteoEstados[estado]);

                const histogramaConfig = {
    type: 'bar', // Tipo de gráfico sigue siendo 'bar'
    data: {
        labels: labels, // Las etiquetas de iluminación
        datasets: [{
            label: 'Cantidad de Accidentes',
            data: counts, // Los datos de accidentes
            backgroundColor: getRandomColor(),
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y', // Configuración clave para hacer que las barras se orienten horizontalmente
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { // El eje Y ahora maneja las etiquetas
                title: {
                    display: true,
                    text: 'Estado de la victima'
                }
            },
            x: { // El eje X ahora maneja los conteos de accidentes
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
                        const valor = context.parsed.x; // Cambiado de y a x debido a la orientación horizontal
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

                document.getElementById('estadoConMasAccidentes').textContent = 'Estado con más accidentes: ' +
                    getMaxEstado(conteoEstados);
                document.getElementById('estadoConMenosAccidentes').textContent = 'Estado con menos accidentes: ' +
                    getMinEstado(conteoEstados);
            }

            function getMaxEstado(conteoEstados) {
                let maxAccidentes = 0;
                let estadoMaxAccidentes = null;
                for (const estado in conteoEstados) {
                    if (conteoEstados[estado] > maxAccidentes) {
                        maxAccidentes = conteoEstados[estado];
                        estadoMaxAccidentes = estado;
                    }
                }
                return estadoMaxAccidentes;
            }

            function getMinEstado(conteoEstados) {
                let minAccidentes = Infinity;
                let estadoMinAccidentes = null;
                for (const estado in conteoEstados) {
                    if (conteoEstados[estado] < minAccidentes) {
                        minAccidentes = conteoEstados[estado];
                        estadoMinAccidentes = estado;
                    }
                }
                return estadoMinAccidentes;
            }

            updateBarrasEstadoVictima(@json($estados));



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
            const btnInformacionAccidentesEstado = document.getElementById('btnInformacionAccidentesEstado');
            const informacionImportanteAccidentesEstado = document.getElementById('informacionImportanteAccidentesEstado');

            if (event.target === btnInformacionAccidentesEstado) {
                const isInfoVisible = informacionImportanteAccidentesEstado.style.display !== 'none';
                informacionImportanteAccidentesEstado.style.display = isInfoVisible ? 'none' : 'block';
                btnInformacionAccidentesEstado.innerHTML = isInfoVisible ?
                    '<i class="far fa-eye"></i> Mostrar Información' :
                    '<i class="far fa-eye-slash"></i> Ocultar Información';
            } else if (event.target !== informacionImportanteAccidentesEstado && !informacionImportanteAccidentesEstado.contains(event.target)) {
                informacionImportanteAccidentesEstado.style.display = 'none';
                btnInformacionAccidentesEstado.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
            }
        });
    </script>
</div>

<div class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Diagrama de Dispersión Edad vs. Lesión</h2>
        <p class="text-xs text-gray-500 mt-2">Este diagrama visualiza la relación entre la edad y el tipo de lesión. Cada punto representa un caso individual, mostrando la combinación específica de edad y tipo de lesión.</p>
    </header>
    <div id="dispersion-legend" class="px-5 py-3">
        <!-- Icono de ojo -->
        <button id="toggleLegendBtn-dispersion" class="text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
            <div class="grid grid-cols-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                        clip-rule="evenodd" />
                </svg>
                <x-label>Informacion</x-label>
            </div>
        </button>
        <ul class="flex flex-wrap text-xs" style="display: none;"></ul>
    </div>
    <div id="additional-info-dispersion" style="display: none;" class="px-5 py-3">
        <!-- Información adicional -->
        <p class="text-xs text-gray-500 mt-2">La siguiente información muestra las tendencias basadas en los datos reales representados en el diagrama de dispersión. Cada tipo de lesión tiene asociadas ciertas edades con mayor incidencia.</p>
        <div class="flex flex-wrap">
            <div class="w-1/2 pr-2">
                <ul id="column1" class="flex flex-col"></ul>
            </div>
            <div class="w-1/2 pl-2">
                <ul id="column2" class="flex flex-col"></ul>
            </div>
        </div>
    </div>
    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="max-width: 100%; overflow: hidden; margin: auto;">
            <canvas id="chart-dispersion" width="800" height="400"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById("chart-dispersion").getContext("2d");
        const data = {!! json_encode($data) !!};

        // Organizar los datos por tipo de lesión
        const groupedData = groupBy(data, 'lesion');

        // Configuración del gráfico de dispersión
        const scatterChartConfig = {
            type: 'scatter',
            data: {
                datasets: Object.keys(groupedData).map((lesion, index) => ({
                    label: lesion,
                    data: removeDuplicates(groupedData[lesion], 'edad').map(item => ({ x: item.edad, y: getRandomYValue() })),
                    backgroundColor: getRandomColor(),
                    pointRadius: 8,
                    pointHoverRadius: 10,
                })),
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom',
                        title: {
                            display: true,
                            text: 'Edad',
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Tipo de Lesión',
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                    },
                },
                hoverOffset: 8,
            },
        };

        const chart = new Chart(ctx, scatterChartConfig);

        // Agregar leyendas al elemento legend
        const legend = document.getElementById('dispersion-legend');
        const legendList = legend.querySelector('ul');
        Object.keys(groupedData).forEach((lesion, index) => {
            const color = scatterChartConfig.data.datasets[index].backgroundColor;
            const listItem = document.createElement('li');
            listItem.innerHTML = `<span style="display:inline-block;width:15px;height:15px;background-color:${color};margin-right:5px;"></span>${lesion}: ${groupedData[lesion].length} &nbsp;&nbsp;`;
            legendList.appendChild(listItem);
        });

        // Agregar información adicional
        const additionalInfo = document.getElementById('additional-info-dispersion');
        const column1 = document.getElementById('column1');
        const column2 = document.getElementById('column2');
        let columnIndex = 1;

        Object.keys(groupedData).forEach((lesion, index) => {
            const ages = getMostFrequentAge(groupedData[lesion], 'edad');
            const listItem = document.createElement('li');
            listItem.innerHTML = `<span style="font-size:12px;"><b>${lesion}</b>: Edad más común: ${ages}</span>`;

            if (columnIndex === 1) {
                column1.appendChild(listItem);
                columnIndex = 2;
            } else {
                column2.appendChild(listItem);
                columnIndex = 1;
            }
        });

        const toggleButton = document.getElementById('toggleLegendBtn-dispersion');

        // Manejar el clic en el botón de alternar leyenda e información adicional
        toggleButton.addEventListener('click', function () {
            const legendDisplayStyle = legendList.style.display;
            const additionalInfoDisplayStyle = additionalInfo.style.display;

            legendList.style.display = legendDisplayStyle === 'none' ? 'block' : 'none';
            additionalInfo.style.display = additionalInfoDisplayStyle === 'none' ? 'block' : 'none';
        });

        // Función para cerrar la información adicional cuando se hace clic fuera de ella
        document.addEventListener('click', function (event) {
            const isClickInside = additionalInfo.contains(event.target) || toggleButton.contains(event.target);
            if (!isClickInside) {
                legendList.style.display = 'none';
                additionalInfo.style.display = 'none';
            }
        });

        // Función para generar un color aleatorio
        function getRandomColor() {
            return `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.7)`;
        }

        // Función para generar un valor aleatorio en el eje Y
        function getRandomYValue() {
            return Math.random() * 10; // Ajusta el rango según tus necesidades
        }

        // Función para agrupar datos por una propiedad específica
        function groupBy(arr, key) {
            return arr.reduce((acc, obj) => {
                const property = obj[key];
                acc[property] = acc[property] || [];
                acc[property].push(obj);
                return acc;
            }, {});
        }

        // Función para eliminar duplicados de un array basado en una propiedad específica
        function removeDuplicates(arr, prop) {
            return arr.filter((obj, index, self) =>
                index === self.findIndex((el) => (
                    el[prop] === obj[prop]
                ))
            );
        }

        // Función para obtener la edad más común en un conjunto de datos
        function getMostFrequentAge(data, prop) {
            const ages = data.map(item => item[prop]);
            const counts = {};
            let maxCount = 0;
            let mostFrequentAge;

            ages.forEach((age) => {
                counts[age] = (counts[age] || 0) + 1;

                if (counts[age] > maxCount) {
                    maxCount = counts[age];
                    mostFrequentAge = age;
                }
            });

            return mostFrequentAge;
        }
    });
</script>

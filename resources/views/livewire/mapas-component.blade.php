<div>
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Mapa de accidentes -
            Año {{ $year }}</h2>
            <p class="text-slate-600 text-justify text-xs dark:text-slate-400 mt-2">Esta vista muestra un mapa interactivo
                que visualiza las 5 ubicaciones con más accidentes registrados en un área específica para cada año seleccionado.
                Al elegir un año en el filtro, el mapa se actualiza para mostrar las 5 ubicaciones con más accidentes ocurridos en ese año, con marcadores que indican la dirección, el barrio y el número de accidentes en cada ubicación. La información en el mapa se actualiza dinámicamente según la selección del usuario, lo que permite analizar la distribución y la frecuencia de los accidentes en diferentes años..</p>
    </header>


    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="overflow-x: auto; padding-right: 15px; padding-left: 15px;">
            <!-- ... Tu tabla existente ... -->
            <table class="min-w-full leading-normal dark:bg-slate-950 w-full md:w-auto min-w-full ">
                <thead class="border-b dark:border-indigo-800 border-indigo-500">
                    <tr>
                        <th
                            class="px-6 py-3  bg-white dark:bg-slate-900 text-gray-500 text-center text-xs font-medium  uppercase tracking-wider">
                            Dirección</th>
                        {{-- <th class="px-5 py-3 border-b-2 border-gray-200 dark:bg-slate-950text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Latitud</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:bg-slate-950 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Longitud</th> --}}
                        <th
                            class="px-6 py-3  bg-white dark:bg-slate-900 text-gray-500 text-center text-xs font-medium  uppercase tracking-wider">
                            Barrio</th>
                        <th
                            class="px-6 py-3  bg-white dark:bg-slate-900 text-gray-500 text-center text-xs font-medium  uppercase tracking-wider">
                            Accidentes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coordenadas as $coor)
                        <tr>

                            <td class="px-6 py-4 text-center">
                                <p class="text-sm leading-6 dark:text-gray-100  text-gray-900">
                                    {{ $coor['direccion'] }}</p>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <p class="text-sm leading-6 dark:text-gray-100  text-gray-900">
                                    {{ $coor['barrio'] }}</p>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <p class="text-sm leading-6 dark:text-gray-100  text-gray-900">
                                    {{ $coor['totalAccidentes'] }}</p>
                            </td>


                            {{-- <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $coor['latitud'] }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $coor['longitud'] }}</td> --}}

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

        <!-- Mapa Leaflet -->
        <div class="  border-2 dark:border-indigo-800 border-indigo-500 max-w-7xl mx-auto rounded-md">


            <div class="px-2 py-2">
                <div id="map" style="height: 500px;"></div>
            </div>

        </div>


</div>




<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />


<!-- Agregar Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
 document.addEventListener('livewire:load', function() {
    let map = null; // Referencia al mapa Leaflet

    Livewire.on('updateMapa', ({ coordenadas }) => {
        // Destruir el mapa existente si existe
        if (map) {
            map.remove();
        }

        // Crear un nuevo mapa y añadir los marcadores
        map = L.map('map').setView([1.2136, -77.2811], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const accidentIcon = L.icon({
            iconUrl: '{{ asset('images/accident2.png') }}',
            iconSize: [48, 48],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        coordenadas.forEach(coor => {
            L.marker([coor.latitud, coor.longitud], { icon: accidentIcon })
                .addTo(map)
                .bindPopup(
                    `<b>Dirección:</b> ${coor.direccion}<br><b>Barrio:</b> ${coor.barrio}<br><b>Accidentes:</b> ${coor.totalAccidentes}`
                )
                .openPopup();
        });
    });

    Livewire.emit('updateMapa', {
        coordenadas: @json($coordenadas)
    });
});

</script>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<!-- Agregar Leaflet.markercluster CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />

<div class="max-w-7xl mx-auto  lg:px-12 px-12 sm:px-12 bg-white dark:bg-slate-950 ">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Ubicaciones con mas accidentes</h2>
    </header>
    <div id="maps-component" class="px-10 py-3">
        <!-- Mapa Leaflet -->
        <div id="map" style="height: 500px;"></div>
    </div>
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
</div>

<!-- Agregar Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>



<!-- Agregar Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Coordenadas obtenidas desde el backend
        const coordenadas = {!! json_encode($coordenadas) !!};

        // Crear mapa
        const map = L.map('map').setView([1.2136, -77.2811],
        15); // Centro del mapa (latitud y longitud), y nivel de zoom

        // Agregar capa de mapa base (puedes elegir otro proveedor de mapas)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const accidentIcon = L.icon({
            iconUrl: '{{ asset('images/accident2.png') }}', // Ruta al ícono personalizado
            iconSize: [48, 48], // Ajusta el tamaño del ícono según sea necesario
            iconAnchor: [16, 32], // Ajusta la posición del ancla del ícono si es necesario
            popupAnchor: [0, -32] // Ajusta la posición del popup del ícono si es necesario
        });

        coordenadas.forEach(coor => {
            // Usa el ícono personalizado para los marcadores
            L.marker([coor.latitud, coor.longitud], {
                    icon: accidentIcon
                }).addTo(map)
                .bindPopup(
                    `<b>Dirección:</b> ${coor.direccion}<br><b>Barrio:</b> ${coor.barrio}<br><b>Accidentes:</b> ${coor.totalAccidentes}`
                    )
                .openPopup();
        });
    });
</script>

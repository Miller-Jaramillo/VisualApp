<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Welcome banner -->
        <x-dashboard.welcome-banner />




        <div id="informacionInicial" style="display: none;">
            @include('introduccion-visualapp')

            <div class="mt-2 grid grid-cols-12 gap-6 pb-5">
                @include('objetivos-visualapp')

                @include('vision-visualapp')

            </div>




        </div>


        <div class="flex items-between justify-between pb-5">

            @role('user')
            <div>
                <X-button id="btnInfo"
                    class="px-3 py-2 mt-2 mb-4 text-xs bg-green-500 text-gray-100 dark:bg-green-500 dark:text-gray-100 rounded-md
                            hover:bg-green-600 dark:hover:bg-green-600">
                    <i class="far fa-eye"></i> INFORMATE AQUI
                </X-button>
            </div>
            @endrole


            <div>
                @livewire('select-component')
            </div>

        </div>


        {{-- @livewire('charts.grafico-pastel-accidentes') --}}


        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6 mt-2">

            @livewire('charts.grafico-pastel-accidentes')
            @livewire('charts.grafico-pastel-clases-accidentes')
            @livewire('charts.barras-accidentes-estado-via')

            @livewire('charts.barras-accidentes-estado-victima')


            @livewire('charts.barras-accidentes-superficie-rodaduras')

            @livewire('charts.barras-accidentes-area')
            @livewire('charts.barras-accidentes-geometria')




            @livewire('charts.barras-accidentes-condicion-climatica')
            @livewire('charts.barras-accidentes-sector')

            @livewire('charts.barras-accidentes-iluminacion')
            @livewire('charts.histograma-accidentes')

            @livewire('charts.barras-apiladas-clase-genero')

            @livewire('charts.grafico-barras-apiladas')

            @livewire('charts.barras-apiladas-tipo-victima-genero')

            @livewire('charts.grafico-barras-accidestes-por-dia')

            @livewire('charts.grafico-burbujas-accidentes')






        </div>




    </div>
</x-app-layout>

<script>
    // Agregar evento clic al botón para mostrar/ocultar información
    document.addEventListener('click', function(event) {
        const btnInfo = document.getElementById('btnInfo');
        const informacionInicial = document.getElementById('informacionInicial');

        if (event.target === btnInfo) {
            const isInfoVisible = informacionInicial.style.display !== 'none';
            informacionInicial.style.display = isInfoVisible ? 'none' : 'block';
            btnInfo.innerHTML = isInfoVisible ?
                '<i class="far fa-eye"></i> Mostrar Información' :
                '<i class="far fa-eye-slash"></i> Ocultar Información';
        } else if (event.target !== informacionInicial && !informacionInicial.contains(event.target)) {
            informacionInicial.style.display = 'none';
            btnInfo.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
        }
    });
</script>

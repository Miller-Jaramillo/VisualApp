<div>
    <header class="px-5 py-4 border-b border-slate-400 dark:border-slate-700">
        <h2 class="font-semibold  tracking-wider text-slate-800 dark:text-slate-100">Nuevo registro</h2>

        <div class="mt-2">
            <X-button id="btnTutorial"
                class="px-3 py-2 mt-2 mb-4 text-xs bg-blue-500 text-gray-100 dark:bg-blue-500 dark:text-gray-100 rounded-md
                        hover:bg-green-600 dark:hover:bg-green-600">
                <i class="far fa-eye"></i> ¿COMO DEBO SUBIR UN REGISTRO?
            </X-button>
        </div>
    </header>

    <div>
        @if(session()->has('message'))
            <div class="bg-green-200 p-4 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <!-- Resto de tu contenido -->
    </div>


    <div class="bg-gray-100 dark:bg-slate-950 flex items-center justify-center">
        <div class="container max-w-screen-lg mx-auto">







            <div class="">
                <div class="dark:bg-slate-950 bg-slate-100 rounded shadow-lg p-4 px-4 md:p-8 mb-6 ">

                    <div>
                        @if (session('mensaje'))
                            <!-- Warning -->
                            <div class="mt-5">
                                <div class="bg-green-100 text-green-600 px-3 py-2 rounded">
                                    <svg class="inline w-3 h-3 shrink-0 fill-current" viewBox="0 0 12 12">
                                        <path
                                            d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                    </svg>
                                    <span class="text-sm">
                                        {{ session('mensaje') }}
                                    </span>
                                </div>
                            </div>
                        @endif


                        <div id="infoTutorial" style="display: none;" class="pb-5">
                           @include('tutorial-base')
                        </div>

                        <form wire:submit.prevent="cargarBase">

                            <div class="px-16 ">

                                <div class="text-gray-600 ">
                                    <p class="uppercase tracking-wider font-medium text-md dark:text-gray-200">Sube un nuevo registro</p>
                                    <p class="tracking-wider text-sm">Por favor carga los datos con la plantilla correcta.</p>
                                </div>

                                <div class="lg:col-span-2 mt-5">
                                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-7">


                                        <div class="form-group col-span-5 sm:col-span-2 ">
                                            <x-label class="tracking-wider">Nombre</x-label>
                                            <x-input type="text" wire:model="nombre"
                                                class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-slate-900  tracking-wider" />
                                            @error('nombre')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-span-5">
                                            <x-label class="tracking-wider">Descripción</x-label>
                                            <x-input wire:model="descripcion"
                                                class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-slate-900"></x-input>
                                            @error('descripcion')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-span-3 sm:col-span-2">
                                            <x-label class="tracking-wider">Fecha Inicial</x-label>
                                            <x-input type="date" wire:model="fecha_desde"
                                                class="form-control h-10 border mt-1 rounded w-full dark:bg-slate-900 bg-gray-50" />
                                            @error('fecha_desde')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-span-2">
                                            <x-label class="tracking-wider">Fecha Final</x-label>
                                            <x-input type="date" wire:model="fecha_hasta"
                                                class="form-control h-10 border mt-1 rounded px-4 w-full dark:bg-slate-900 bg-gray-50" />
                                            @error('fecha_hasta')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-span-3">
                                            <x-label class=" tracking-wider block mb-2 text-sm font-medium  "  for="archivo">Archivo XLSX</x-label>
                                            <x-input type="file" wire:model="archivo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" />
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="user_avatar_help">Cargar archivo excel</div>

                                            @error('archivo')
                                                <div class="mt-5">
                                                    <div class="bg-red-100 text-red-600 px-3 py-2 rounded">
                                                        <svg class="inline w-3 h-3 shrink-0 fill-current" viewBox="0 0 12 12">
                                                            <path d="M6 1.5A4.49 4.49 0 002.5 6c0 2.49 2.01 4.5 4.5 4.5s4.5-2.01 4.5-4.5S8.49 1.5 6 1.5zM6 10a3.48 3.48 0 01-3.5-3h7a3.48 3.48 0 01-3.5 3z" />
                                                        </svg>
                                                        <span class="text-danger">{{ $message }}</span>
                                                    </div>
                                                </div>

                                            @enderror
                                        </div>



                                        <div class="col-span-6 flex justify-center">

                                            <x-button type="submit" class="mt-2">Cargar Base de Datos</x-button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>


<script>
    // Agregar evento clic al botón para mostrar/ocultar información
    document.addEventListener('click', function(event) {
        const btnTutorial = document.getElementById('btnTutorial');
        const infoTutorial = document.getElementById('infoTutorial');

        if (event.target === btnTutorial) {
            const isInfoVisible = infoTutorial.style.display !== 'none';
            infoTutorial.style.display = isInfoVisible ? 'none' : 'block';
            btnTutorial.innerHTML = isInfoVisible ?
                '<i class="far fa-eye"></i> Mostrar Información' :
                '<i class="far fa-eye-slash"></i> Ocultar Información';
        } else if (event.target !== infoTutorial && !infoTutorial.contains(event.target)) {
            infoTutorial.style.display = 'none';
            btnTutorial.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
        }
    });
</script>














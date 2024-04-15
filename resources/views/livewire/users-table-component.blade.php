<div wire:poll.5000ms>
    <header class="px-5 py-4 border-b border-slate-400 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Usuarios</h2>
    </header>



    <div class="py-5">
        <div class="max-w-7xl mx-auto  lg:px-12 px-12 sm:px-12">
            <div class="bg-slate-100 dark:bg-slate-950 overflow-hidden sm:rounded-md rounded-md  ">

                {{-- --> REGISTRAR NUEVO ADMINISTRADOR --}}
                {{-- cmt: AQUI ROL --}}
                <div class="flex gap-2">
                    <button wire:click="openForm"
                        class="bg-white dark:bg-slate-950 dark:sm:bg-slate-950 dark:text-gray-500 text-gray-500
                        sm:form-input border-none  sm:rounded-md shadow-sm block icon-blue green-hover justify-center"
                        title="Agregar Administrador">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                            <path
                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                        </svg>
                    </button>

                    <input wire:model="search"
                        class="form-input rounded-md shadow-sm  block w-full
                    bg-indigo-50 dark:bg-slate-900 text-gray-500 dark:border-indigo-900 border-indigo-200 "
                        type="text" placeholder="Buscar">

                    @if ($search != '')
                        <button wire:click="clear"
                            class="bg-white dark:bg-slate-950 dark:sm:bg-slate-950 dark:text-gray-500 text-gray-500
                         sm:form-input border-none
                         sm:rounded-md shadow-sm  block icon-red  justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-6 h-6">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif


                    {{-- --> Aqui va el select Para filtar los usarios de la tabla or rol-  --}}
                    {{-- cmt: AQUI ROL --}}

                    <div>
                        <select wire:model="selectedRole"
                            class="  dark:border-indigo-900 border-indigo-200 outline-none bg-indigo-50 text-gray-500 text-sm rounded-md dark:bg-gray-900 block">
                            <option value="todos">Todos los usuarios</option>
                            <option value="administradores">Administradores</option>
                            <option value="usuarios">Usuarios</option>

                        </select>
                    </div>

                    {{-- --> Buscar or paginal-  --}}
                    <div>
                        <select wire:model="perPage"
                            class="dark:border-indigo-900 border-indigo-200 outline-none bg-indigo-50 text-gray-500 text-sm rounded-md dark:bg-gray-900 ">
                            <option value="5">Mostrar 5</option>
                            <option value="10">Mostrar 10</option>
                            <option value="15">Mostrar 15</option>
                            <option value="25">Mostrar 25</option>
                            <option value="50">Mostrar 50</option>
                            <option value="100">Mostrar 100</option>
                        </select>
                    </div>


                </div>



            </div>
        </div>



        <div class="py-5 ">
            <div class=" max-w-7xl mx-auto sm:px-6 lg:px-8    px-4 sm:px-6  ">
                <div class="bg-slate-100 dark:bg-slate-950 overflow-hidden shadow-xl sm:rounded-lg rounded-md">

                    @if ($users->count())
                        <table class="w-full md:w-auto min-w-full ">
                            <thead class="border-b dark:border-indigo-800 border-indigo-500">
                                <tr>
                                    <th
                                        class=" px-6 py-3  bg-white dark:bg-slate-900 text-gray-500 text-center text-xs font-medium  uppercase tracking-wider">
                                        Nombre</th>
                                    <th
                                        class="hidden sm:table-cell px-6 py-3  bg-white dark:bg-slate-900 text-gray-500 text-center text-xs font-medium  uppercase tracking-wider">
                                        Correo Electrónico</th>
                                    <th
                                        class="px-6 py-3  bg-white dark:bg-slate-900 text-gray-500 text-center text-xs font-medium  uppercase tracking-wider">
                                        Rol</th>
                                    <th
                                        class="hidden sm:table-cell px-6 py-3  bg-white dark:bg-slate-900 text-gray-500 text-center text-xs font-medium  uppercase tracking-wider">
                                        Última conexión</th>
                                    <th
                                        class="px-6 py-3  bg-white dark:bg-slate-900 text-gray-500 text-center text-xs font-medium  uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>


                            <tbody class="dark:bg-slate-950 divide-y dark:divide-indigo-950 divide-indigo-50">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <img class="h-10 w-10 rounded-full object-cover "
                                                    src="{{ $user->profile_photo_url }}" alt="{{ $user->email }}">
                                                <div class="ml-4">
                                                    <p
                                                        class="text-sm font-semibold leading-6 dark:text-gray-100  text-gray-900">
                                                        {{ $user->name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="hidden sm:table-cell px-6 py-4 text-center">
                                            <p class="text-sm leading-6 dark:text-gray-100  text-gray-900">
                                                {{ $user->email }}</p>
                                        </td>

                                        <td class="px-6 py-4 text-center ">
                                            <p class="text-sm leading-6 dark:text-gray-100  text-gray-900">
                                                {{ $user->role_name }}</p>
                                        </td>

                                        <td class="hidden sm:table-cell px-6 py-4 text-center">
                                            <p class="text-sm leading-6 dark:text-gray-100  text-gray-900">
                                                {{ $user->updated_at }}</p>
                                        </td>

                                        {{-- --> ICONOS - ACCIONES --}}

                                        <td class="px-6 py-4 text-center dark:bg-slate-950 bg-slate-100 ">
                                            <!-- Iconos de ver, editar y eliminar -->
                                            <div class="flex justify-center">

                                                @if ($user->id !== Auth::id())
                                                    {{-- -->Eliminar User --}}
                                                    @role('admin')
                                                        @if ($user->role_name !== 'Super Admin')
                                                            <a href="#"
                                                                wire:click="confirmUserDeletion({{ $user->id }})"
                                                                class="red-hover icon-red">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                    fill="currentColor" class="w-10 h-6">
                                                                    <path fill-rule="evenodd"
                                                                        d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </a>
                                                        @endif
                                                    @endrole
                                                @else
                                                    @role('admin')
                                                        <x-button wire:click="estadisticas">
                                                            Estadisticas
                                                        </x-button>
                                                    @endrole
                                                    @role('espectador')
                                                        <x-button wire:click="openFormParticipate"
                                                            class="dark:bg-red-500 bg-red-500 hover:bg-blue-400 dark:hover:bg-blue-400 ">
                                                            participar
                                                        </x-button>
                                                    @endrole

                                                    @role('participante')
                                                        <x-button wire:click="enviarPropuesta"
                                                            class="dark:bg-green-500 bg-green-500 hover:bg-green-400 dark:hover:bg-green-400 ">
                                                            Enviar Propuesta
                                                        </x-button>
                                                    @endrole
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                {{-- --> ALERT DIALOG - Eliminar User --}}
                                @if ($confirmingUserDeletion)
                                    <div
                                        class="fixed inset-0 flex items-center justify-center dark:bg-slate-950 bg-slate-100 bg-opacity-90 dark:bg-opacity-90">
                                        <div
                                            class="bg-white dark:bg-gray-800 dark:text-white text-gray-900 p-6 rounded-lg shadow-xl border-2 border-blue-500">
                                            <p>¿Estás seguro de eliminar a {{ $name }}?</p>
                                            <div class="mt-4 flex justify-end">
                                                <button wire:click="deleteUser({{ $confirmingUserDeletion }})"
                                                    class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600">
                                                    Sí, eliminar
                                                </button>

                                                <button wire:click="cancelUserDeletion"
                                                    class="px-4 py-2 ml-4 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div>
                                    @if ($message)
                                        <div x-data="{ show: @entangle('message') }" x-show="show" x-init="setTimeout(() => { show = false; }, 3000)"
                                            class="fixed inset-0 flex items-center justify-center">
                                            <div
                                                class="bg-white dark:bg-gray-800 text-white py-2 px-4 rounded-lg text-center">
                                                {!! $message !!}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </tbody>
                        </table>

                        <div
                            class="justify-between border-t dark:border-indigo-800 border-indigo-500  dark:bg-gray-900 bg-white px-4 py-3 sm:px-6 text-gray-500 ">
                            {{ $users->links() }}
                        </div>
                    @else
                        <div
                            class="justify-between border-t dark:border-indigo-800 border-indigo-500 dark:bg-gray-900 bg-gray-100 dark:text-indigo-800 text-indigo-500 px-4 py-3 sm:px-6">
                            No hay resultados para búsqueda "{{ $search }}" en la página {{ $page }}
                            al
                            mostrar
                            {{ $perPage }} por página
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center">
            {{-- !! MOSTRAR INFORMACION --}}
            @if ($openEstadisticas)
                <div
                    class="fixed inset-0 flex items-center justify-center dark:bg-slate-950 bg-slate-100 bg-opacity-90 dark:bg-opacity-90">
                    <div
                        class="bg-white dark:bg-gray-800 dark:text-gray-100 text-gray-900 p-6 rounded-lg shadow-xl border-2 border-indigo-500 dark:border-indigo-800">
                        <div class="flex justify-center">
                            <button wire:click="closeUserInfo" class="shadow-sm ml-3 block icon-red  ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>

                        <x-label
                            class="text-sm font-semibold leading-6 dark:text-gray-100  text-gray-900 tracking-widest uppercase ">
                            <b>Estadisticas de registro</b>
                        </x-label>

                        <div class="mt-2">
                            <div>
                                <x-label
                                    class="text-sm font-semibold leading-6 dark:text-gray-100  text-gray-900 tracking-widest ">
                                    Total de usuarios: {{ $totalUsers }}
                                </x-label>
                            </div>

                            <div>
                                <x-label
                                    class="text-sm font-semibold leading-6 dark:text-gray-100  text-gray-900 tracking-widest ">
                                    Administradores: {{ $adminCount }}
                                </x-label>
                            </div>

                            <div>
                                <x-label
                                    class="text-sm font-semibold leading-6 dark:text-gray-100  text-gray-900 tracking-widest ">
                                    Usuarios: {{ $userCount }}
                                </x-label>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>





        <!--  Formulario Particiante  -->
        <div class="flex items-center">
            {{-- !! FORMULARIO ROL PARTICIPANTE --}}
            @if ($showFormParticipate)
                @include('auth.register-participante')
            @endif
        </div>

        @if ($showForm)
            <div id="floating-form"
                class="fixed inset-0 flex items-center justify-center dark:bg-slate-950 bg-slate-100 bg-opacity-90 dark:bg-opacity-90 ">
                <div
                    class="bg-gray-100 dark:bg-gray-800 p-6 rounded-md dark:text-white text-gray-900 border border-indigo-800">

                    <form wire:submit.prevent="submitForm">
                        <div class="text-center">
                            <p>Registrar nuevo Administrador</p>
                        </div>

                        <div class="mt-5">
                            <x-label for="name" value="{{ __('Name') }}" />
                            <x-input id="name" class="block mt-1 w-full " type="text" name="name"
                                wire:model="name" required autofocus autocomplete="name" />
                        </div>

                        <div class="mt-4">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                wire:model="email" required autocomplete="username" />
                        </div>

                        {{-- <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password"
                    name="password" wire:model="password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation"
                    value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full"
                    type="password" name="password_confirmation" required
                    autocomplete="new-password" />
            </div> --}}

                        <div class="mt-4 flex justify-end">
                            <x-button wire:click="closeForm" type="button"
                                class="px-4 py-2 text-sm font-medium shadow-sm rounded-md dark:hover:bg-red-400  hover:bg-red-500">
                                Cancelar
                            </x-button>
                            <x-button wire:click="submitForm"
                                class="ml-4 shadow-sm rounded-md dark:bg-green-500  bg-green-500 dark:hover:bg-green-600  hover:bg-green-600">
                                {{ __('Registrar') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>





<style>
    .red-hover:hover path {
        fill: red;
    }

    .yellow-hover:hover path {
        fill: rgb(166, 22, 188);
    }


    .icon-blue path {
        fill: rgb(24, 109, 220);
    }

    .blue-hover:hover path {
        fill: rgb(24, 109, 220);
    }

    .green-hover:hover path {
        fill: rgb(0, 255, 38);
    }

    .icon-green path {
        fill: rgb(0, 255, 38);
    }

    .icon-oranch path {
        fill: rgb(255, 119, 0);
    }

    .icon-red path {
        fill: rgb(255, 0, 0);
    }


    .icon-blueclar path {
        fill: rgb(0, 200, 255);
    }

    .icon-oro path {
        fill: rgb(218, 165, 32);
    }
</style>

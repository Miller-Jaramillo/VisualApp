<div>
    <!-- Fondo de la barra lateral (solo móvil) -->
    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <!-- Barra lateral -->
    <div id="sidebar"
        class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 dark:bg-slate-950 bg-slate-100  p-4 transition-all duration-200 ease-in-out"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false" x-cloak="lg">

        <!-- Encabezado de la barra lateral -->
        <div class="flex justify-center mt-5 mb-5 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="block" href="{{ route('dashboard') }}">

                @if (Auth::user()->profile_photo_path)
                    <!-- Foto de perfil del usuario -->
                    <img class="w-24 h-24 rounded-full object-cover lg:hidden lg:sidebar-expanded:block 2xl:block"
                        src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Foto de perfil">
                @else
                    <!-- Foto de perfil por defecto -->
                    <img class="w-24 h-24 rounded-full object-cover lg:hidden lg:sidebar-expanded:block 2xl:block"
                        src="{{ asset('images/visualapp.png') }}" alt="Foto de perfil por defecto">
                @endif

            </a>
        </div>

        <!-- Enlaces -->
        <div class="space-y-8">
            <!-- Grupo de páginas -->

            <div>
                <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
                </h3>
                <ul class="mt-3">
                    <!-- Enlace al Dashboard -->
                    <li>
                        <a href="/dashboard ">
                            <button
                                class="px-3 py-2 rounded-sm mb-0.5
                                        inline-flex items-center px-4 py-2 bg-transparent dark:bg-transparent border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest  focus:text-green-700 dark:focus:text-green-500
                                        hover:text-indigo-500 dark:hover:text-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6 ">
                                    <path
                                        d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                    <path
                                        d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                                </svg>


                                <span
                                    class="ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    Dashboard </span>
                            </button>

                        </a>
                    </li>


                    <!-- Enlace a Comparativas -->
                    <li>
                        <a
                            href="https://lookerstudio.google.com/reporting/f66e042c-444b-40b7-b400-818521fb014d/page/p_mdru4yj0gd">
                            <button
                                class="px-3 py-2 rounded-sm mb-0.5
                                        inline-flex items-center px-4 py-2 bg-transparent dark:bg-transparent border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest  focus:text-green-700 dark:focus:text-green-500
                                        hover:text-indigo-500 dark:hover:text-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M2.25 2.25a.75.75 0 0 0 0 1.5H3v10.5a3 3 0 0 0 3 3h1.21l-1.172 3.513a.75.75 0 0 0 1.424.474l.329-.987h8.418l.33.987a.75.75 0 0 0 1.422-.474l-1.17-3.513H18a3 3 0 0 0 3-3V3.75h.75a.75.75 0 0 0 0-1.5H2.25Zm6.04 16.5.5-1.5h6.42l.5 1.5H8.29Zm7.46-12a.75.75 0 0 0-1.5 0v6a.75.75 0 0 0 1.5 0v-6Zm-3 2.25a.75.75 0 0 0-1.5 0v3.75a.75.75 0 0 0 1.5 0V9Zm-3 2.25a.75.75 0 0 0-1.5 0v1.5a.75.75 0 0 0 1.5 0v-1.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span
                                    class="ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    Comparativas </span>
                            </button>

                        </a>
                    </li>


                    <!-- Enlace a Mapas -->
                    <li>
                        <a href="/mapas">
                            <button
                                class="px-3 py-2 rounded-sm mb-0.5
                                        inline-flex items-center px-4 py-2 bg-transparent dark:bg-transparent border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest  focus:text-green-700 dark:focus:text-green-500
                                        hover:text-indigo-500 dark:hover:text-indigo-500">
                                <svg class="h-6 w-6 text-zinc-500" width="24" height="24" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <line x1="18" y1="6" x2="18" y2="6.01" />
                                    <path d="M18 13l-3.5 -5a4 4 0 1 1 7 0l-3.5 5" />
                                    <polyline points="10.5 4.75 9 4 3 7 3 20 9 17 15 20 21 17 21 15" />
                                    <line x1="9" y1="4" x2="9" y2="17" />
                                    <line x1="15" y1="15" x2="15" y2="20" />
                                </svg>
                                <span
                                    class="ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    Mapa </span>
                            </button>
                        </a>
                    </li>


                    @role('admin')
                        <!-- Tablas -->
                        <li class="px-4 py-2 ml-5 rounded-sm mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['users', 'registros'])) {{ 'bg-slate-100 dark:bg-slate-950' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['users', 'registros']) ? 1 : 0 }} }">
                            <a class="block dark:text-slate-200 text-slate-800 hover:text-indigo-500 dark:hover:text-indigo-500 truncate transition duration-150 @if (in_array(Request::segment(1), ['users'])) {{ 'hover:text-slate-200' }} @endif"
                                href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-6 h-6">
                                            <path
                                                d="M21 6.375c0 2.692-4.03 4.875-9 4.875S3 9.067 3 6.375 7.03 1.5 12 1.5s9 2.183 9 4.875Z" />
                                            <path
                                                d="M12 12.75c2.685 0 5.19-.586 7.078-1.609a8.283 8.283 0 0 0 1.897-1.384c.016.121.025.244.025.368C21 12.817 16.97 15 12 15s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.285 8.285 0 0 0 1.897 1.384C6.809 12.164 9.315 12.75 12 12.75Z" />
                                            <path
                                                d="M12 16.5c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 0 0 1.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 0 0 1.897 1.384C6.809 15.914 9.315 16.5 12 16.5Z" />
                                            <path
                                                d="M12 20.25c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 0 0 1.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 0 0 1.897 1.384C6.809 19.664 9.315 20.25 12 20.25Z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Registros</span>
                                    </div>
                                    <!-- Icon -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                            class="w-4 h-4">
                                            <path fill-rule="evenodd"
                                                d="M7.47 12.78a.75.75 0 0 0 1.06 0l3.25-3.25a.75.75 0 0 0-1.06-1.06L8 11.19 5.28 8.47a.75.75 0 0 0-1.06 1.06l3.25 3.25ZM4.22 4.53l3.25 3.25a.75.75 0 0 0 1.06 0l3.25-3.25a.75.75 0 0 0-1.06-1.06L8 6.19 5.28 3.47a.75.75 0 0 0-1.06 1.06Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-9 mt-1 @if (!in_array(Request::segment(1), ['dashboard'])) {{ 'hidden' }} @endif"
                                    :class="open ? '!block' : 'hidden'">
                                    <li class="mb-1 last:mb-0">
                                        <a class="block dark:text-slate-400 text-slate-500 dark:hover:text-indigo-400 hover:text-indigo-600 transition duration-150 truncate @if (Route::is('subir-registro')) {{ '!text-indigo-500' }} @endif"
                                            href="{{ route('subir-registro') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Subir
                                                registro</span>
                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block dark:text-slate-400 text-slate-500 dark:hover:text-indigo-400 hover:text-indigo-600 transition duration-150 truncate @if (Route::is('registros')) {{ '!text-indigo-500' }} @endif"
                                            href="{{ route('registros') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Registros</span>
                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block dark:text-slate-400 text-slate-500 dark:hover:text-indigo-400 hover:text-indigo-600 transition duration-150 truncate @if (Route::is('users')) {{ '!text-indigo-500' }} @endif"
                                            href="{{ route('users') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Usuarios</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endrole
                </ul>
            </div>
        </div>

        <!-- Botón de expandir/contraer barra lateral -->
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="px-3 py-2">
                <button @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                        <path class="text-slate-400"
                            d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                        <path class="text-slate-600" d="M3 23H1V1h2z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

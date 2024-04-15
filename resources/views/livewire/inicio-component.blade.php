<x-base-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Welcome banner -->
       

        <!-- Dashboard actions -->
        <div>

            <!-- Left: Avatars -->
            {{-- <x-dashboard.dashboard-avatars /> --}}

            <!-- Right: Actions -->
            {{-- <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Filter button -->
                <x-dropdown-filter align="right" />

                <!-- Datepicker built with flatpickr -->
                <x-datepicker />

                <!-- Add view button -->
                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Add View</span>
                </button>

            </div> --}}

        </div>



        <div class="flex items-center justify-center pb-5 py-5 ">
            @livewire('select-component')
        </div>


        {{-- @livewire('charts.grafico-pastel-accidentes') --}}


        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">

            @livewire('charts.barras-apiladas-tipo-victima-genero')

            @livewire('charts.grafico-pastel-accidentes')
            @livewire('charts.grafico-pastel-clases-accidentes')

            @livewire('charts.histograma-accidentes')
            @livewire('charts.diagrama-dispersión')

            @livewire('charts.grafico-burbujas-accidentes')
            @livewire('charts.grafico-barras-apiladas')

            @livewire('charts.dashboard-card04')

            <div class="col-span-12 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700 ">
                @livewire('mapas-component')

            </div>




            <!-- Line chart (Acme Plus) -->
            {{-- <x-dashboard.dashboard-card-01 :dataFeed="$dataFeed" /> --}}

            <!-- Line chart (Acme Advanced) -->
            {{-- <x-dashboard.dashboard-card-02 :dataFeed="$dataFeed" /> --}}

            <!-- Line chart (Acme Professional) -->
            {{-- <x-dashboard.dashboard-card-03 :dataFeed="$dataFeed" /> --}}

            <!-- Table (Top Channels) -->
            {{-- <x-dashboard.dashboard-card-07 /> --}}


            <!-- Line chart (Sales Over Time)  -->
            {{-- <x-dashboard.dashboard-card-08 /> --}}

            <!-- Stacked bar chart (Sales VS Refunds) -->
            {{-- <x-dashboard.dashboard-card-09 /> --}}

            <!-- Card (Customers)  -->
            {{-- <x-dashboard.dashboard-card-10 />

            <!-- Card (Reasons for Refunds)   -->
            <x-dashboard.dashboard-card-11 />

            <!-- Card (Recent Activity) -->
            <x-dashboard.dashboard-card-12 />

            <!-- Card (Income/Expenses) -->
            <x-dashboard.dashboard-card-13 /> --}}

        </div>




    </div>
</x-base-layout>

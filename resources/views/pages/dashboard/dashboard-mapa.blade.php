<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Welcome banner -->
        <x-dashboard.welcome-banner />


        <div class="flex items-center justify-center pb-5 py-5 ">
            @livewire('select-component')
        </div>



        @livewire('mapas-component')

    </div>
</x-app-layout>

<x-filament::page>
    <div class="space-y-6">
        <h1 class="text-2xl font-bold">Perfiles de Cargos</h1>

        @if ($unitId)
            <p class="text-gray-600">Mostrando perfiles de la unidad organizacional con ID: {{ $unitId }}</p>
        @else
            <p class="text-gray-600">Mostrando todos los perfiles de cargo.</p>
        @endif

        <!-- La tabla se generará automáticamente -->
        {{ $this->table() }}
    </div>
</x-filament::page>

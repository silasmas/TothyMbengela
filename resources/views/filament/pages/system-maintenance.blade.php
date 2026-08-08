<x-filament-panels::page>
    <div class="space-y-6">
        <x-filament::section>
            <x-slot name="heading">Anti-spam formulaires (déjà actif)</x-slot>
            <x-slot name="description">Contact + rendez-vous</x-slot>
            <ul class="list-disc ps-5 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                <li>Honeypot caché (<code>website_url</code>)</li>
                <li>Limite : 5 envois / 10 minutes (throttle)</li>
                <li>Filtre des sujets SEO / spam courants</li>
            </ul>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Migrations</x-slot>
            <x-slot name="description">
                {{ count($migrationStatus['pending']) }} en attente —
                {{ count($migrationStatus['ran']) }} déjà exécutées
                @if($migrationStatus['batch'])
                    (dernier lot #{{ $migrationStatus['batch'] }})
                @endif
            </x-slot>

            @if(count($migrationStatus['pending']) === 0)
                <p class="text-sm text-success-600 dark:text-success-400 font-medium">Aucune migration en attente.</p>
            @else
                <p class="text-sm font-medium mb-2 text-warning-600 dark:text-warning-400">En attente :</p>
                <ul class="text-sm font-mono space-y-1 max-h-48 overflow-y-auto">
                    @foreach($migrationStatus['pending'] as $migration)
                        <li>{{ $migration }}</li>
                    @endforeach
                </ul>
            @endif

            <details class="mt-4">
                <summary class="cursor-pointer text-sm font-medium">Voir les migrations déjà exécutées</summary>
                <ul class="mt-2 text-xs font-mono space-y-1 max-h-40 overflow-y-auto text-gray-500">
                    @foreach(array_reverse($migrationStatus['ran']) as $migration)
                        <li>{{ $migration }}</li>
                    @endforeach
                </ul>
            </details>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Lien storage</x-slot>
            <x-slot name="description">Nécessaire pour afficher les images uploadées (couvertures, slides…)</x-slot>

            @if($storageStatus['linked'])
                <p class="text-sm text-success-600 dark:text-success-400 font-medium">
                    Lien actif : <code>public/storage</code>
                    @if($storageStatus['target'])
                        → <code>{{ $storageStatus['target'] }}</code>
                    @endif
                </p>
            @else
                <p class="text-sm text-danger-600 dark:text-danger-400 font-medium mb-2">
                    Lien absent ou invalide
                    @if($storageStatus['target'])
                        ({{ $storageStatus['target'] }})
                    @endif
                </p>
                <div class="flex flex-wrap gap-2">
                    <x-filament::button wire:click="createStorageLink" color="success" icon="heroicon-o-link">
                        Activer storage:link
                    </x-filament::button>
                    <x-filament::button
                        wire:click="forceStorageLink"
                        wire:confirm="Cela remplacera le dossier public/storage existant par un lien. Continuer ?"
                        color="danger"
                        icon="heroicon-o-exclamation-triangle"
                    >
                        Forcer le lien storage
                    </x-filament::button>
                </div>
            @endif
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Seeders</x-slot>
            <x-slot name="description">Les seeders déjà lancés depuis cette page sont mémorisés. Vous pouvez relancer un seeder individuellement si besoin.</x-slot>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                            <th class="py-2 pe-3">Seeder</th>
                            <th class="py-2 pe-3">État</th>
                            <th class="py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seederStatus as $row)
                            <tr class="border-b border-gray-100 dark:border-gray-800" wire:key="seeder-{{ md5($row['class']) }}">
                                <td class="py-2 pe-3">
                                    <div class="font-medium">{{ $row['label'] }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ class_basename($row['class']) }}</div>
                                </td>
                                <td class="py-2 pe-3">
                                    @if($row['ran'])
                                        <span class="text-success-600 dark:text-success-400">Exécuté</span>
                                        @if($row['ran_at'])
                                            <div class="text-xs text-gray-500">{{ $row['ran_at'] }}</div>
                                        @endif
                                    @else
                                        <span class="text-warning-600 dark:text-warning-400">En attente</span>
                                    @endif
                                </td>
                                <td class="py-2">
                                    <x-filament::button
                                        size="sm"
                                        color="{{ $row['ran'] ? 'gray' : 'warning' }}"
                                        wire:click="runOneSeeder({{ \Illuminate\Support\Js::from($row['class']) }})"
                                        wire:confirm="Exécuter {{ $row['label'] }} ?"
                                    >
                                        {{ $row['ran'] ? 'Relancer' : 'Exécuter' }}
                                    </x-filament::button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>

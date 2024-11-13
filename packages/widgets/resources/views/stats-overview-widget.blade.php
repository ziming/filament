@php
    $columns = $this->getColumns();
    $hasHeading = $this->hasHeading();
    $hasDescription = $this->hasDescription();
@endphp

<x-filament-widgets::widget class="fi-wi-stats-overview">
    @if($hasHeading || $hasDescription)
        <div class="fi-wi-stats-overview-header grid flex-1 gap-y-1 mb-4">
            @if($hasHeading)
                <h3 class="fi-wi-stats-overview-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white col-span-full">
                    {{ $this->getHeading() }}
                </h3>
            @endif

            @if($hasDescription)
                <p class="fi-wi-stats-overview-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
                    {{ $this->getDescription() }}
                </p>
            @endif
        </div>
    @endif

    <div
        @if ($pollingInterval = $this->getPollingInterval())
            wire:poll.{{ $pollingInterval }}
        @endif
        @class([
            'fi-wi-stats-overview-stats-ctn grid gap-6',
            'md:grid-cols-1' => $columns === 1,
            'md:grid-cols-2' => $columns === 2,
            'md:grid-cols-3' => $columns === 3,
            'md:grid-cols-2 xl:grid-cols-4' => $columns === 4,
        ])
    >
        @foreach ($this->getCachedStats() as $stat)
            {{ $stat }}
        @endforeach
    </div>
</x-filament-widgets::widget>

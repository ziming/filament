<div {{ $attributes->merge($getExtraAttributes(), escape: false) }}>
    @if (filled($key = $getKey()))
        @livewire($getComponent(), $getComponentProperties(), key($key))
    @else
        @livewire($getComponent(), $getComponentProperties())
    @endif
</div>

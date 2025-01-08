<?php

namespace Filament\Forms\Components\Concerns;

use Closure;
use Illuminate\Support\Collection;

trait CanDisableOptions
{
    /**
     * @var array<bool|Closure>
     */
    protected array $isOptionDisabled = [];

    public function disableOptionWhen(bool | Closure $callback, bool $merge = false): static
    {
        if ($merge) {
            $this->isOptionDisabled[] = $callback;
        } else {
            $this->isOptionDisabled = [$callback];
        }

        return $this;
    }

    /**
     * @return array<string>
     */
    public function getEnabledOptions(): array
    {
        return collect($this->getOptions())
            ->reduce(function (Collection $carry, $label, $value): Collection {
                if (is_array($label)) {
                    return $carry->merge($label);
                }

                return $carry->put($value, $label);
            }, collect())
            ->filter(fn ($label, $value) => ! $this->isOptionDisabled($value, $label))
            ->all();
    }

    /**
     * @param  array-key  $value
     */
    public function isOptionDisabled($value, string $label): bool
    {
        return (bool) collect($this->isOptionDisabled)
            ->first(fn ($isOptionDisabled) => $this->evaluate($isOptionDisabled, [
                'label' => $label,
                'value' => $value,
            ]));
    }

    public function hasDynamicDisabledOptions(): bool
    {
        return (bool) collect($this->isOptionDisabled)
            ->first(fn ($isOptionDisabled) => $isOptionDisabled instanceof Closure);
    }
}

<?php

namespace Filament\Forms\Components\Concerns;

use Closure;
use Filament\Forms\Components\Component;

trait CanLimitItemsLength
{
    protected int | Closure | null $maxItems = null;

    protected int | Closure | null $minItems = null;

    public function maxItems(int | Closure | null $count): static
    {
        $this->maxItems = $count;

        $this->rule('array', static fn (Component $component): bool => $component->getMaxItems() !== null);
        $this->rule(static function (Component $component): string {
            /** @var static $component */
            $count = $component->getMaxItems();

            return "max:{$count}";
        }, static fn (Component $component): bool => $component->getMaxItems() !== null);

        return $this;
    }

    public function minItems(int | Closure | null $count): static
    {
        $this->minItems = $count;

        $this->rule('array', static fn (Component $component): bool => $component->getMinItems() !== null);
        $this->rule(static function (Component $component): string {
            /** @var static $component */
            $count = $component->getMinItems();

            return "min:{$count}";
        }, static fn (Component $component): bool => $component->getMinItems() !== null);

        return $this;
    }

    public function getMaxItems(): ?int
    {
        return $this->evaluate($this->maxItems);
    }

    public function getMinItems(): ?int
    {
        return $this->evaluate($this->minItems);
    }

    public function getItemsCount(): int
    {
        $state = $this->getState();

        return is_array($state) ? count($state) : 0;
    }
}

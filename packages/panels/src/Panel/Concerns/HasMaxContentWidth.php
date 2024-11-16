<?php

namespace Filament\Panel\Concerns;

use Filament\Support\Enums\MaxWidth;

trait HasMaxContentWidth
{
    protected MaxWidth | string | null $maxContentWidth = null;

    protected MaxWidth | string | null $simplePageMaxWidth = null;

    public function maxContentWidth(MaxWidth | string | null $maxContentWidth): static
    {
        $this->maxContentWidth = $maxContentWidth;

        return $this;
    }

    public function getMaxContentWidth(): MaxWidth | string | null
    {
        return $this->maxContentWidth;
    }

    public function simplePageMaxWidth(MaxWidth | string | null $width): static
    {
        $this->simplePageMaxWidth = $width;

        return $this;
    }

    public function getSimplePageMaxWidth(): MaxWidth | string | null
    {
        return $this->simplePageMaxWidth;
    }
}

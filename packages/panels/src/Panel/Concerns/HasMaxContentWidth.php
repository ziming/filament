<?php

namespace Filament\Panel\Concerns;

use Filament\Support\Enums\MaxWidth;

trait HasMaxContentWidth
{
    protected MaxWidth | string | null $maxContentWidth = null;

    protected MaxWidth | string | null $maxSimplePageContentWidth = null;

    public function maxContentWidth(MaxWidth | string | null $maxContentWidth): static
    {
        $this->maxContentWidth = $maxContentWidth;

        return $this;
    }

    public function getMaxContentWidth(): MaxWidth | string | null
    {
        return $this->maxContentWidth;
    }

    public function maxSimplePageContentWidth(MaxWidth | string | null $width): static
    {
        $this->maxSimplePageContentWidth = $width;

        return $this;
    }

    public function getMaxSimplePageContentWidth(): MaxWidth | string | null
    {
        return $this->maxSimplePageContentWidth;
    }
}

<?php

namespace App\Livewire\Panels\Navigation;

use Filament\Pages\Page;
use Filament\Navigation\NavigationItem;

class SortItems extends Page
{
    protected static string $view = 'livewire.panels.navigation.sort-item';

    public function mount()
    {
        filament()
            ->getCurrentPanel()
            ->navigationItems([
                NavigationItem::make()
                    ->label('Products (Sort = 2)')
                    ->sort(2)
                    ->icon('heroicon-o-document-text')
                    ->url(fn (): string => '#'),
                NavigationItem::make('')
                    ->label('Orders (Sort = 1)')
                    ->sort(1)
                    ->icon('heroicon-o-document-text')
                    ->url(fn (): string => '#'),
            ]);
    }
}

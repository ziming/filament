<?php

namespace App\Livewire\Panels\Navigation;

use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Page;

class GroupNotCollapsible extends Page
{
    protected static string $view = 'livewire.panels.navigation.group-not-collapsible';

    public function mount()
    {
        filament()
            ->getCurrentPanel()
            ->navigationGroups([
                NavigationGroup::make('Settings')->collapsible(false)
            ])
            ->navigationItems([
                NavigationItem::make()
                    ->label('Bank Accounts')
                    ->url(fn(): string => '#')
                    ->group('Settings')
                    ->icon('heroicon-o-currency-dollar'),
            ]);
    }
}

<?php

namespace Filament\Actions\Exports\Contracts;

use Filament\Actions\Exports\Downloaders\Contracts\Downloader;
use Filament\Actions\Exports\Models\Export;
use Filament\Notifications\Actions\Action as NotificationAction;

interface ExportEnum
{
    public function getDownloader(): Downloader;

    public function getDownloadNotificationAction(Export $export): NotificationAction;
}

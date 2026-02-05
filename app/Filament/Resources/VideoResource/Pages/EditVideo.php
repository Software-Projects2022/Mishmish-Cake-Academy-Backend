<?php

namespace App\Filament\Resources\VideoResource\Pages;

use App\Filament\Resources\VideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideo extends EditRecord
{
    protected static string $resource = VideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function () {
                    // Delete from GCS when deleting record
                    if ($this->record->path) {
                        app(\App\Services\GcsUploadService::class)->deleteFile($this->record->path);
                    }
                }),
        ];
    }
}

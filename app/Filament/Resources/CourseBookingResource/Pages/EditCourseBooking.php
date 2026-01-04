<?php

namespace App\Filament\Resources\CourseBookingResource\Pages;

use App\Filament\Resources\CourseBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseBooking extends EditRecord
{
    protected static string $resource = CourseBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

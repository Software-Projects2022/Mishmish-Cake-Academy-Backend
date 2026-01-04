<?php

namespace App\Filament\Resources\CourseBookingResource\Pages;

use App\Filament\Resources\CourseBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourseBookings extends ListRecords
{
    protected static string $resource = CourseBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

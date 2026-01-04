<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use App\Filament\Resources\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLessons extends ListRecords
{
    protected static string $resource = LessonResource::class;
    protected static ?string $breadcrumb = null;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        $courseId = request('record');
        $breadcrumbs = [
            url('/admin') => 'Home',
            CourseResource::getUrl('index') => 'Courses',
        ];

        if ($courseId) {
            $breadcrumbs[CourseResource::getUrl('edit', ['record' => $courseId])] = 'Edit Course';
        }

        $breadcrumbs[null] = 'Sections';

        return $breadcrumbs;
    }

}

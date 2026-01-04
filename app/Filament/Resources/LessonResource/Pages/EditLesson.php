<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\CourseResource;
use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLesson extends EditRecord
{
    protected static string $resource = LessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index', ['record' => $this->record->course_id]);
    }

    public function getBreadcrumbs(): array
    {
        $courseId = request('record');
        $breadcrumbs = [
            url('/admin') => 'Home',
            CourseResource::getUrl('index') => 'Courses',
            LessonResource::getUrl('index', ['record' => $courseId]) => 'Sections',
            null => 'Edit Section',
        ];

        return $breadcrumbs;
    }
}

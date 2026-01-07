<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\CourseResource;
use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;

    protected function getRedirectUrl(): string
    {

        // dd($this->record->course_id);
        return $this->getResource()::getUrl('index', ['record' => $this->record->course_id]);
    }

    public function getBreadcrumbs(): array
    {
        $courseId = request('record');
        $breadcrumbs = [
            url('/admin') => 'الرئيسية',
            CourseResource::getUrl('index') => 'الدورات',
            LessonResource::getUrl('index', ['record' => $courseId]) => 'الفصول',
            null => 'إنشاء الفصل',
        ];

        return $breadcrumbs;
    }

}

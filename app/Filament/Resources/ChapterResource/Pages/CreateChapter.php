<?php

namespace App\Filament\Resources\ChapterResource\Pages;

use App\Filament\Resources\ChapterResource;
use App\Filament\Resources\CourseResource;
use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateChapter extends CreateRecord
{
    protected static string $resource = ChapterResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index', ['record' => $this->record->lesson_id]);
    }


    public function getBreadcrumbs(): array
    {
        $lessonId = request('record');
        $breadcrumbs = [
            url('/admin') => 'الرئيسية',
            CourseResource::getUrl('index') => 'الدورات',
            LessonResource::getUrl('index', ['record' => $lessonId]) => 'المحاضرات',
            null => 'إنشاء المحاضرة',
        ];

        return $breadcrumbs;
    }



}

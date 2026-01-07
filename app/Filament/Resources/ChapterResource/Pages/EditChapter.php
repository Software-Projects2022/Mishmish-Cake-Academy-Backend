<?php

namespace App\Filament\Resources\ChapterResource\Pages;

use App\Filament\Resources\ChapterResource;
use App\Filament\Resources\CourseResource;
use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChapter extends EditRecord
{
    protected static string $resource = ChapterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }



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
            null => 'تعديل المحاضرة',
            ];

            return $breadcrumbs;
        }

    }


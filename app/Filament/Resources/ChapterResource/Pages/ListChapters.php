<?php

namespace App\Filament\Resources\ChapterResource\Pages;

use App\Filament\Resources\ChapterResource;
use App\Filament\Resources\CourseResource;
use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChapters extends ListRecords
{
    protected static string $resource = ChapterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
    public function getBreadcrumbs(): array
    {
        $lessonId = request('record');
        $breadcrumbs = [
            url('/admin') => 'الرئيسية',
            CourseResource::getUrl('index') => 'الدورات',
        ];

        if ($lessonId) {
            $breadcrumbs[LessonResource::getUrl('index', ['record' => $lessonId])] = 'المحاضرات';
        }

        $breadcrumbs[null] = 'المحاضرات';

        return $breadcrumbs;
    }


}

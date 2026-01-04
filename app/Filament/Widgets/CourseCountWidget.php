<?php

namespace App\Filament\Widgets;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CourseCountWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Courses', Course::count())
                ->description('All courses in the system')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),
                Stat::make('Total Sections', Lesson::count())
                ->description('All sections in the system')
                ->descriptionIcon('heroicon-m-list-bullet')
                ->color('success'),
                Stat::make('Total Lessons', Chapter::count())
                ->description('All lessons in the system')
                ->descriptionIcon('heroicon-m-list-bullet')
                ->color('success'),
               ];
    }
}


<?php

namespace App\Filament\Resources\VideoResource\Pages;

use App\Filament\Resources\VideoResource;
use Filament\Resources\Pages\Page;

class UploadVideo extends Page
{
    protected static string $resource = VideoResource::class;

    protected static string $view = 'filament.resources.video-resource.pages.upload-video';

    protected static ?string $title = 'رفع فيديو جديد';

    protected static ?string $breadcrumb = 'رفع فيديو';
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChapterResource\Pages;
use App\Filament\Resources\ChapterResource\RelationManagers;
use App\Models\Chapter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChapterResource extends Resource
{
    protected static ?string $model = Chapter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $breadcrumb = 'المحاضرات';
    protected static ?string $pluralModelLabel = 'المحاضرات';
    protected static ?string $modelLabel = 'المحاضرة';
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                ->required()
                ->label('العنوان')
                ->maxLength(255),
                Forms\Components\TextInput::make('duration')
                ->type('number')
                ->required()
                ->label('المدة')
                ->maxLength(255),

                Forms\Components\FileUpload::make('video_url')
                ->disk('bunnycdn')
                ->label('الفيديو')
                ->directory('courses/videos')
                ->acceptedFileTypes(['video/mp4']),

                // Forms\Components\TextInput::make('video_url_ar')
                // ->required()
                // ->label('Video Url Ar')
                // ->maxLength(255),
                Forms\Components\Hidden::make('lesson_id')
                ->default(fn () => request('record')),

                // Forms\Components\Select::make('lesson_id')
                // ->relationship('lesson', 'title')
                // ->required()


                // ->label('Lession'),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

        ->headerActions([
            // ONLY your custom button here
            Tables\Actions\Action::make('create_lesson')
                ->label('المحاضرة الجديدة')
                ->icon('heroicon-o-plus')
                ->url(fn () => route('filament.admin.resources.chapters.create', [
                    'record' => request('record')
                ])),
        ])

        ->modifyQueryUsing(function ($query) {
            $lessonId = request('record'); // from URL
            if ($lessonId) {
                $query->where('lesson_id', $lessonId);
            }
        })

            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->label('العنوان')
                ->searchable(),
                Tables\Columns\TextColumn::make('duration')
                ->label('المدة')
                ->searchable(),
                // Tables\Columns\TextColumn::make('lesson.title')
                // ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChapters::route('/'),
            'create' => Pages\CreateChapter::route('/create'),
            'edit' => Pages\EditChapter::route('/{record}/edit'),
        ];
    }
}

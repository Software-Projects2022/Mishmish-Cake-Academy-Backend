<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $breadcrumb = 'الفصول';
    protected static ?string $pluralModelLabel = 'الفصول';
    protected static ?string $modelLabel = 'الفصل';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('course_id')
                ->default(fn () => request('record')),

                Forms\Components\TextInput::make('title')
                ->required()
                ->label('العنوان')
                ->maxLength(255),
                // Forms\Components\TextInput::make('title_ar')
                // ->required()
                // ->label('Title Ar')
                // ->maxLength(255),


                Forms\Components\ColorPicker::make('color')
                ->required()
                ->label('اللون')
                ->default('#000000'),


                Forms\Components\FileUpload::make('icon')
                ->required()
                ->image()
                ->label('الأيقونة'),
                // Forms\Components\TextInput::make('duration')
                // ->required()
                // ->label('Duration')
                // ->maxLength(255),

                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->headerActions([
            // ONLY your custom button here
            Tables\Actions\Action::make('create_section')
                ->label('الفصل الجديد')
                ->icon('heroicon-o-plus')
                ->url(fn () => route('filament.admin.resources.lessons.create', [
                    'record' => request('record')
                ])),
        ])

        ->modifyQueryUsing(function ($query) {
            $courseId = request('record'); // from URL
            if ($courseId) {
                $query->where('course_id', $courseId);
            }
        })

            ->columns([
                //
                Tables\Columns\TextColumn::make( 'title')
                ->label('العنوان')
                ->searchable()
                // ->formatStateUsing(fn ($state) => substr($state, 0, 20))
                ,
                // Tables\Columns\TextColumn::make('duration')
                // ->searchable()
                // ,
                // Tables\Columns\TextColumn::make('course.title')
                // ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make('chapters')
                    ->url(fn (Lesson $record) => route(
                        'filament.admin.resources.chapters.index',
                        ['record' => $record->id]
                    ))
                    ->label('المحاضرات')
                    ->icon('heroicon-o-list-bullet'),
                ])
                ->label('الإجراءات')
                ->icon(null),
            ])->heading('Actions')
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
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}

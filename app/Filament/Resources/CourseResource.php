<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //



                Forms\Components\Select::make('course_category_id')
                    ->relationship('courseCategory', 'title')
                    ->required()
                    ->label('Category'),

                Forms\Components\Select::make('instructor_id')
                    ->relationship('instructor', 'name')
                        ->default(fn () => \App\Models\Instructor::first()?->id)

                    ->required()

                    ->label('Instructor'),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('Title')
                    ->maxLength(255),
                // Forms\Components\TextInput::make('title_ar')
                //     ->required()
                //     ->label('Title Ar')
                //     ->maxLength(255),
                Forms\Components\Textarea::make('short_description')
                    ->required()
                    ->label('Short Description')
                    ->maxLength(255),
                // Forms\Components\Textarea::make('short_description_ar')
                //     ->required()
                //     ->label('Short Description Ar')
                //     ->maxLength(255),

                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->columnSpan('full')
                    ->label('Description'),
                // Forms\Components\RichEditor::make('description_ar')
                //     ->required()
                //     ->label('Description Ar'),

                // Forms\Components\TextInput::make('course_duration')
                //     ->required()
                //     ->label('Course Duration')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('course_duration_ar')
                //     ->required()
                //     ->label('Course Duration Ar')
                //     ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->label('Price')
                    ->maxLength(255),
                Forms\Components\TextInput::make('price_after_discount')
                    ->required()
                    ->label('Price After Discount')
                    ->maxLength(255),

                // Forms\Components\TextInput::make('discount_start_date')
                //     ->required()
                //     ->label('Discount Start Date')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('discount_end_date')
                //     ->required()
                //     ->label('Discount End Date')
                //     ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->label('Course Image')
                    ->image()
                    ->directory('courses')
                    ->nullable(),

                Forms\Components\FileUpload::make('video')
                    ->label('Course Video')
                    ->disk('public')
                    ->previewable(true)
                    ->acceptedFileTypes(['video/*'])
                    ->directory('courses/videos')
                    ->nullable()
                    ->maxSize(5120), // 5MB max


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->searchable(),
                Tables\Columns\TextColumn::make('title')
                ->searchable(),
                // Tables\Columns\TextColumn::make('duration')
                // ->searchable(),
                Tables\Columns\TextColumn::make('price')
                ->searchable(),

                    // Tables\Columns\TextColumn::make('actions_label')
                    //     ->label('Actions')
                    //     ->formatStateUsing(fn () => '')
                    //     ->html(),
                                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make('chapters')
                        ->label('Sections')
                        ->icon('heroicon-o-list-bullet')
                        ->url(fn (Course $record) => route(
                            'filament.admin.resources.lessons.index',
                            ['record' => $record->id]
                        )),
                ])
                    ->label('Actions')   // show label
                    ->icon(null),        // REMOVE icon so label becomes visible
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}

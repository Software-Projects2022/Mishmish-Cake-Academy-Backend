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
    protected static ?string $navigationLabel = 'الدورات';
    protected static ?string $pluralModelLabel = 'الدورات';
    protected static ?string $modelLabel = 'الدورات';
    protected static ?string $breadcrumb = 'الدورات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //



                Forms\Components\Select::make('course_category_id')
                    ->relationship('courseCategory', 'title')
                    ->required()
                    ->label('فئة الدورات'),

                Forms\Components\Select::make('instructor_id')
                    ->relationship('instructor', 'name')
                        ->default(fn () => \App\Models\Instructor::first()?->id)

                    ->required()

                    ->label('المدرب'),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('العنوان')
                    ->maxLength(255),
                // Forms\Components\TextInput::make('title_ar')
                //     ->required()
                //     ->label('Title Ar')
                //     ->maxLength(255),
                Forms\Components\Textarea::make('short_description')
                    ->required()
                    ->label('الوصف القصير')
                    ->maxLength(255),
                // Forms\Components\Textarea::make('short_description_ar')
                //     ->required()
                //     ->label('Short Description Ar')
                //     ->maxLength(255),

                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->columnSpan('full')
                    ->label('الوصف'),
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
                    ->label('السعر')
                    ->maxLength(255),
                Forms\Components\TextInput::make('price_after_discount')
                    ->required()
                    ->label('السعر بعد الخصم')
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
                    ->label('صورة الدورة')
                    ->image()
                    ->directory('courses')
                    ->nullable(),

                Forms\Components\FileUpload::make('video')
                    ->label('فيديو الدورة')
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
                ->label('العنوان')
                ->searchable(),
                // Tables\Columns\TextColumn::make('duration')
                // ->searchable(),
                Tables\Columns\TextColumn::make('price')
                ->label('السعر')
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
                        ->label('الفصول')
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

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstructorResource\Pages;
use App\Filament\Resources\InstructorResource\RelationManagers;
use App\Models\Instructor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InstructorResource extends Resource
{
    protected static ?string $model = Instructor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'المدربين';
    protected static ?string $pluralModelLabel = 'المدربين';
    protected static ?string $modelLabel = 'المدرب';
    protected static ?string $breadcrumb = 'المدربين';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('الاسم')
                    ->maxLength(255),
                // Forms\Components\TextInput::make('name_ar')
                //     ->required()
                //     ->label('Name Ar')
                //     ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('العنوان')
                    ->maxLength(255),
                // Forms\Components\TextInput::make('title_ar')
                //     ->required()
                //     ->label('Title Ar')
                //     ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    // ->required()
                    ->label('الصورة')
                    ->image(),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->label('الوصف')
                    ->maxLength(255),
                // Forms\Components\TextInput::make('description_ar')
                //     ->required()
                //     ->label('Description Ar')
                //     ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم'),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان'),
                Tables\Columns\ImageColumn::make('image')
                    ->label('الصورة'),
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
            'index' => Pages\ListInstructors::route('/'),
            'create' => Pages\CreateInstructor::route('/create'),
            'edit' => Pages\EditInstructor::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'سلايدر';
    protected static ?string $pluralModelLabel = 'سلايدر';
    protected static ?string $modelLabel = 'سلايدر';
    protected static ?string $breadcrumb = 'سلايدر';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('العنوان')
                    ->maxLength(255),
                Forms\Components\TextInput::make('subtitle')
                    ->required()
                    ->label('محتوي')
                    ->maxLength(255),
                // Forms\Components\TextInput::make('title_ar')
                //     ->required()
                //     ->label('Title Ar')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('subtitle_ar')
                //     ->required()
                //     ->label('Subtitle Ar')
                //     ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->required()
                    ->label('الصورة')
                    ->image(),
                Forms\Components\TextInput::make('button_url')
                    ->required()
                    ->label('رابط الزر')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان'),
                Tables\Columns\TextColumn::make('subtitle')
                    ->label('المحتوي'),
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}

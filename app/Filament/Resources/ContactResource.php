<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Contact Settings';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->label('Email')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->required()
                    ->label('Phone')
                    ->maxLength(255),
                Forms\Components\Textarea::make('address')
                    ->required()
                    ->columnSpanFull()
                    ->label('Address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('facebook')
                    ->label('Facebook Url')
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('instagram')
                    ->label('Instagram Url')
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pinterest')
                    ->label('Pinterest Url')
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('vimeo')
                    ->label('Vimeo Url')
                    ->url()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
    public static function getNavigationUrl(): string
{
    $contact = \App\Models\Contact::first();

    return static::getUrl('edit', [
        'record' => $contact?->id ?? 1,
    ]);
}

}

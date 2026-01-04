<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseBookingResource\Pages;
use App\Filament\Resources\CourseBookingResource\RelationManagers;
use App\Models\Client;
use App\Models\Course;
use App\Models\CourseBooking;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseBookingResource extends Resource
{
    protected static ?string $model = CourseBooking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->required(),
                Forms\Components\Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'قيد الإنتظار',
                        'approved' => 'موافق',
                        'rejected' => 'ملغي',
                    ])
                    ->required(),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('client.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-m-Y H:i')
                    ->searchable(),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('client_id')
                    ->options(Client::all()->pluck('name', 'id')) ->searchable(),
                Tables\Filters\SelectFilter::make('course_id')
                    ->options(Course::all()->pluck('title', 'id')) ->searchable(),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'قيد الإنتظار',
                        'approved' => 'موافق',
                        'rejected' => 'ملغي',
                    ]) ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('Approve')
                        ->label('موافق')
                        ->color('success')
                        ->action(function (CourseBooking $record) {
                            $record->status = 'approved';
                            $record->save();
                        }),
                    Tables\Actions\Action::make('Reject')
                        ->label('ملغي')
                        ->color('danger')
                        ->action(function (CourseBooking $record) {
                            $record->status = 'rejected';
                            $record->save();
                        }),
                    Tables\Actions\Action::make('Pending')
                        ->label('معلق')
                        ->color('warning')
                        ->action(function (CourseBooking $record) {
                            $record->status = 'pending';
                            $record->save();
                        }),
                ])->label('Actions'),
                // Tables\Actions\Action::make('Approve')
                //     ->label('موافق')
                //     ->color('success')
                //     ->action(function (CourseBooking $record) {
                //         $record->status = 'approved';
                //         $record->save();
                //     }),
                // Tables\Actions\Action::make('reject')
                //     ->label('ملغي')
                //     ->color('danger')
                //     ->action(function (CourseBooking $record) {
                //         $record->status = 'rejected';
                //         $record->save();
                //     }),
                // Tables\Actions\Action::make('pending')
                //     ->label('معلق')
                //     ->color('warning')
                //     ->action(function (CourseBooking $record) {
                //         $record->status = 'pending';
                //         $record->save();
                //     }),
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
            'index' => Pages\ListCourseBookings::route('/'),
            'create' => Pages\CreateCourseBooking::route('/create'),
            'edit' => Pages\EditCourseBooking::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
{
    return false;
}

}

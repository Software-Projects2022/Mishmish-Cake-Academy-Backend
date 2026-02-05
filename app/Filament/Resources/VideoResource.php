<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static ?string $navigationLabel = 'الفيديوهات';
    protected static ?string $pluralModelLabel = 'الفيديوهات';
    protected static ?string $modelLabel = 'فيديو';
    protected static ?string $breadcrumb = 'الفيديوهات';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('اسم الفيديو')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('original_name')
                    ->label('اسم الملف الأصلي')
                    ->disabled(),

                Forms\Components\TextInput::make('url')
                    ->label('رابط الفيديو')
                    ->disabled()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('formatted_size')
                    ->label('حجم الملف')
                    ->disabled(),

                Forms\Components\TextInput::make('formatted_duration')
                    ->label('مدة الفيديو')
                    ->disabled(),

                Forms\Components\Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'uploading' => 'جاري الرفع',
                        'completed' => 'مكتمل',
                        'failed' => 'فشل',
                    ])
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('اسم الفيديو')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('formatted_size')
                    ->label('الحجم'),

                Tables\Columns\TextColumn::make('formatted_duration')
                    ->label('المدة'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'uploading',
                        'success' => 'completed',
                        'danger' => 'failed',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'قيد الانتظار',
                        'uploading' => 'جاري الرفع',
                        'completed' => 'مكتمل',
                        'failed' => 'فشل',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('chapters_count')
                    ->label('مستخدم في')
                    ->counts('chapters')
                    ->suffix(' محاضرة'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الرفع')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'uploading' => 'جاري الرفع',
                        'completed' => 'مكتمل',
                        'failed' => 'فشل',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Video $record) {
                        // Delete from GCS when deleting record
                        if ($record->path) {
                            app(\App\Services\GcsUploadService::class)->deleteFile($record->path);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideos::route('/'),
            'upload' => Pages\UploadVideo::route('/upload'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}

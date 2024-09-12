<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogResource\Pages;
use App\Models\Parameters\Log;
use App\Models\Parameters\LogModule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LogResource extends Resource
{
    protected static ?string $model = Log::class;

    protected static ?string $navigationIcon = 'heroicon-o-bug-ant';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->getOptionLabelFromRecordUsing(fn (Model $record): string => explode(' ', $record->name)[0]." {$record->fathers_family} {$record->mothers_family}")
                    ->default(null)
                    ->searchable(),
                Forms\Components\Select::make('log_module_id')
                    ->relationship('logModule', 'name')
                    ->default(null),
                Forms\Components\TextInput::make('record_datetime')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                // Forms\Components\TextInput::make('module')
                //     ->maxLength(255)
                //     ->default(null),
                Forms\Components\TextInput::make('uri')
                    ->maxLength(255)
                    ->default(null)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('formatted')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('context')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                // Forms\Components\TextInput::make('level')
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('level_name')
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('channel')
                //     ->required()
                //     ->maxLength(255),
                Forms\Components\Textarea::make('extra')
                    ->required()
                    ->columnSpanFull(),
                // Forms\Components\TextInput::make('remote_addr')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('user_agent')
                //     ->maxLength(255)
                //     ->default(null)
                //     ->columnSpan(2),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('record_datetime')
                    ->searchable(),
                Tables\Columns\TextColumn::make('logModule.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('module')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('message')
                    ->searchable()
                    ->wrap(),
                // Tables\Columns\TextColumn::make('uri')
                //     ->searchable()
                //     ->limit(40),
                // Tables\Columns\TextColumn::make('level')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('level_name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('channel')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('remote_addr')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('user_agent')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('log_module_id')
                    ->label('Módulo')
                    ->options(LogModule::orderBy('name')->pluck('name', 'id')->all()),
                Filter::make('no_log_module')
                    ->label('Sin Módulo')
                    ->query(fn (Builder $query) => $query->whereNull('log_module_id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLogs::route('/'),
            'create' => Pages\CreateLog::route('/create'),
            // 'edit' => Pages\EditLog::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            LogResource\Widgets\LogsByModuleChart::class,
            LogResource\Widgets\TopLogsByModuleWidget::class,
        ];
    }
}

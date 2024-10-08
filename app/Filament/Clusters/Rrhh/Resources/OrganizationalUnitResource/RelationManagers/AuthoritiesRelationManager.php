<?php

namespace App\Filament\Clusters\Rrhh\Resources\OrganizationalUnitResource\RelationManagers;

use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Rrhh\Authority;

class AuthoritiesRelationManager extends RelationManager
{
    protected static string $relationship = 'authorities';

    protected static ?string $title = 'Autoridades';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->options($this->getOwnerRecord()->managers->pluck('full_name','id'))
                    ->label('Usuario')
                    ->required(),
                Forms\Components\TextInput::make('position')
                    ->maxLength(255)
                    ->translateLabel()
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->format('Y-m-d')
                    ->translateLabel()
                    ->required(),
                Forms\Components\DatePicker::make('until')
                    ->format('Y-m-d')
                    ->translateLabel()
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'manager' => 'Jefetura',
                        'delegate' => 'Delegado/a',
                        'secretary' => 'Secretario/a',
                    ])
                    ->hiddenOn('edit')
                    ->required()
                    ->default(null),
                Forms\Components\TextInput::make('decree')
                    ->maxLength(255)
                    ->translateLabel()
                    ->default(null),
                Forms\Components\Select::make('representation_id')
                    ->options($this->getOwnerRecord()->managers->pluck('full_name','id'))
                    ->translateLabel()
                    ->default(null)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('date')
                        ->date('Y-m-d')
                        ->sortable(),
                    Tables\Columns\TextColumn::make('user.short_name')
                        ->numeric()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('position')
                        ->searchable(),
                ])
            ])
            ->recordClasses(fn ($record) => $record->date->isToday() ? 'border-2 border-primary-600' : '')
            ->contentGrid([
                'md' => 7,
                'xl' => 7,
            ])
            ->filters([
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\TextInput::make('date')
                            ->type('month')
                            ->default(Carbon::now()->startOfMonth()->format('Y-m')),
                    ])
                    ->query(function (Builder $query, array $data) {
                        $startOfMonth = Carbon::parse($data['date'])->startOfMonth();
                        $endOfMonth   = Carbon::parse($data['date'])->endOfMonth();
                        $startOfMonth->subDays($startOfMonth->dayOfWeek  - 1);
                        $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
                    }),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'manager' => 'Jefetura',
                        'delegate' => 'Delegado/a',
                        'secretary' => 'Secretario/a',
                    ])
                    ->default('manager'),

            ], layout: FiltersLayout::AboveContent)
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->using(function (array $data, string $model): Authority {
                        $startDate = Carbon::createFromFormat('Y-m-d', $data['date']);
                        $endDate = Carbon::createFromFormat('Y-m-d', $data['until']);
                        $authorities = [];
                
                        while ($startDate->lte($endDate)) {
                            $authorities[] = [
                                'date' => $startDate->toDateString(),
                                'organizational_unit_id' => $this->getOwnerRecord()->id,
                                'type' => $data['type'],
                                'user_id' => $data['user_id'],
                                'position' => $data['position'],
                                'decree' => $data['decree'],
                                'representation_id' => $data['representation_id'],
                            ];
                            $startDate->addDay();
                        }

                        Authority::upsert(
                            $authorities,
                            ['date','organizational_unit_id','type'],
                            ['user_id','position','decree','representation_id']
                        );
                        $record = Authority::where('date',$authorities[0]['date'])
                            ->where('organizational_unit_id',$authorities[0]['organizational_unit_id'])
                            ->where('type',$authorities[0]['type'])->first();
                        return $record;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->using(function (Authority $record, array $data): Authority {
                        $startDate = Carbon::createFromFormat('Y-m-d', $data['date']);
                        $endDate = Carbon::createFromFormat('Y-m-d', $data['until']);
                        $authorities = [];
                        while ($startDate->lte($endDate)) {
                            $authorities[] = [
                                'date' => $startDate->toDateString(),
                                'organizational_unit_id' => $record->organizational_unit_id,
                                'type' => $record->type,
                                'user_id' => $data['user_id'],
                                'position' => $data['position'],
                                'decree' => $data['decree'],
                                'representation_id' => $data['representation_id'],
                            ];
                            $startDate->addDay();
                        }
                        Authority::upsert(
                            $authorities,
                            ['date','organizational_unit_id','type'],
                            ['user_id','position','decree','representation_id']
                        );
                        return $record;
                    }),
            ])
            ->bulkActions([

            ])
            ->paginated(false);
    }
}

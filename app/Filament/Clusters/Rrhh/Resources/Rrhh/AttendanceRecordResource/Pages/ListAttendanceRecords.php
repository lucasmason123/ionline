<?php

namespace App\Filament\Clusters\Rrhh\Resources\Rrhh\AttendanceRecordResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\Rrhh\AttendanceRecordResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListAttendanceRecords extends ListRecords
{
    protected static string $resource = AttendanceRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs['mis registros'] = Tab::make()
            ->modifyQueryUsing(callback: fn (Builder $query): Builder => $query->where(column: 'user_id', operator: auth()->id()));

        if (auth()->user()->can(abilities: 'be god')) {
            $tabs['todos'] = Tab::make();
        }
        return $tabs;
    }
}

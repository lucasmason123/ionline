<?php

namespace App\Filament\Clusters\Rrhh\Resources\AttendanceRecordResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\AttendanceRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttendanceRecord extends EditRecord
{
    protected static string $resource = AttendanceRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

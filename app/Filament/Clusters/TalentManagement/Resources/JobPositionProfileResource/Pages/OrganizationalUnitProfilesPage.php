<?php

namespace App\Filament\Clusters\TalentManagement\Resources\JobPositionProfileResource\Pages;

use Filament\Resources\Pages\Page;
use Filament\Tables;
use App\Models\JobPositionProfiles\JobPositionProfile;

class OrganizationalUnitProfilesPage extends Page
{
    protected static string $view = 'filament.clusters.talent-management.resources.job-position-profile-resource.pages.organizational-unit-profiles-page';

    public $unitId;

    public function mount($unitId = null)
    {
        $this->unitId = $unitId;
    }

    public function getProfiles()
    {
        return JobPositionProfile::query()
            ->when($this->unitId, function ($query) {
                $query->where('organizational_unit_id', $this->unitId);
            })
            ->with(['organizationalUnit', 'user'])
            ->get();
    }

    public function table(): Tables\Table
    {
        return Tables\Table::make()  
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre de Perfil de Cargo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('organizationalUnit.name')
                    ->label('Unidad Organizacional')
                    ->sortable()
                    ->searchable(),
            ])
            ->rows($this->getProfiles())  
            ->emptyState('No se encontraron perfiles.');  
    }
}

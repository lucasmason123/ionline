<?php

namespace App\Livewire\Parameters;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Parameters\Log;

class LogStatistics extends Component
{
    public function render()
    {
        // Realiza la eliminación de registros superiores a un mes
        Log::where('created_at', '<', now()->subMonth())->delete();

        Log::whereNull('log_module_id')->get()->each->classify();

        // Obtener la cantidad de logs agrupados por la relación logModule
        $logsByModule = Log::with('logModule')
            ->select('log_module_id', \DB::raw('count(*) as count'))
            ->groupBy('log_module_id')
            ->orderByDesc('count')
            ->get();

        // Extraer los nombres de los módulos y las cantidades de logs
        $labels = $logsByModule->map(function ($log) {
            return $log->logModule ? $log->logModule->name : 'Sin módulo'; // Si no hay módulo, colocar "Sin módulo"
        })->toArray();

        $data = $logsByModule->pluck('count')->toArray();

        $group = [
            'datasets' => [
                [
                    'label'           => 'Logs por Módulo',
                    'data'            => $data, // Cantidad de logs por módulo
                ],
            ],
            'labels' => $labels, // Nombres de los módulos
        ];

        $logsByDay = Log::selectRaw('DATE(created_at) as log_date, COUNT(*) as log_count')
            ->groupBy('log_date')
            ->get();
        
        $logsChart = null;
        foreach($logsByDay as $day) {
            $logsChart .= "['{$day->log_date}',{$day->log_count}],";
        }
    
        return view('livewire.parameters.log-statistics', [
            'group' => $group,
            'logsChart' => $logsChart,
        ]);
    }
}

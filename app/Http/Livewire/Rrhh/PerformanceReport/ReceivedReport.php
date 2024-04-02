<?php

namespace App\Http\Livewire\Rrhh\PerformanceReport;

use Livewire\Component;
use App\Models\Rrhh\PerformanceReport;

class ReceivedReport extends Component
{
    public $performanceReports;

    public function mount()
    {        
        $this->performanceReports = PerformanceReport::where('received_user_id', auth()->user()->id)->get();

        foreach ($this->performanceReports as $report) {
            $latestApproval = $report->approvals()->where('sent_to_user_id', auth()->user()->id)
                ->whereNotNull('status')
                ->latest()
                ->first();            
            
            $report->latest_approval_date = $latestApproval ? $latestApproval->approver_at : null;
        }
    }
    public function render()
    {
        return view('livewire.rrhh.performance-report.received-report');
    }
}

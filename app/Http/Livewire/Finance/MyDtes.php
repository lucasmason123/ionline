<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\Dte;
use Livewire\Component;

class MyDtes extends Component
{
    public function render()
    {
        // Eloquent query donde Dte tenga un RequestForm y el RequestForm tenga un ContractManager y ese ContractManager sea el usuario autenticado


        $dtes = Dte::with([
                'purchaseOrder',
                'purchaseOrder.receptions',
                'purchaseOrder.rejections',
                'establishment',
                'controls',
                'requestForm',
                'requestForm.contractManager',
                'dtes',
                'invoices',
                'receptions',
                'contractManager'
            ])
            ->whereRelation('requestForm.contractManager', 'id', auth()->id())
            ->orWhere('contract_manager_id', auth()->id())
            ->whereNull('rejected')
            ->orderByDesc('fecha_recepcion_sii')
            ->paginate(50);

        return view('livewire.finance.my-dtes', compact('dtes'));
    }
}

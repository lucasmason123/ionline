<?php

namespace App\Http\Livewire\Allowances;

use Livewire\Component;

use App\Models\Allowances\AllowanceCorrection;
use App\Models\Allowances\Allowance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShowSummary extends Component
{
    public $allowance;

    public $editForm = null;

    public $editDisabled = null;

    public $totalDays, $totalDaysValue, 
    $fiftyPercentTotalDays, $fiftyPercentTotalDaysValue,
    $sixtyPercentTotalDays, $sixtyPercentTotalDaysValue;

    public $totalSummaryDays, $totalEditSummaryDays, $totalEditSummaryDaysValue;

    public $summaryDaysErrorMessage = null, $correctionMessage = null;

    public $reason;

    protected function messages(){
        return [
            'reason.required'   => 'Debe ingresar un motivo de modificación de valores de Viático.'
        ];
    }


    public function render()
    {
        return view('livewire.allowances.show-summary');
    }

    public function mount($allowance){
        if(!is_null($allowance)){
            $this->setSummary();
        }
    }

    // RESUMEN DESDE $allowance
    public function totalSummaryDays(){
        $this->totalSummaryDays = $this->allowance->total_days + $this->allowance->fifty_percent_total_days + $this->allowance->sixty_percent_total_days;
        $this->totalEditSummaryDaysValue = $this->totalDaysValue + $this->halfDayValue + $this->fiftyPercentTotalDaysValue + $this->sixtyPercentTotalDaysValue;
    }

    public function totalEditSummaryDays(){
        $this->totalEditSummaryDays = $this->totalDays + $this->fiftyPercentTotalDays + $this->sixtyPercentTotalDays;
        $this->totalEditSummaryDaysValue = $this->totalDaysValue + $this->halfDayValue + $this->fiftyPercentTotalDaysValue + $this->sixtyPercentTotalDaysValue;
    }

    public function editForm($action){
        if($action == 'edit'){
            $this->editForm     = 'edit';
            $this->editDisabled = 'disabled';
            $this->setSummary();
            $this->totalEditSummaryDays();
        }
        
        if($action == 'cancel'){
            $this->editForm = null;
            $this->editDisabled = null;
        }

    }

    public function setSummary(){
        $this->totalDays                = intval($this->allowance->total_days);
        $this->fiftyPercentTotalDays    = intval($this->allowance->fifty_percent_total_days);
        $this->sixtyPercentTotalDays    = intval($this->allowance->sixty_percent_total_days);

        $this->totalDaysValue = $this->allowance->allowanceValue->value * $this->totalDays;
        $this->halfDayValue = $this->allowance->half_day_value;
        $this->fiftyPercentTotalDaysValue = $this->allowance->fifty_percent_day_value * $this->fiftyPercentTotalDays;
        $this->sixtyPercentTotalDaysValue = $this->allowance->sixty_percent_day_value * $this->sixtyPercentTotalDays;

        $this->totalSummaryDays();
    }

    public function updatedTotalDays($value){
        $this->totalDays = $value;
        $this->totalDaysValue = $this->allowance->allowanceValue->value * $this->totalDays;
        $this->totalEditSummaryDays();
    }

    public function updatedFiftyPercentTotalDays($value){
        $this->fiftyPercentTotalDays = $value;
        $this->fiftyPercentTotalDaysValue = $this->allowance->fifty_percent_day_value * $this->fiftyPercentTotalDays;
        $this->totalEditSummaryDays();
    }

    public function updatedSixtyPercentTotalDays($value){
        $this->sixtyPercentTotalDays = $value;
        $this->sixtyPercentTotalDaysValue = $this->allowance->sixty_percent_day_value * $this->sixtyPercentTotalDays;
        $this->totalEditSummaryDays();
    }

    public function saveEditSummary(){
        if($this->totalSummaryDays == $this->totalEditSummaryDays){
            $validatedData = $this->validate([
                'reason'                  => 'required'
            ]);
            
            $this->allowance->total_days                  = ($this->totalDays == $this->allowance->total_days) ? $this->allowance->total_days : $this->totalDays ;
            $this->allowance->fifty_percent_total_days    = ($this->fiftyPercentTotalDays == $this->allowance->fifty_percent_total_days) ? $this->allowance->fifty_percent_total_days : $this->fiftyPercentTotalDays;
            $this->allowance->sixty_percent_total_days    = ($this->sixtyPercentTotalDays == $this->allowance->sixty_percent_total_days) ? $this->allowance->sixty_percent_total_days : $this->sixtyPercentTotalDays;
            $this->allowance->day_value                   = $this->allowance->allowanceValue->value;
            $this->allowance->fifty_percent_day_value     = ($this->fiftyPercentTotalDaysValue == 0) ? $this->allowance->fifty_percent_day_value : $this->fiftyPercentTotalDaysValue;
            $this->allowance->sixty_percent_day_value     = ($this->sixtyPercentTotalDaysValue == 0 || $this->sixtyPercentTotalDaysValue == 1) ? $this->allowance->sixty_percent_day_value : $this->sixtyPercentTotalDaysValue;
            $this->allowance->total_value                 = $this->totalEditSummaryDaysValue;
            $this->allowance->save();

            $correction                 = new AllowanceCorrection();
            $correction->reason         = $this->reason;
            $correction->allowance_id   = $this->allowance->id;
            $correction->user_id        = auth()->id();
            $correction->save();

            $this->editForm = null;
            $this->editDisabled = null;

            $this->correctionMessage = 'Estimado Usuario: El viático se ha modificado correctamente.';

            /*
            dd($this->allowance->getChanges());

            if ($this->allowance->wasChanged()) {
                return redirect()->back()->with('success', 'Estimado Usuario: El viático se ha modificado correctamente.');
            }
            else{
                $this->correctionErrorMessage = 'Estimado Usuario, para guardar el registro es necesario modificar el viático';
            }
            */
        }
        else{
            $this->summaryDaysErrorMessage = 'Estimado Usuario, existe una diferencia entre los dias indicados en Viático y la edición';
        }
        
    }
}

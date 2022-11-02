@extends('layouts.app')

@section('title', 'Viáticos')

@section('content')

@include('allowances.partials.nav')

<h5><i class="fas fa-file"></i> Editar solicitud de Viático ID:{{ $allowance->id }}</h5>

<br>

<form method="POST" class="form-horizontal" action="{{ route('allowances.update', $allowance) }}" enctype="multipart/form-data"/>
    @csrf
    @method('PUT')

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-6">
            <label for="for_user_allowance_id">Funcionario:</label>
            @livewire('search-select-user', [
                'selected_id' => 'user_allowance_id',
                'required'    => 'required',
                'user'        => $allowance->userAllowance
            ])
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_profile_search">Calidad</label>
            <select name="contractual_condition" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="to hire" {{ ($allowance->contractual_condition == 'to hire')?'selected':'' }}>Contrata</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_allowance_value_id">Grado</label>
            <select name="allowance_value_id" class="form-control" required>
                <option value="">Seleccione...</option>
                @foreach($allowanceValues as $allowanceValue)
                    <option value="{{ $allowanceValue->id }}" {{ ($allowance->allowance_value_id == $allowanceValue->id)?'selected':'' }}>{{ $allowanceValue->name }}</option>
                @endforeach
            </select>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-3">
            <label for="for_place">Lugar</label>
            <input class="form-control" type="text" autocomplete="off" name="place" value="{{ $allowance->place }}" required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_reason">Motivo</label>
            <input class="form-control" type="text" autocomplete="off" name="reason" value="{{ $allowance->reason }}" required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_requester_id">Origen:</label>
                @livewire('search-select-commune', [
                    'selected_id' => 'origin_commune_id',
                    'required'    => 'required',
                    'commune'     => $allowance->originCommune
                ])
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_requester_id">Destino:</label>
                @livewire('search-select-commune', [
                    'selected_id' => 'destination_commune_id',
                    'required'    => 'required',
                    'commune'     => $allowance->destinationCommune
                ])
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-3">
            <label for="for_round_trip">Medio de Transporte</label>
            <select name="means_of_transport" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="plane" {{ ($allowance->means_of_transport == 'plane')?'selected':'' }}>Avión</option>
                <option value="bus" {{ ($allowance->means_of_transport == 'bus')?'selected':'' }}>Bus</option>
                <option value="other" {{ ($allowance->means_of_transport == 'other')?'selected':'' }}>Otro</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_round_trip">Itinerario</label>
            <select name="round_trip" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="round trip" {{ ($allowance->round_trip == 'round trip')?'selected':'' }}>Ida, vuelta</option>
                <option value="one-way only" {{ ($allowance->round_trip == 'one-way only')?'selected':'' }}>Sólo ida</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_passage">Pernocta fuera del lugar de residencia</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="overnight" id="for_overnight_yes" value="1" 
                        {{ ($allowance->overnight == 1)?'checked':''}} required>
                    <label class="form-check-label" for="for_overnight_no">Si</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="overnight" id="for_overnight_no" value="0" 
                        {{ ($allowance->overnight == 1)?'checked':''}}required>
                    <label class="form-check-label" for="for_overnight_no">No</label>
                </div>
            </div>
        </fieldset>
        <fieldset class="form-group col-12 col-md-2">
            <label for="for_overnight">Derecho de Pasaje</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="passage" id="for_passage_yes" value="1" 
                        {{ ($allowance->passage == 1)?'checked':''}} required>
                    <label class="form-check-label" for="for_passage_yes">Si</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="passage" id="for_passage_no" value="0" 
                        {{ ($allowance->passage == 0)?'checked':''}} required>
                    <label class="form-check-label" for="for_passage_no">No</label>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-sm-3">
            <label for="for_start_date">Desde</label>
            <input type="date" class="form-control" name="from" id="for_from" 
                value="{{ $allowance->from->format('Y-m-d') }}" required>
        </fieldset>

        <!-- <fieldset class="form-check form-group mt-4 col-12 col-sm-3"> -->
        <fieldset class="form-group col-12 col-sm-3">
            <label for="for_calidad_juridica">Medio día</label>
            <div class="mt-1 ml-4">
                <input class="form-check-input" type="checkbox" name="from_half_day" value="1"
                    {{ ($allowance->from_half_day == 1)?'checked':''}}>
                <label class="form-check-label" for="for_from_half_day">
                    Si
                </label>
            </div>
        </fieldset>

        <fieldset class="form-group col-12 col-sm-3">
            <label for="for_end_date">Hasta</label>
            <input type="date" class="form-control" name="to" id="for_to"
                value="{{ $allowance->to->format('Y-m-d') }}" required>
        </fieldset>

        <fieldset class="form-group col-12 col-sm-3">
            <label for="for_calidad_juridica">Medio día</label>
            <div class="mt-1 ml-4">
                <input class="form-check-input" type="checkbox" name="to_half_day" value="1"
                    {{ ($allowance->to_half_day == 1)?'checked':''}}>
                <label class="form-check-label" for="for_to_half_day">
                    Si
                </label>
            </div>
        </fieldset>
    </div>

    <br>
    <hr>
    <br>

    <h6><i class="fas fa-dollar-sign"></i> Resumen</h6>
    
    @if(($allowance->TotalDays + 1) > 0.5)
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover">
                <tbody>
                    <tr class="text-center">
                        <th>Viático</th>
                        <th>Valor</th>
                        <th>N° Días</th>
                        <th>Valor Total</th>
                    </tr>
                    <tr>
                        <td><b>1. DIARIO</b></td>
                        <td class="text-right">${{ $allowance->AllowanceValueFormat }}</td>
                        <td class="text-center">{{ $allowance->TotalIntDays }}</td>
                        <td class="text-right">${{ $allowance->TotalIntAllowanceValue }}</td>
                    </tr>
                    <tr>
                        <td><b>2. PARCIAL</b></td>
                        <td class="text-right">${{ $allowance->AllowanceValueFormat }}</td>
                        <td class="text-center">{{ $allowance->TotalDecimalDay }}</td>
                        <td class="text-right">${{ $allowance->TotalDecimalAllowanceValue }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td class="text-center"><b>Total</b></td>
                        <td class="text-right">${{ $allowance->TotalIntAllowanceValue + $allowance->TotalDecimalAllowanceValue }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    <hr>

    @livewire('allowances.allowance-files', [
        'allowance' => $allowance    
    ])

    <br>

    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
</form>

<br><br>

<hr/>
<div style="height: 300px; overflow-y: scroll;">
    @include('partials.audit', ['audits' => $allowance->audits] )
</div>

@endsection

@section('custom_js')

@endsection
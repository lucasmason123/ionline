<div>
    
    <h5 class="card-title">Contrato id: {{ $serviceRequest->id }}</h5>

    <div class="form-row mb-3">
        <div class="col-md-3">
            <label for="validationDefault02">Programa</label>
            <select name="" id="" class="form-control" disabled>
                <option value="">{{ $serviceRequest->programm_name }}</option>

            </select>
        </div>
        <div class="col-md-3">
            <label for="validationDefault01">Fuente de financiamiento</label>
            <select name="" id="" class="form-control" disabled>
                <option value="">{{ $serviceRequest->type }}</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="validationDefault02">Responsable</label>
            @if ($serviceRequest->SignatureFlows->isNotEmpty())
                <input type="text" disabled class="form-control" id="validationDefault02"
                    value="{{ optional(optional($serviceRequest->SignatureFlows->where('sign_position', 1)->first())->user)->getFullNameAttribute() }}">
            @endif
        </div>
        <div class="col-md-3">
            <label for="validationDefault02">Supervisor</label>
            <input type="text" disabled class="form-control" id="validationDefault02"
                value="{{ optional(optional($serviceRequest->SignatureFlows->where('sign_position', 2)->first())->user)->getFullNameAttribute() }}">
        </div>
    </div>


    <div class="form-row mb-3">
        <div class="col-md-2">
            <label for="validationDefault02">Establecimiento</label>
            <select name="" id="" class="form-control" disabled>
                <option value="">{{ $serviceRequest->establishment->name }}</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="validationDefault02">Unidad Organizacional</label>
            <select name="" id="" class="form-control" disabled>
                <option value="">{{ $serviceRequest->responsabilityCenter->name }}</option>

            </select>
        </div>
        <div class="col-md-2">
            <label for="validationDefault02">Estamento</label>
            <select name="" id="" class="form-control" disabled>
                <option value="">
                    {{ $serviceRequest->profession ? $serviceRequest->profession->estamento : $serviceRequest->estate }}
                </option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="validationDefault02">Profesión</label>
            <select name="" id="" class="form-control" disabled>
                <option value="">{{ optional($serviceRequest->profession)->name }}</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="validationDefault02">Jornada</label>
            <input type="text" class="form-control" disabled id="validationDefault02"
                value="{{ $serviceRequest->working_day_type }}">
        </div>
    </div>
</div>

<div>
    @include('welfare.nav')

    <div>
        @if (session()->has('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif
    </div>

    @if($showCreate)

        <h4>Nueva solicitud</h4>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="benefit_id">Beneficio:</label>
                    <select wire:model="benefit_id" class="form-select" id="benefit_id">
                        <option value="">Selecciona un beneficio</option>
                        @foreach($benefits as $benefit)
                            <option value="{{ $benefit->id }}">{{ $benefit->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="subsidy_id">Subsidio:</label>
                    <select wire:model="subsidy_id" class="form-select" id="subsidy_id">
                        <option value="">Selecciona un subsidio</option>
                        @foreach($subsidies as $subsidy_item)
                            <option value="{{ $subsidy_item->id }}">{{ $subsidy_item->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
            @if($subsidy_id && $showData)
            <br>
            <table class="table table-bordered table-sm" >
                <thead>
                    <tr>	
                        <th style="width: 40%">Descripción</th>
                        <th style="width: 15%">Tope anual</th>
                        <th style="width: 45%">Documentos de respaldo</th>
                    </tr>
                </thead>
                <tbody>
                    <td><span class="valor" style="white-space: pre-wrap;">{{ $subsidy->description }}</span></td>
                    <td class="text-end">
                        $ {{ money($subsidy->annual_cap)}}<br>
                        <span class="text-secondary">Utilizado: $ {{ money($subsidy->getSubsidyUsedMoney()) }}</span><br>
                        <span class="text-success ">Disponible: $ {{ money($subsidy->annual_cap - $subsidy->getSubsidyUsedMoney()) }}</span>
                    </td>
                    <td>
                        <ul>
                            @foreach($subsidy->documents as $key => $document)
                                @if($document->type == "Documentación")
                                    <li>
                                        <div wire:loading wire:target="files.{{ $key }}"><i class="fas fa-spinner fa-spin"></i> <b>Cargando...</b></div> {{$document->name}}
                                        <input class="form-control" type="file" wire:model="files.{{ $key }}">
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </td>
                </tbody>
            </table>

            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <label>Banco</label>        
                    <select wire:model.lazy="bank_id" class="form-select" required>
                    <option value="">Seleccionar Banco</option>
                    @foreach($banks as $bank)
                    <option value="{{$bank->id}}">{{$bank->name}}</option>
                    @endforeach
                    </select>
                    @error('bank_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <!-- tipos de cuenta-->
                <div class="col-md-4">
                    <label for="for_pay_method">Tipo de Cuenta</label>
                    <select wire:model.lazy="pay_method" class="form-select">
                    <option value="">Seleccionar Forma de Pago</option>
                    <option value="01">CTA CORRIENTE / CTA VISTA</option>
                    <option value="02">CTA AHORRO</option>
                    <option value="30">CUENTA RUT</option>
                    </select>
                    @error('pay_method') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <!-- numero de cuenta-->
                <div class="col-md-4">
                    <label>Número de Cuenta</label>
                    <input type="number" wire:model.lazy="account_number" class="form-control" required>
                    @error('account_number') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div wire:loading wire:target="saveRequest">
                <i class="fas fa-spinner fa-spin"></i> Guardando...
            </div>

            <button wire:click="saveRequest" class="btn btn-success">Guardar</button>

            @endif

        <br>
        <hr>
    @endif

    <h4>
        Mis solicitudes 
        <button wire:click="showCreateForm" class="btn btn-primary btn-sm ml-2">Crear</button>
    </h4>

    <table class="table table-bordered table-sm" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha solicitud</th>
                <th>Beneficio</th>
                <th>Adjunto</th>
                <th>Estado</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->created_at->format('Y-m-d') }}</td>
                    <td>
                        {{ $request->subsidy->benefit->name }} - {{ $request->subsidy->name }}
                        @if($request->accepted_amount)
                        <br><b>MONTO ACEPTADO: </b> ${{ money($request->accepted_amount) }}
                        @endif
                        @if($request->status_update_observation)
                        <br><b>OBSERVACIONES: </b> {{ $request->status_update_observation }}
                        @endif
                        @if($request->subsidy->annual_cap != null)
                            @foreach($request->transfers as $transfer)
                                @if($request->subsidy->payment_in_installments)
                                    <li>
                                        Cuota {{$transfer->installment_number}}: 
                                            @if($transfer->payed_date) 
                                                Transferida - {{$transfer->payed_date->format('Y-m-d')}} - <b>${{ money($transfer->payed_amount)}}</b>
                                            @else
                                                Pendiente
                                            @endif
                                    </li>
                                @else
                                    <li>
                                        Transferido: {{$request->transfers->first()->payed_date->format('Y-m-d')}} - <b>${{ money($request->transfers->first()->payed_amount)}}</b>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            @if($request->accepted_amount != null)
                                @if($request->transfers->count() > 0)
                                    <li>
                                        Transferido: {{$request->transfers->first()->payed_date->format('Y-m-d')}} - <b>${{ money($request->transfers->first()->payed_amount)}}</b>
                                    </li>
                                @endif
                            @endif
                        @endif

                    </td>
                    <td>
                        @if($request->files->count() > 0)
                            @foreach($request->files as $file)
                                <li>
                                    <a href="#" wire:click="showFile({{ $file->id }})">
                                        {{$file->document->name}}
                                        <!-- <span class="fas fa-download" aria-hidden="true"></span> -->
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $request->status }}</td>
                    <td>{{ $request->status_update_observation }}</td>
                    <!-- <td>
                        <button wire:click="editRequest({{ $request->id }})" class="btn btn-primary btn-sm">Editar</button>
                        <button wire:click="deleteRequest({{ $request->id }})" class="btn btn-danger btn-sm">Eliminar</button>
                    </td> -->
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
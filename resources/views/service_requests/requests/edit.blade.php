@extends('layouts.app')

@section('title', 'Crear Programa Farmacia')

@section('content')

<h3>Solicitud de Contratación de Servicios</h3>


  @if($serviceRequest->where('user_id', Auth::user()->id)->orwhere('responsable_id',Auth::user()->id)->count() > 0)
    <form method="POST" action="{{ route('rrhh.service_requests.update', $serviceRequest) }}" enctype="multipart/form-data">
  @else
    <!-- si existe una firma, no se deja modificar solicitud -->
    @if($serviceRequest->SignatureFlows->where('type','!=','creador')->whereNotNull('status')->count() > 0)
      <form>
    @else
      <form method="POST" action="{{ route('rrhh.service_requests.update', $serviceRequest) }}" enctype="multipart/form-data">
    @endif
  @endif

  @csrf
  @method('PUT')

	<div class="row">

    <fieldset class="form-group col">
		    <label for="for_name">Tipo</label>
		    <select name="type" class="form-control" required>
          <option value="Covid" @if($serviceRequest->type == 'Covid') selected @endif>Honorarios - Covid</option>
          <option value="Genérico" @if($serviceRequest->type == 'Genérico') selected @endif >Honorarios - Genérico</option>
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_subdirection_ou_id">Subdirección</label>
				<select class="form-control selectpicker" data-live-search="true" name="subdirection_ou_id" required="" data-size="5">
          @foreach($subdirections as $key => $subdirection)
            <option value="{{$subdirection->id}}" @if($serviceRequest->subdirection_ou_id == $subdirection->id) selected @endif >{{$subdirection->name}}</option>
          @endforeach
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_responsability_center_ou_id">Centro de Responsabilidad</label>
				<select class="form-control selectpicker" data-live-search="true" name="responsability_center_ou_id" required="" data-size="5">
          @foreach($responsabilityCenters as $key => $responsabilityCenter)
            <option value="{{$responsabilityCenter->id}}" @if($serviceRequest->responsability_center_ou_id == $responsabilityCenter->id) selected @endif >{{$responsabilityCenter->name}}</option>
          @endforeach
        </select>
		</fieldset>

    <!-- <fieldset class="form-group col">
				<label for="for_name">Firmantes</label>
				<select name="users[]" id="users" class="form-control selectpicker" multiple disabled>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
		</fieldset> -->

	</div>

  <div class="row">

    <fieldset class="form-group col">
				<label for="for_users">Responsable</label>
				<select name="responsable_id" id="responsable_id" class="form-control selectpicker" data-live-search="true" required="" data-size="5" disabled>
          @foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($user->id == $serviceRequest->responsable_id) selected @endif >{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
		</fieldset>

		<fieldset class="form-group col">
				<label for="for_users">Jefe Directo</label>
				<select name="users[]" id="users" class="form-control selectpicker" data-live-search="true" required="" data-size="5" disabled>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($serviceRequest->SignatureFlows->where('responsable_id',$user->id)->where('type','visador')
                                                             ->whereNotIn('responsable_id',[9882506,13866194,15685508,Auth::user()->id])->count() > 0) selected @endif >{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
		</fieldset>

		<fieldset class="form-group col">
				<label for="for_users">Subdirector Médico</label>
				<select name="users[]" id="subdirector_medico" class="form-control selectpicker" data-live-search="true" required="" data-size="5" disabled>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($user->id == "9882506") selected  @endif >{{$user->getFullNameAttribute()}}</option>
					@endforeach
					<!-- <option value="12345678">Pedro Iriondo</option> -->
				</select>
				<!-- modificar rut por el que corresponda -->
				<input type="hidden" name="users[]" value="9882506" />
		</fieldset>

    <fieldset class="form-group col">
				<label for="for_users">S.D.G.A SSI</label>
				<select name="users[]" id="sdga_servicio" class="form-control selectpicker" data-live-search="true" required="" data-size="5" disabled>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($user->id == "14104369") selected disabled @endif >{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
				<input type="hidden" name="users[]" value="14104369" />
		</fieldset>

	</div>
	<div class="row">

    <fieldset class="form-group col">
				<label for="for_users">S.G.D.P Hospital</label>
				<select name="users[]" id="jefe_finanzas" class="form-control selectpicker" data-live-search="true" required="" data-size="5" disabled>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($user->id == "9018101") selected disabled @endif >{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
				<input type="hidden" name="users[]" value="9018101" />
		</fieldset>

    <fieldset class="form-group col">
				<label for="for_users">Jefe Finanzas</label>
				<select name="users[]" id="jefe_finanzas" class="form-control selectpicker" data-live-search="true" required="" data-size="5" disabled>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($user->id == "13866194") selected  @endif >{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
				<input type="hidden" name="users[]" value="13866194" />
		</fieldset>

    <fieldset class="form-group col">
				<label for="for_users">Director S.G.D.P</label>
				<select name="users[]" id="director_sgdp" class="form-control selectpicker" data-live-search="true" required="" data-size="5" disabled>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($user->id == 15685508) selected disabled @endif >{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
				<input type="hidden" name="users[]" value="15685508" />
		</fieldset>

    <fieldset class="form-group col">
				<label for="for_users">Director</label>
				<select name="users[]" id="director" class="form-control selectpicker" data-live-search="true" required="" data-size="5" disabled>
					@foreach($users as $key => $user)
						<option value="{{$user->id}}" @if($user->id == "14101085") selected  @endif >{{$user->getFullNameAttribute()}}</option>
					@endforeach
				</select>
				<input type="hidden" name="users[]" value="14101085" />
		</fieldset>

	</div>

  <br>

  <div class="border border-info rounded">
  <div class="row ml-1 mr-1">

    <fieldset class="form-group col">
		    <label for="for_rut">Rut</label>
		    <input type="text" class="form-control" id="for_rut" placeholder="" name="rut" required="required" value="{{ $serviceRequest->rut }}" disabled>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_name">Nombre completo</label>
		    <input type="text" class="form-control" id="for_name" placeholder="" name="name" required="required" value="{{ $serviceRequest->name }}">
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_name">Tipo de Contrato</label>
		    <select name="contract_type" class="form-control" required>
          <option value="NUEVO" @if($serviceRequest->contract_type == 'NUEVO') selected @endif >Nuevo</option>
          <option value="ANTIGUO" @if($serviceRequest->contract_type == 'ANTIGUO') selected @endif>Antiguo</option>
          <option value="CONTRATO PERM" @if($serviceRequest->contract_type == 'CONTRATO PERM') selected @endif>Permanente</option>
          <option value="PRESTACION" @if($serviceRequest->contract_type == 'PRESTACION') selected @endif>Prestación</option>
        </select>
		</fieldset>

  </div>

	<div class="row ml-1 mr-1">

    <fieldset class="form-group col">
		    <label for="for_address">Dirección</label>
		    <input type="text" class="form-control" id="foraddress" placeholder="" name="address" value="{{$serviceRequest->address}}">
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_phone_number">Número telefónico</label>
		    <input type="text" class="form-control" id="for_phone_number" placeholder="" name="phone_number" value="{{$serviceRequest->phone_number}}">
		</fieldset>

		<fieldset class="form-group col">
		    <label for="for_email">Correo electrónico</label>
		    <input type="text" class="form-control" id="for_email" placeholder="" name="email" value="{{$serviceRequest->email}}">
		</fieldset>

  </div>
  </div>

  <br>

  <div class="row">

    <fieldset class="form-group col">
		    <label for="for_request_date">Fecha Solicitud</label>
		    <input type="date" class="form-control" id="for_request_date" name="request_date" required value="{{\Carbon\Carbon::parse($serviceRequest->request_date)->format('Y-m-d')}}">
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_start_date">Fecha de Inicio</label>
		    <input type="date" class="form-control" id="for_start_date" name="start_date" required value="{{\Carbon\Carbon::parse($serviceRequest->start_date)->format('Y-m-d')}}">
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_end_date">Fecha de Término</label>
		    <input type="date" class="form-control" id="for_end_date" name="end_date" required value="{{\Carbon\Carbon::parse($serviceRequest->end_date)->format('Y-m-d')}}">
		</fieldset>

  </div>

  <hr>

  <div class="row">

    <fieldset class="form-group col">
        <label for="for_service_description">Descripción Servicio</label>
        <textarea id="service_description" name="service_description" class="form-control" rows="4" cols="50">{{ $serviceRequest->service_description }}</textarea>
    </fieldset>

  </div>

  <div class="row">

    <fieldset class="form-group col">
		    <label for="for_programm_name">Nombre del programa</label>
		    <!-- <input type="text" class="form-control" id="for_programm_name" placeholder="" name="programm_name" value="{{ $serviceRequest->programm_name }}"> -->
        <select name="programm_name" class="form-control">
          <option value=""></option>
          <option value="Covid19-APS No Médicos">Covid19-APS No Médicos</option>
          <option value="Covid19-APS Médicos">Covid19-APS Médicos</option>
          <option value="Covid19 No Médicos">Covid19 No Médicos</option>
          <option value="Covid19 Médicos">Covid19 Médicos</option>
        </select>
		</fieldset>

    <!-- <fieldset class="form-group col">
		    <label for="for_name">Otro</label>
		    <select name="other" class="form-control" required>
          <option value="Brecha" @if($serviceRequest->other == 'Brecha') selected @endif >Brecha</option>
          <option value="LM:LICENCIAS MEDICAS" @if($serviceRequest->other == 'LM:LICENCIAS MEDICAS') selected @endif >LM:LICENCIAS MEDICAS</option>
          <option value="HE:HORAS EXTRAS" @if($serviceRequest->other == 'HE:HORAS EXTRAS') selected @endif >HE:HORAS EXTRAS</option>
        </select>
		</fieldset> -->

    <!-- <fieldset class="form-group col">
		    <label for="for_normal_hour_payment">Pago Hora Normal</label>
		    <select name="normal_hour_payment" class="form-control">
          <option value="" @if($serviceRequest->normal_hour_payment == '') selected @endif ></option>
          <option value="MACROZONA" @if($serviceRequest->normal_hour_payment == 'MACROZONA') selected @endif >MACROZONA</option>
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_amount">Valor $</label>
		    <input type="number" class="form-control" id="for_amount" placeholder="" name="amount" value="{{ $serviceRequest->amount }}">
		</fieldset> -->

  </div>

  <div class="row">

    <fieldset class="form-group col">
		    <label for="for_program_contract_type">Tipo de Contratación</label>
		    <select name="program_contract_type" id="program_contract_type" class="form-control" required>
          <option value="Semanal" @if($serviceRequest->program_contract_type == 'Semanal') selected @endif >Semanal</option>
          <option value="Mensual" @if($serviceRequest->program_contract_type == 'Mensual') selected @endif >Mensual</option>
          <option value="Horas" @if($serviceRequest->program_contract_type == 'Horas') selected @endif >Horas</option>
          <option value="Otro" @if($serviceRequest->program_contract_type == 'Otro') selected @endif >Otro</option>
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_weekly_hours">Hrs.Semanales</label>
		    <select name="weekly_hours" class="form-control" id="for_weekly_hours" required>
					<option value=""></option>
          <option value="44" @if($serviceRequest->weekly_hours == 44) selected @endif>44</option>
          <option value="33" @if($serviceRequest->weekly_hours == 33) selected @endif>33</option>
					<option value="28" @if($serviceRequest->weekly_hours == 28) selected @endif>28</option>
					<option value="22" @if($serviceRequest->weekly_hours == 22) selected @endif>22</option>
          <option value="11" @if($serviceRequest->weekly_hours == 11) selected @endif>11</option>
        </select>
		</fieldset>

    <fieldset class="form-group col">
        <label for="for_establishment_id">Establecimiento</label>
        <select name="establishment_id" class="form-control" required>
          <option value=""></option>
          @foreach($establishments as $key => $establishment)
            <option value="{{$establishment->id}}" @if($serviceRequest->establishment_id == $establishment->id) selected @endif>{{$establishment->name}}</option>
          @endforeach
        </select>
    </fieldset>

    <!-- <fieldset class="form-group col">
		    <label for="for_daily_hours">Horas Diurnas</label>
		    <input type="number" class="form-control" id="for_daily_hours" placeholder="" name="daily_hours" value="{{ $serviceRequest->daily_hours }}">
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_nightly_hours">Horas Nocturnas</label>
		    <input type="number" class="form-control" id="for_nightly_hours" placeholder="" name="nightly_hours" value="{{ $serviceRequest->nightly_hours }}">
		</fieldset> -->

    <br>

  </div>

  <div class="card" id="control_turnos">
    <div class="card-header">
      Control de Turnos
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        <div class="row">
          <fieldset class="form-group col">
              <label for="for_estate">Entrada</label>
              <input type="date" class="form-control" name="shift_start_date" id="shift_start_date">
          </fieldset>
          <fieldset class="form-group col">
              <label for="for_estate">Hora</label>
              <input type="time" class="form-control" name="start_hour" id="start_hour">
          </fieldset>
          <fieldset class="form-group col">
              <label for="for_estate">Salida</label>
              <input type="date" class="form-control" name="shift_end_date" id="shift_end_date">
          </fieldset>
          <fieldset class="form-group col">
              <label for="for_estate">Hora</label>
              <input type="time" class="form-control" name="end_hour" id="end_hour">
          </fieldset>
          <fieldset class="form-group col">
              <label for="for_estate">Observación</label>
              <input type="text" class="form-control" name="observation" id="observation">
          </fieldset>
          <fieldset class="form-group col-2">
              <label for="for_estate"><br/></label>
              <!-- solo tiene acceso la persona que crea la solicitud -->
              @if($serviceRequest->where('user_id', Auth::user()->id)->orwhere('responsable_id',Auth::user()->id)->count() > 0)
                <!-- si existe una firma, no se deja modificar solicitud -->
                @if($serviceRequest->SignatureFlows->where('type','!=','creador')->whereNotNull('status')->count() > 0)
                  <button type="button" class="btn btn-primary form-control add-row" id="shift_button_add" formnovalidate="formnovalidate" disabled>Ingresar</button>
                @else
                  <button type="button" class="btn btn-primary form-control add-row" id="shift_button_add" formnovalidate="formnovalidate">Ingresar</button>
                @endif
              @else
                <button type="button" class="btn btn-primary form-control add-row" id="shift_button_add" formnovalidate="formnovalidate" disabled>Ingresar</button>
              @endif
          </fieldset>
        </div>

        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Entrada</th>
                    <th>H.Inicio</th>
                    <th>H.Término</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
              @foreach($serviceRequest->shiftControls as $key => $shiftControl)
                <tr>
                  <td><input type='checkbox' name='record'></td>
                  <td><input type="hidden" class="form-control" name="shift_start_date[]" value="{{Carbon\Carbon::parse($shiftControl->start_date)->format('Y-m-d')}}">{{Carbon\Carbon::parse($shiftControl->start_date)->format('Y-m-d')}}</td>
                  <td><input type="hidden" class="form-control" name="shift_start_hour[]" value="{{Carbon\Carbon::parse($shiftControl->start_date)->format('H:i')}}">{{Carbon\Carbon::parse($shiftControl->start_date)->format('H:i')}}</td>
                  <td><input type="hidden" class="form-control" name="shift_end_date[]" value="{{Carbon\Carbon::parse($shiftControl->end_date)->format('Y-m-d')}}">{{Carbon\Carbon::parse($shiftControl->end_date)->format('Y-m-d')}}</td>
                  <td><input type="hidden" class="form-control" name="shift_end_hour[]" value="{{Carbon\Carbon::parse($shiftControl->end_date)->format('H:i')}}">{{Carbon\Carbon::parse($shiftControl->end_date)->format('H:i')}}</td>
                  <td><input type="hidden" class="form-control" name="shift_observation[]" value="{{$shiftControl->observation}}">{{$shiftControl->observation}}</td>
                </tr>
              @endforeach
            </tbody>
        </table>
        <!-- solo tiene acceso la persona que crea la solicitud -->
        @if($serviceRequest->where('user_id', Auth::user()->id)->orwhere('responsable_id',Auth::user()->id)->count() > 0)
          <!-- si existe una firma, no se deja modificar solicitud -->
          @if($serviceRequest->SignatureFlows->where('type','!=','creador')->whereNotNull('status')->count() > 0)
            <button type="button" class="btn btn-primary delete-row" disabled>Eliminar filas</button>
          @else
            <button type="button" class="btn btn-primary delete-row">Eliminar filas</button>
          @endif
        @else
          <button type="button" class="btn btn-primary delete-row" disabled>Eliminar filas</button>
        @endif
      </li>
    </ul>
  </div>

  <br>

  <div class="row">

    <fieldset class="form-group col">
		    <label for="for_estate">Estamento al que corresponde CS</label>
		    <select name="estate" class="form-control" required>
          <option value="Profesional Médico" @if($serviceRequest->estate == 'Profesional Médico') selected @endif >Profesional Médico</option>
          <option value="Profesional" @if($serviceRequest->estate == 'Profesional') selected @endif >Profesional</option>
          <option value="Técnico" @if($serviceRequest->estate == 'Técnico') selected @endif >Técnico</option>
          <option value="Administrativo" @if($serviceRequest->estate == 'Administrativo') selected @endif >Administrativo</option>
          <option value="Farmaceutico" @if($serviceRequest->estate == 'Farmaceutico') selected @endif >Farmaceutico</option>
          <option value="Odontólogo" @if($serviceRequest->estate == 'Odontólogo') selected @endif >Odontólogo</option>
          <option value="Bioquímico" @if($serviceRequest->estate == 'Bioquímico') selected @endif >Bioquímico</option>
          <option value="Auxiliar" @if($serviceRequest->estate == 'Auxiliar') selected @endif >Auxiliar</option>
          <option value="Otro (justificar)" @if($serviceRequest->estate == 'Otro (justificar)') selected @endif >Otro (justificar)</option>
        </select>
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_estate_other">Otro</label>
		    <input type="text" class="form-control" id="for_estate_other" placeholder="" name="estate_other" value="{{ $serviceRequest->estate_other }}">
		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_working_day_type">Jornada de Trabajo</label>
		    <select name="working_day_type" class="form-control" required>
          <!-- <option value="08:00 a 16:48 hrs (L-M-M-J-V)" @if($serviceRequest->working_day_type == '08:00 a 16:48 hrs (L-M-M-J-V)') selected @endif >08:00 a 16:48 hrs (L-M-M-J-V)</option> -->
          <option value="DIURNO" @if($serviceRequest->working_day_type == 'DIURNO') selected @endif >DIURNO</option>
          <option value="TERCER TURNO" @if($serviceRequest->working_day_type == 'TERCER TURNO') selected @endif >TERCER TURNO</option>
          <option value="TERCER TURNO - MODIFICADO" @if($serviceRequest->working_day_type == 'TERCER TURNO - MODIFICADO') selected @endif >TERCER TURNO - MODIFICADO</option>
          <option value="CUARTO TURNO" @if($serviceRequest->working_day_type == 'CUARTO TURNO') selected @endif >CUARTO TURNO</option>
          <option value="CUARTO TURNO - MODIFICADO" @if($serviceRequest->working_day_type == 'CUARTO TURNO - MODIFICADO') selected @endif >CUARTO TURNO - MODIFICADO</option>
        </select>

		</fieldset>

    <fieldset class="form-group col">
		    <label for="for_working_day_type_other">Otro</label>
		    <input type="text" class="form-control" id="for_working_day_type_other" placeholder="" name="working_day_type_other" value="{{ $serviceRequest->working_day_type_other }}">
		</fieldset>

  </div>

  <!-- solo el creador de la solicitud puede editar  -->
  @if($serviceRequest->where('user_id', Auth::user()->id)->orwhere('responsable_id',Auth::user()->id)->count() > 0)
    <button type="submit" class="btn btn-primary">Guardar</button>
  @else
    <!-- si existe una firma, no se deja modificar solicitud -->
    @if($serviceRequest->SignatureFlows->where('type','!=','creador')->whereNotNull('status')->count() > 0)
      <div class="alert alert-warning" role="alert">
        No se puede modificar hoja de ruta ya que existen visaciones realizadas.
      </div>
      <button type="submit" class="btn btn-primary" disabled>Guardar</button>
    @else
      <button type="submit" class="btn btn-primary">Guardar</button>
    @endif
  @endif

  <br><br>

  </form>

  @canany(['Service Request: additional data'])
  <form method="POST" action="{{ route('rrhh.service_requests.update', $serviceRequest) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="card">
    <div class="card-header">
      Datos adicionales - Resolución
    </div>
      <div class="card-body">

        <div class="row">
          <fieldset class="form-group col">
					    <label for="for_name">N° Contrato</label>
              <input type="text" class="form-control" name="contract_number" value="{{$serviceRequest->contract_number}}">
					</fieldset>

          <fieldset class="form-group col">
              <label for="for_name">Mes de pago</label>
              <select name="month_of_payment" class="form-control">
                <option value=""></option>
                <option value="1" @if($serviceRequest->month_of_payment == 1) selected @endif>Enero</option>
                <option value="2" @if($serviceRequest->month_of_payment == 2) selected @endif>Febrero</option>
                <option value="3" @if($serviceRequest->month_of_payment == 3) selected @endif>Marzo</option>
                <option value="4" @if($serviceRequest->month_of_payment == 4) selected @endif>Abril</option>
                <option value="5" @if($serviceRequest->month_of_payment == 5) selected @endif>Mayo</option>
                <option value="6" @if($serviceRequest->month_of_payment == 6) selected @endif>Junio</option>
                <option value="7" @if($serviceRequest->month_of_payment == 7) selected @endif>Julio</option>
                <option value="8" @if($serviceRequest->month_of_payment == 8) selected @endif>Agosto</option>
                <option value="9" @if($serviceRequest->month_of_payment == 9) selected @endif>Septiembre</option>
                <option value="10" @if($serviceRequest->month_of_payment == 10) selected @endif>Octubre</option>
                <option value="11" @if($serviceRequest->month_of_payment == 11) selected @endif>Noviembre</option>
                <option value="12" @if($serviceRequest->month_of_payment == 12) selected @endif>Diciembre</option>
              </select>
          </fieldset>

          <fieldset class="form-group col">
              <label for="for_nationality">País de Funcionario</label>
              <select name="nationality" class="form-control">
                <option value=""></option>
                <option value="Chile" @if($serviceRequest->nationality == "Chile") selected @endif>Chile</option>
                <option value="Argentina" @if($serviceRequest->nationality == "Argentina") selected @endif>Argentina</option>
                <option value="Venezuela" @if($serviceRequest->nationality == "Venezuela") selected @endif>Venezuela</option>
                <option value="Perú" @if($serviceRequest->nationality == "Perú") selected @endif>Perú</option>
                <option value="Bolivia" @if($serviceRequest->nationality == "Bolivia") selected @endif>Bolivia</option>
              </select>
          </fieldset>

        </div>

        <div class="row">

          <fieldset class="form-group col">
              <label for="for_digera_strategy">Estrategia Digera Covid</label>
              <select name="digera_strategy" class="form-control">
                <option value=""></option>
                <option value="Camas MEDIAS Aperturadas" @if($serviceRequest->digera_strategy == "Camas MEDIAS Aperturadas") selected @endif>Camas MEDIAS Aperturadas</option>
                <option value="Camas MEDIAS Complejizadas" @if($serviceRequest->digera_strategy == "Camas MEDIAS Complejizadas") selected @endif>Camas MEDIAS Complejizadas</option>
                <option value="Camas UCI Aperturadas" @if($serviceRequest->digera_strategy == "Camas UCI Aperturadas") selected @endif>Camas UCI Aperturadas</option>
                <option value="Camas UCI Complejizadas" @if($serviceRequest->digera_strategy == "Camas UCI Complejizadas") selected @endif>Camas UCI Complejizadas</option>
                <option value="Camas UTI Aperturadas" @if($serviceRequest->digera_strategy == "Camas UTI Aperturadas") selected @endif>Camas UTI Aperturadas</option>
                <option value="Camas UTI Complejizadas" @if($serviceRequest->digera_strategy == "Camas UTI Complejizadas") selected @endif>Camas UTI Complejizadas</option>
                <option value="Cupos Hosp. Domiciliaria" @if($serviceRequest->digera_strategy == "Cupos Hosp. Domiciliaria") selected @endif>Cupos Hosp. Domiciliaria</option>
                <option value="Refuerzo Anatomía Patologica" @if($serviceRequest->digera_strategy == "Refuerzo Anatomía Patologica") selected @endif>Refuerzo Anatomía Patologica</option>
                <option value="Refuerzo Laboratorio" @if($serviceRequest->digera_strategy == "Refuerzo Laboratorio") selected @endif>Refuerzo Laboratorio</option>
                <option value="Refuerzo SAMU" @if($serviceRequest->digera_strategy == "Refuerzo SAMU") selected @endif>Refuerzo SAMU</option>
                <option value="Refuerzo UEH" @if($serviceRequest->digera_strategy == "Refuerzo UEH") selected @endif>Refuerzo UEH</option>
              </select>
          </fieldset>

          <fieldset class="form-group col">
              <label for="for_rrhh_team">Equipo RRHH</label>
              <select name="rrhh_team" class="form-control">
                <option value=""></option>
                <option value="Residencia Médica" @if($serviceRequest->rrhh_team == "Residencia Médica") selected @endif>Residencia Médica</option>
                <option value="Médico Diurno" @if($serviceRequest->rrhh_team == "Médico Diurno") selected @endif>Médico Diurno</option>
                <option value="Enfermera Supervisora" @if($serviceRequest->rrhh_team == "Enfermera Supervisora") selected @endif>Enfermera Supervisora</option>
                <option value="Enfermera Diurna" @if($serviceRequest->rrhh_team == "Enfermera Diurna") selected @endif>Enfermera Diurna</option>
                <option value="Enfermera Turno" @if($serviceRequest->rrhh_team == "Enfermera Turno") selected @endif>Enfermera Turno</option>
                <option value="Kinesiólogo Diurno" @if($serviceRequest->rrhh_team == "Kinesiólogo Diurno") selected @endif>Kinesiólogo Diurno</option>
                <option value="Kinesiólogo Turno" @if($serviceRequest->rrhh_team == "Kinesiólogo Turno") selected @endif>Kinesiólogo Turno</option>
                <option value="Téc.Paramédicos Diurno" @if($serviceRequest->rrhh_team == "Téc.Paramédicos Diurno") selected @endif>Téc.Paramédicos Diurno</option>
                <option value="Téc.Paramédicos Turno" @if($serviceRequest->rrhh_team == "Téc.Paramédicos Turno") selected @endif>Téc.Paramédicos Turno</option>
                <option value="Auxiliar Diurno" @if($serviceRequest->rrhh_team == "Auxiliar Diurno") selected @endif>Auxiliar Diurno</option>
                <option value="Auxiliar Turno" @if($serviceRequest->rrhh_team == "Auxiliar Turno") selected @endif>Auxiliar Turno</option>
                <option value="Terapeuta Ocupacional" @if($serviceRequest->rrhh_team == "Terapeuta Ocupacional") selected @endif>Terapeuta Ocupacional</option>
                <option value="Químico Farmacéutico" @if($serviceRequest->rrhh_team == "Químico Farmacéutico") selected @endif>Químico Farmacéutico</option>
                <option value="Bioquímico" @if($serviceRequest->rrhh_team == "Bioquímico") selected @endif>Bioquímico</option>
                <option value="Fonoaudiologo" @if($serviceRequest->rrhh_team == "Fonoaudiologo") selected @endif>Fonoaudiologo</option>
              </select>
          </fieldset>

          <fieldset class="form-group col">
					    <label for="for_net_amount">Monto Neto</label>
              <input type="text" class="form-control" name="net_amount" value="{{$serviceRequest->net_amount}}">
					</fieldset>

          <fieldset class="form-group col">
					    <label for="for_gross_amount">Monto Bruto</label>
              <input type="text" class="form-control" name="gross_amount" value="{{$serviceRequest->gross_amount}}">
					</fieldset>

          <fieldset class="form-group col">
              <label for="for_sirh_contract_registration">Contrato registrado en Sirh</label>
              <select name="sirh_contract_registration" class="form-control">
                <option value=""></option>
                <option value="1"  @if($serviceRequest->sirh_contract_registration == 1) selected @endif>Sí</option>
                <option value="0"  @if($serviceRequest->sirh_contract_registration == 0) selected @endif>No</option>
              </select>
          </fieldset>
        </div>

        <div class="row">

          <fieldset class="form-group col">
					    <label for="for_resolution_number">N° Resolución</label>
              <input type="text" class="form-control" name="resolution_number" value="{{$serviceRequest->resolution_number}}">
					</fieldset>

          <fieldset class="form-group col">
					    <label for="for_bill_number">N° Boleta</label>
              <input type="text" class="form-control" name="bill_number" value="{{$serviceRequest->bill_number}}">
					</fieldset>

          <fieldset class="form-group col">
					    <label for="for_total_hours_paid">Total hrs pagadas período</label>
              <input type="text" class="form-control" name="total_hours_paid" value="{{$serviceRequest->total_hours_paid}}">
					</fieldset>

          <fieldset class="form-group col">
					    <label for="for_total_paid">Total pagado</label>
              <input type="text" class="form-control" name="total_paid" value="{{$serviceRequest->total_paid}}">
					</fieldset>

          <fieldset class="form-group col">
      		    <label for="for_payment_date">Fecha pago</label>
      		    <input type="date" class="form-control" id="for_payment_date" name="payment_date" required value="{{\Carbon\Carbon::parse($serviceRequest->payment_date)->format('Y-m-d')}}">
      		</fieldset>

        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>

      </div>

  </div>

  <br>
  </form>
  @endcan


<form method="POST" action="{{ route('rrhh.signature_flow.store') }}" enctype="multipart/form-data">
@csrf

<div class="card">
  <div class="card-header">
    Aprobaciones de Solicitud
  </div>
    <div class="card-body">

      <table class="table table-sm table-bordered" style='font-size:65%' >
        <thead>
          <tr>
            <th scope="col">Fecha</th>
            <th scope="col">U.Organizacional</th>
            <th scope="col">Cargo</th>
            <th scope="col">Usuario</th>
            <th scope="col">Tipo</th>
            <th scope="col">Estado</th>
          </tr>
        </thead>
        <tbody>
          @foreach($serviceRequest->SignatureFlows->sortBy('sign_position') as $key => $SignatureFlow)
          @if($SignatureFlow->status === null)
            <tr class="bg-light">
          @elseif($SignatureFlow->status === 0)
            <tr class="bg-danger">
          @elseif($SignatureFlow->status === 1)
            <tr>
          @endif
             <td>{{ $SignatureFlow->signature_date}}</td>
             <td>{{ $SignatureFlow->organizationalUnit->name}}</td>
             <td>{{ $SignatureFlow->employee }}</td>
             <td>{{ $SignatureFlow->user->getFullNameAttribute() }}</td>
             <td>{{ $SignatureFlow->type }}</td>
             <td>@if($SignatureFlow->status === null)  @elseif($SignatureFlow->status === 1) Aceptada @elseif($SignatureFlow->status === 0) Rechazada @endif</td>
           </tr>
         @endforeach
        </tbody>
      </table>


      <div class="row">
        <fieldset class="form-group col-3">
            <label for="for_name">Tipo</label>
            <input type="text" class="form-control" name="employee" value="{{$employee}}" readonly="readonly">
            <input type="hidden" class="form-control" name="service_request_id" value="{{$serviceRequest->id}}">
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_name">Estado Solicitud</label>
            <select name="status" class="form-control">
              <option value="">Seleccionar una opción</option>
              <option value="1">Aceptada</option>
              <option value="0">Rechazada</option>
            </select>
        </fieldset>
        <fieldset class="form-group col-4">
            <label for="for_observation">Observación</label>
            <input type="text" class="form-control" id="for_observation" placeholder="" name="observation">
        </fieldset>
        <fieldset class="form-group col">
            <label for="for_button"><br></label>
            <button type="submit" id="for_button" class="form-control btn btn-primary">Guardar</button>
        </fieldset>
      </div>



    </div>
</div>

</form>

@endsection

@section('custom_js')
<script type="text/javascript">

	$( document ).ready(function() {

    if ($('#program_contract_type').val() == "Horas") {
      $("#control_turnos").show();
      $('#for_weekly_hours').attr('disabled', 'disabled');
    }else{
      $("#control_turnos").hide();
      $('#for_weekly_hours').removeAttr('disabled');
    }


		$('#program_contract_type').on('change', function() {
			if (this.value == "Horas") {
				$('#for_daily_hours').val("");
				$('#for_nightly_hours').val("");
				$('#for_daily_hours').attr('readonly', true);
				$('#for_nightly_hours').attr('readonly', true);
        $('#for_weekly_hours').attr('disabled', 'disabled');
				$("#control_turnos").show();
			}else{
				$('#for_daily_hours').attr('readonly', false);
				$('#for_nightly_hours').attr('readonly', false);
        $('#for_weekly_hours').removeAttr('disabled');
				$("#control_turnos").hide();
			}
		});

  	$(".add-row").click(function(){
        var shift_start_date = $("#shift_start_date").val();
        var start_hour = $("#start_hour").val();
        var shift_end_date = $("#shift_end_date").val();
        var end_hour = $("#end_hour").val();
  			var observation = $("#observation").val();
        var markup = "<tr><td><input type='checkbox' name='record'></td><td> <input type='hidden' class='form-control' name='shift_start_date[]' id='shift_start_date' value='"+ shift_start_date +"'>"+ shift_start_date +"</td><td> <input type='hidden' class='form-control' name='shift_start_hour[]' id='start_hour' value='"+ start_hour +"'>" + start_hour + "</td><td> <input type='hidden' class='form-control' name='shift_end_date[]' id='shift_end_date' value='"+ shift_end_date +"'>"+ shift_end_date +"</td><td> <input type='hidden' class='form-control' name='shift_end_hour[]' id='end_hour' value='"+ end_hour +"'>" + end_hour + "</td><td> <input type='hidden' class='form-control' name='shift_observation[]' id='observation' value='"+ observation +"'>" + observation + "</td></tr>";
        $("table tbody").append(markup);

  			// $("#shift_date").val("");
        // $("#start_hour").val("");
  			// $("#end_hour").val("");
  			// $("#observation").val("");
    });

  	// Find and remove selected table rows
    $(".delete-row").click(function(){
        $("table tbody").find('input[name="record"]').each(function(){
        	if($(this).is(":checked")){
                $(this).parents("tr").remove();
            }
        });
    });

  });
</script>
@endsection

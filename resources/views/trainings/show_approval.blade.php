<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<div class="row">
    <div class="col-12 col-md-12">
        <h5 class="mt-2 mb-3">Formulario Solicitud DE Capacitación ID: {{ $training->id }}
            @switch($training->StatusValue)
                @case('Guardado')
                    <span class="badge text-bg-primary">{{ $training->StatusValue }}</span>
                    @break
                                
                @case('Enviado')
                    <span class="badge text-bg-warning">{{ $training->StatusValue }}</span>
                    @break

                @case('Pendiente')
                    <span class="badge text-bg-warning">{{ $training->StatusValue }}</span>
                    @break
            @endswitch
        </h5>
    </div>
</div>

<div class="table-responsive mt-3">
    <table class="table table-bordered table-sm small">
        <thead>
            <tr>
                <th colspan="6" class="table-secondary">I. Antecedentes del funcionario/a que asiste a la Capacitación.</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Nombre</th>
                <td width="25%" colspan="2">{{ ($training->userTraining) ? $training->userTraining->FullName : null }}</td>
                <th width="25%" class="table-secondary">RUN</th>
                <td width="25%">{{ $training->userTraining->id }}-{{ $training->userTraining->dv }}</td>
            </tr>
            <tr>
                <th width="12.5%" class="table-secondary">Estamento</th>
                <td width="12.5%">{{ $training->estament->name }}</td>
                <th width="12.5%" class="table-secondary">Grado</th>
                <td width="12.5%">{{ $training->degree }}</td>
                <th width="" class="table-secondary">Calidad Jurídica</th>
                <td width="">{{ $training->contractualCondition->name }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Servicio/Unidad</th>
                <td width="25%" colspan="2">{{ ($training->userTrainingOu) ? $training->userTrainingOu->name : null }}</td>
                <th width="25%" class="table-secondary">Establecimiento</th>
                <td width="25%">{{ ($training->userTrainingEstablishment) ? $training->userTrainingEstablishment->name : null }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Correo electrónico</th>
                <td width="25%" colspan="2">{{ $training->email }}</td>
                <th width="25%" class="table-secondary">Fono contacto</th>
                <td width="25%">{{ $training->telephone }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive mt-3">
    <table class="table table-bordered table-sm small">
        <thead>
            <tr>
                <th colspan="6" class="table-secondary">II. Antecedentes de la Actividad.</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Eje estratégico asociados a la Actividad</th>
                <td colspan="4">{{ $training->StrategicAxes->name }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Objetivo</th>
                <td colspan="4">{{ $training->objective }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Nombre de la Actividad</th>
                <td colspan="4">{{ $training->activity_name }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Tipo de Actividad</th>
                <td width="25%" colspan="2">{{ $training->activity_type }}</td>
                <th width="25%" class="table-secondary">Otro</th>
                <td width="25%">{{ $training->other_activity_type }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Modalidad de aprendizaje</th>
                <td width="25%" colspan="2">{{ $training->mechanism }}</td>
                <th width="25%" class="table-secondary">Actividad</th>
                <td width="25%"> {{ $training->schuduled }}</td>
            </tr>
            <tr>
                <th width="12.5%" class="table-secondary">Inicio Actividad</th>
                <td width="12.5%">{{ $training->activity_date_start_at }}</td>
                <th width="12.5%" class="table-secondary">Fin Actividad</th>
                <td width="12.5%">{{ $training->activity_date_end_at }}</td>
                <th width="" class="table-secondary">Total horas cronológicas</th>
                <td width="">{{ $training->total_hours }}</td>
            </tr>
            <tr>
                <th width="12.5%" class="table-secondary">Permiso Desde</th>
                <td width="12.5%">{{ $training->permission_date_start_at }}</td>
                <th width="12.5%" class="table-secondary">Permiso Hasta</th>
                <td width="12.5%">{{ $training->permission_date_end_at }}</td>
                <th width="" class="table-secondary">Lugar</th>
                <td width="">{{ $training->place }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Jornada y Horarios</th>
                <td colspan="4">{{ $training->working_day }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Fundamento o Razones Técnicas para la asistencia del funcionario</th>
                <td colspan="4">{{ $training->technical_reasons }}</td>
            </tr>
        </tbody>
    </table>
</div>




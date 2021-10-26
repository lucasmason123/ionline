<!-- Modal -->
<div class="modal fade" id="exampleModalCenter-req-{{ $requestReplacementStaff->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Gestión de Solicitudes para aprobación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table class="table table-sm table-bordered">
              <thead>
                  <tr class="table-active">
                    <th colspan="3">Formulario Contratación de Personal - Solicitud Nº {{ $requestReplacementStaff->id }}</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <th class="table-active">Por medio del presente, la</th>
                      <td colspan="2">
                          {{ $requestReplacementStaff->organizationalUnit->name }}
                      </td>
                  </tr>
                  <tr>
                      <th class="table-active">Solicita autorizar el llamado a presentar antecedentes al cargo de</th>
                      <td colspan="2">
                          {{ $requestReplacementStaff->name }}
                      </td>
                  </tr>
                  <tr>
                      <th class="table-active">En el grado</th>
                      <td colspan="2">{{ $requestReplacementStaff->degree }}</td>
                  </tr>
                  <tr>
                      <th class="table-active">Calidad Jurídica</th>
                      <td colspan="2">{{ $requestReplacementStaff->LegalQualityValue }}</td>
                  </tr>
                  <tr>
                      <th class="table-active">La Persona cumplirá labores en Jornada</th>
                      <td style="width: 33%">{{ $requestReplacementStaff->WorkDayValue }}</td>
                      <td style="width: 33%">{{ $requestReplacementStaff->other_work_day }}</td>
                  </tr>
                  <tr>
                      <th class="table-active">Justificación o fundamento de la Contratación</th>
                      <td style="width: 33%">{{ $requestReplacementStaff->FundamentValue }}</td>
                      <td style="width: 33%">De funcionario: {{ $requestReplacementStaff->name_to_replace }}</td>
                  </tr>
                  <tr>
                      <th class="table-active">Otros (especifique)</th>
                      <td colspan="2">{{ $requestReplacementStaff->other_fundament }}</td>
                  </tr>
                  <tr>
                      <th class="table-active">Periodo</th>
                      <td style="width: 33%">{{ $requestReplacementStaff->start_date->format('d-m-Y') }}</td>
                      <td style="width: 33%">{{ $requestReplacementStaff->end_date->format('d-m-Y') }}</td>
                  </tr>
                  <tr>
                      <td colspan="3">El documento debe contener las firmas y timbres de las personas que dan autorización para que la Unidad Selección inicie el proceso de Llamado de presentación de antecedentes.</td>
                  </tr>
                  <tr>
                      @foreach($requestReplacementStaff->RequestSign as $sign)
                        <td class="table-active text-center">
                            {{ $sign->organizationalUnit->name }}<br>
                        </td>
                      @endforeach
                  </tr>
                  <tr>
                      @foreach($requestReplacementStaff->RequestSign as $requestSign)
                        <td align="center">
                            @if($requestSign->request_status == 'accepted')
                                <span style="color: green;">
                                  <i class="fas fa-check-circle"></i> {{ $requestSign->StatusValue }} </span><br>
                                <i class="fas fa-user"></i> {{ $requestSign->user->FullName }}<br>
                                <i class="fas fa-calendar-alt"></i> {{ ($requestSign->date_sign) ? $requestSign->date_sign->format('d-m-Y H:i:s') : '' }}<br>
                            @endif
                            @if($requestSign->request_status == 'rejected')
                                <span style="color: Tomato;">
                                  <i class="fas fa-times-circle"></i> {{ $requestSign->StatusValue }} </span><br>
                                <i class="fas fa-user"></i> {{ $requestSign->user->FullName }}<br>
                                <i class="fas fa-calendar-alt"></i> {{ $requestSign->date_sign->format('d-m-Y H:i:s') }}<br>
                                <hr>
                                {{ $requestSign->observation }}<br>
                            @endif
                            @if($requestSign->request_status == 'pending' || $requestSign->request_status == NULL)
                                <i class="fas fa-clock"></i> Pendiente.<br>
                            @endif
                        </td>
                      @endforeach
                  </tr>
              </tbody>
          </table>

          <div class="row">
              <div class="col">
                  @if($requestReplacementStaff->technicalEvaluation &&
                    $requestReplacementStaff->end_date < now()->toDateString() &&
                      $requestReplacementStaff->technicalEvaluation->date_end != null &&
                        $requestReplacementStaff->user_id == Auth::user()->id)
                      <a class="btn btn-success float-right" href="{{ route('replacement_staff.request.create_extension', $requestReplacementStaff) }}">
                          <i class="fas fa-plus"></i> Extender en Nueva Solicitud</a>
                  @endif
              </div>
          </div>

          @if($requestReplacementStaff->technicalEvaluation &&
                  $requestReplacementStaff->technicalEvaluation->commissions->count() > 0)
          <div class="card" id="commission">
              <div class="card-header">
                  <h6>Integrantes Comisión</h6>
              </div>
              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table table-sm table-bordered">
                          <thead class="text-center">
                              <tr>
                                <th>Nombre</th>
                                <th>Unidad Organizacional</th>
                                <th>Cargo</th>
                              </tr>
                          </thead>
                          <tbody >
                              @foreach($requestReplacementStaff->technicalEvaluation->commissions as $commission)
                              <tr>
                                  <td>{{ $commission->user->FullName }}</td>
                                  <td>{{ $commission->user->organizationalUnit->name }}</td>
                                  <td>{{ $commission->job_title }}</td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
              <br>
          </div>

          <br>

          @endif

          @if($requestReplacementStaff->technicalEvaluation &&
                  $requestReplacementStaff->technicalEvaluation->applicants->count() > 0)

          <div class="card" id="applicant">
              <div class="card-header">
                  <h6>Selección de RR.HH.</h6>
              </div>
              <div class="card-body">
                <h6>Postulantes a cargo(s)</h6>
                  <div class="table-responsive">
                      <table class="table table-sm table-striped table-bordered">
                          <thead class="text-center">
                              <tr>
                                <th style="width: 22%">Nombre</th>
                                <th style="width: 22%">Calificación Evaluación Psicolaboral</th>
                                <th style="width: 22%">Calificación Evaluación Técnica y/o de Apreciación Global</th>
                                <th style="width: 22%">Observaciones</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($requestReplacementStaff->technicalEvaluation->applicants->sortByDesc('score') as $applicant)
                              <tr class="{{ ($applicant->selected == 1)?'table-success':''}}">
                                  <td>{{ $applicant->replacement_staff->FullName }}</td>
                                  <td class="text-center">{{ $applicant->psycholabor_evaluation_score }} <br> {{ $applicant->PsyEvaScore }}</td>
                                  <td class="text-center">{{ $applicant->technical_evaluation_score }} <br> {{ $applicant->TechEvaScore }}</td>
                                  <td>{{ $applicant->observations }}</td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>

          <br>
          @endif

          @if($requestReplacementStaff->technicalEvaluation &&
                  $requestReplacementStaff->technicalEvaluation->technicalEvaluationFiles->count() > 0)
          <div class="card" id="file">
              <div class="card-header">
                  <h6>Adjuntos </h6>
              </div>
              <div class="card-body">
                  <div class="table-responsive">

                      <table class="table table-sm table-striped table-bordered">
                          <thead class="text-center">
                              <tr>
                                <th>Nombre Archivo</th>
                                <th>Cargado por</th>
                                <th>Fecha</th>
                                <th></th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach($requestReplacementStaff->technicalEvaluation->technicalEvaluationFiles->sortByDesc('created_at') as $technicalEvaluationFiles)
                              <tr>
                                <td>{{ $technicalEvaluationFiles->name }}</td>
                                <td>{{ $technicalEvaluationFiles->user->FullName }}</td>
                                <td>{{ $technicalEvaluationFiles->created_at->format('d-m-Y H:i:s') }}</td>
                                <td style="width: 4%">
                                    <a href="{{ route('replacement_staff.request.technical_evaluation.file.show_file', $technicalEvaluationFiles) }}"
                                      class="btn btn-outline-secondary btn-sm"
                                      title="Ir"
                                      target="_blank"> <i class="far fa-eye"></i></a>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
              <br>
          </div>
          @endif
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

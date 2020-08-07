
<table class="table table-sm table-bordered small mb-4">
    <thead>
        <tr class="text-center">
            <th class="label">Acciones y/o metas específicas</th>
            <th nowrap>Medios de Verificación</th>
            <th>Ponderación por corte <br> % de la evaluación anual</th>
        </tr>
    </thead>
    <tbody>
@for ($i = 1; $i <= 1; $i++)
        <tr class="text-center">
            <td class="text-justify">
                <ol start="{{$i}}">
                    <li>{!! $data11_3[$i]['accion'] !!}</li>
                </ol>
            </td>
            <td class="text-justify">
                <ol type="i" start="{!! $data11_3[$i]['iverificacion'] !!}">
                    <li>{!! $data11_3[$i]['verificacion'] !!}</li>
                </ol>
            </td>
            @if ($i === 1)
            <td class="align-middle text-center" rowspan="0">
            {{ $data11_3['ponderacion']  }}<br>
            {{$data11_3[$i]['anual'] }}% de la evaluación anual
            </td>
            @endif
            
        </tr>
@endfor
    </tbody>
</table>

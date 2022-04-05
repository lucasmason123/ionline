@extends('layouts.app')

@section('title', 'Reporte de Idoneidad')

@section('content')
@include('suitability.nav')

<h3 class="mb-3">Reporte de Solicitudes de Idoneidad</h3>
<form method="GET" class="form-horizontal" action="{{ route('suitability.report') }}">
    <div class="form-row">
        <fieldset class="form-group col-sm-2">
            <label>Año</label>
            <select class="form-control selectpicker show-tick" name="year" required>
                <option value="">Selección...</option>
                <option value="2021" @if($request->year == "2021") selected @endif>2021</option>
                <option value="2022" @if($request->year == "2022") selected @endif>2022</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-1">
            <label for="for_submit">&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary">Consultar</button>
        </fieldset>

<!-- 
        <fieldset class="form-group col-sm-2">
            <label>Año</label>
            <button type="submit" class="btn btn-primary float-right"> Consultar</button>
        </fieldset> -->
    </div>
</form>
@if(!empty($dataArray))
<a class="btn btn-outline-success btn-sm mb-3" id="downloadLink" onclick="exportF(this)">Descargar en excel resultados</a>
<div class="table-responsive">
    <table class="table table-sm table-bordered table-responsive text-center align-middle" id="tabla_estado_residencias">
        <thead>
            <th nowrap>N°</th>
            <th nowrap>Colegio</th>
            <th nowrap>Total Solicitudes Esperando Test</th>
            <th nowrap>Total Solicitudes Finalizadas</th>
            <th nowrap>Total Solicitudes Aprobadas</th>

        </thead>
        <tbody>
            @foreach($dataArray as $data)
            <tr>
                <td nowrap>{{$loop->iteration}}</td>
                <td nowrap>{{$data['name_school'] }}</td>
                <td nowrap>{{$data['counteresperando'] }}</td>
                <td nowrap>{{$data['counterfinalizado'] }}</td>
                <td nowrap>{{$data['counteraprobado'] }}</td>
            </tr>
            @endforeach
            <th colspan="2">Totales</th>
            <th nowrap>{{$data['sumesperando'] }}</th>
            <th nowrap>{{$data['sumfinalizado'] }}</th>
            <th nowrap>{{$data['sumaprobado'] }}</th>

        </tbody>
    </table>
</div>
@endif


@endsection

@section('custom_js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    let date = new Date()
    let day = date.getDate()
    let month = date.getMonth() + 1
    let year = date.getFullYear()
    let hour = date.getHours()
    let minute = date.getMinutes()

    function exportF(elem) {
        var table = document.getElementById("tabla_estado_residencias");
        var html = table.outerHTML;
        var html_no_links = html.replace(/<a[^>]*>|<\/a>/g, ""); //remove if u want links in your table
        var url = 'data:application/vnd.ms-excel,' + escape(html_no_links); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "reporte_idoneidad_consolidado_" + day + "_" + month + "_" + year + "_" + hour + "_" + minute + ".xls"); // Choose the file name
        return false;
    }
</script>
@endsection
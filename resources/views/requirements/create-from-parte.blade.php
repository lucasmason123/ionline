@extends('layouts.mobile')

@section('title', 'Crear requerimiento')

@section('content')


<h4 class="mb-3">
    Derivando parte <strong>{{ $parte->id }}</strong>
    <small>4 pendientes</small>
</h4>

@if($parte->files != null)
    @foreach($parte->files as $file)
        <embed src="https://drive.google.com/viewerng/viewer?embedded=true&url={{ Storage::disk('gcs')->url($file->file) }}" width="100%" height="650">
    @endforeach
@endif

<br>

<div class="form-row">
    <div class="col-md-8 col-12 d-none d-sm-block">
        @if($parte->files->first() != null)
            @foreach($parte->files as $file)
                <object type="application/pdf"
                        data="https://docs.google.com/gview?embedded=true&url={{ Storage::disk('gcs')->url($file->file) }}"
                        width="100%"
                        height="850">
                </object>
            @endforeach
        @endif
    </div>
    <div class="col-md-4 col-12">
        <form method="POST" class="form-horizontal" action="{{ route('requirements.store') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <input type="hidden" class="form-control" id="for_parte_id" name="parte_id" value="{{$parte->id}}" >

            <div class="form-row">
                <fieldset class="form-group col-12">
                    <label for="for_organizationalUnit">Establecimiento / Unidad Organizacional</label>
                    @livewire('select-organizational-unit', [
                        'establishment_id' => auth()->user()->organizationalUnit->establishment->id,
                        'mobile' => true
                    ])
                </fieldset>
            </div>

            {{-- @livewire('requirements.requirement-receivers',['parte_id' => $parte->id]) --}}


            <div class="form-row">
                <fieldset class="form-group col-12">
                    <label for="for_date">Asunto</label>
                    <textarea name="subject" id="for_subject" class="form-control" rows="3" required>{{ $parte->subject }}</textarea>
                </fieldset>
            </div>
            
            <div class="row">
                <fieldset class="form-group col-12">
                    <label for="for_date">Requerimiento</label>
                    <textarea class="form-control" id="for_body" name="body" rows="4" required></textarea>
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-6">
                    <label for="for_priority">Prioridad</label>
                    <select class="form-control" name="priority" id="priority" >
                        <option>Normal</option>
                        <option>Urgente</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-6">
                    <label for="for_limit_at">Fecha límite</label>
                    <input type="datetime-local" class="form-control" id="for_limit_at"
                           name="limit_at">
                </fieldset>
            </div>

            <div class="form-row">
                <div class="col-2">
                    <button type="submit" class="btn btn-primary form-control">
                        <i class="fas fa-arrow-circle-left"></i>
                    </button>
                </div>
                <div class="col-8">
                    <button type="submit" class="btn btn-success form-control">Derivar (4 pendientes)</button>
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary form-control">
                        <i class="fas fa-arrow-circle-right"></i>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>



@endsection

@section('custom_css')
<link href="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.3.122/web/pdf_viewer.min.css" rel="stylesheet"></link>
@endsection

@section('custom_js')
<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.3.122/build/pdf.min.js"></script>
@endsection

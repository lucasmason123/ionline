@extends('layouts.bt4.app')

@section('title', 'Gestión de Viáticos')

@section('content')

@include('allowances.partials.nav')

<h5><i class="fas fa-check-circle"></i> Gestión de viaticos:
    @if(Auth::user()->can('Allowances: contabilidad'))
        Contabilidad
    @endif
</h5>

<br />
</div>

<div class="col-sm">
    @livewire('allowances.search-allowances', [
        'index' => 'contabilidad'
    ])
</div>

@endsection

@section('custom_js')

@endsection
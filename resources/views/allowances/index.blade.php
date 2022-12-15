@extends('layouts.app')

@section('title', 'Viáticos')

@section('content')

@include('allowances.partials.nav')

<h5><i class="fas fa-file"></i> Mis viaticos</h5>
<p>Incluye Víaticos de mi Unidad Organizacional: <b>{{ Auth()->user()->organizationalUnit->name }}</p>

</div>


<div class="col-sm">
    @livewire('allowances.search-allowances', [
        'index' => 'own'
    ])
</div>


@endsection

@section('custom_js')

@endsection
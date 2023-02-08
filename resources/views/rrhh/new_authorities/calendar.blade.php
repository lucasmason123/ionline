@extends('layouts.app')

@section('title', 'Calendario de Autoridades de la Unidad Organizacional')

@section('content')

<h3 class="mb-3">Autoridades de: <small>{{ $ou->name }}</small></h3>

@livewire('profile.subrogations', [
    'organizationalUnit' => $ou,
    'hide_own_subrogation' => true,
])
<hr>

@livewire('authorities.calendar', ['organizationalUnit' => $ou])

@endsection

@section('custom_js')

@endsection
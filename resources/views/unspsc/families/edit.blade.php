@extends('layouts.app')

@section('title', 'Editar Familia')

@section('content')

@include('pharmacies.nav')

@livewire('unspsc.family.family-edit', [
    'segment' => $segment,
    'family' => $family
])

@endsection

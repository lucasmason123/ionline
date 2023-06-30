@extends('layouts.app')

@section('title', 'Editar Sumario')

@section('content')

    @include('summary.nav')

    <h3 class="mb-3">Sumario: {{ $summary->id }} - {{ $summary->subject ?? '' }}</h3>

    @include('summary.partials.header')

    @foreach ($summary->events as $event)
        @include('summary.partials.event')
    @endforeach

    @if ($summary->lastEvent->end_date && !$summary->end_at)
        @include('summary.partials.add_event')
    @endif
    
@endsection

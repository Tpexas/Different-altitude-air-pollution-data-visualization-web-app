@extends('layout')

@section('content')

@unless($reports->isEmpty())
@foreach($reports as $report)
<p>{{$report->pavadinimas}}</p>
@endforeach
@else
<p class="p-6">Neturite ataskaitų</p>
@endunless
@endsection
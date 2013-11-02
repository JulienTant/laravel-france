@extends('LvlfrDocumentation::layout')

@section('sidebar')
    {{ $menu }}
@stop

@section('documentationContent')
    {{ $document }}
@stop

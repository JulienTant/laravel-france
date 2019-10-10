@extends('layouts.master')

@section('page_class', 'ErrorPage ErrorPage--404')

@section('content')

    <div class="Error">
        <div class="Utility__Container">
        <h1>You've been 404'd !</h1>


        <p>Il n'y visiblement rien à voir dans le coin, je vous propose de <a href="/">revenir dans un endroit sûr !</a></p>
        </div>
    </div>


@endsection


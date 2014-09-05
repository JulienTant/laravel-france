@extends('LvlfrDocumentation::layout')

@section('sidebar')
    <a href="#" onclick="toggleDocVersions(); return false;" class="btn-orange changeVersionLink">Changer de version</a>


    <ul id="doc-versions">
        <li><a rel="nofollow" href="{{ action('\Lvlfr\Documentation\Controller\DocumentationController@showDocs', ['dev']) }}">Laravel Dev</a></li>
        <li><a rel="nofollow" href="{{ action('\Lvlfr\Documentation\Controller\DocumentationController@showDocs', ['4.2']) }}">Laravel 4.2</a></li>
        <li><a rel="nofollow" href="{{ action('\Lvlfr\Documentation\Controller\DocumentationController@showDocs', ['4.1']) }}">Laravel 4.1</a></li>
        <li><a rel="nofollow" href="{{ action('\Lvlfr\Documentation\Controller\DocumentationController@showDocs', ['4.0']) }}">Laravel 4.0</a></li>
        <li><a rel="nofollow" href="{{ action('\Lvlfr\Documentation\Controller\DocumentationController@showDocs', ['3']) }}">Laravel 3</a></li>
    </ul>

    {{ $menu }}
@stop

@section('documentationContent')
    {{ $document }}
@stop

@section('add_js')
<script>
$(document).ready(function() {

    $('#doc-versions').hide();
});

    $('.changeVersionLink').click(function() {
        $('#doc-versions').slideToggle();
        $(this).toggleClass('activeChangeVersionLink');
    });
</script>
@endsection

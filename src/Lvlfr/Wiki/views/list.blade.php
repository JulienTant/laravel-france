@extends('base.layout')

@section('title')
    Liste des pages - Wiki Laravel France
@endsection

@section('content')
<div class="container" id="wiki">

    <h1>Liste des pages</h1>

    <ul>
        @foreach($pages as $page)
            <li><a href="{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@index', array('slug' => $page->slug)) }}">{{ $page->title }}</a><small> dernière mise à jour le {{ $page->lastVersion->created_at->format('d/m/Y') }} par {{ $page->lastVersion->User->username }}</small></li>
        @endforeach
    </ul>
    
</div>
@endsection

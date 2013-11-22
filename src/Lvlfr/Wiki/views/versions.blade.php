@extends('base.layout')

@section('title')
    Versions de la page {{ $page->title }} - Wiki Laravel France
@endsection

@section('content')
<div class="container" id="wiki">

    <h1>{{ $page->title }}</h1>

    <ul>
        @foreach($page->versions as $version)
            <li>Version <a rel="nofollow" href="{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@index', array('slug' => $page->slug, 'version' => $version->version)) }}">#{{ $version->version }}</a> du {{ $version->created_at->format('d/m/Y H:i:s') }} par {{ $version->user->username }}</li>
        @endforeach
    </ul>
    
</div>
@endsection

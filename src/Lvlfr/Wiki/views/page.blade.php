@extends('base.layout')

@section('title')
    {{ $content->title }} - Wiki Laravel France
@endsection

@section('content')
<div class="container" id="wiki">
    <article @if($isHomepage)class="homepage"@endif>
        <header>
            <div class="page-title">
                <h1>{{ $content->title }}</h1>
                @if(!is_null($version))
                    <small>version #{{ $version }}</small>
                @endif
            </div>

            <div class="page-actions">
                <ul>
                    @if((Auth::check() && Auth::user()->canUpdateWiki()) && is_null($version) && (!$content->lock || hasRole('Wiki')))
                        <li><a class="btn-action" href="{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@edit', array('slug' => $content->slug)) }}"><i class="icon-edit"></i> Modifier</a></li>
                    @endif

                    <li><a class="btn-action" rel="nofollow" href="{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@versions', array('slug' => $content->slug)) }}"><i class="icon-time"></i> Versions</a></li>


                    @if(is_null($version) && hasRole('Wiki'))
                        @if(!$content->lock) 
                        <li><a class="btn-action" href="{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@lock', array('slug' => $content->slug)) }}"><i class="icon-unlock"></i> Cette page est déverrouillée</a></li>
                        @else
                        <li><a class="btn-action" href="{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@lock', array('slug' => $content->slug)) }}"><i class="icon-lock"></i> Cette page est verrouillée</a></li>
                        @endif
                    @endif
            </ul>
            </div>
        </header>

        <div id="page-content">{{ markdownThis($content) }}</div>
    </article>

    @if($isHomepage)
    <div class="page-actions">
        <a href="{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@listAll') }}" class="btn-action"><i class="icon-th-list"></i> Liste des pages</a>
    </div>
    @else
    <div class="page-actions">
        <a href="{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@index') }}" class="btn-action"><i class="icon-home"></i> Page d'accueil</a>
    </div>    @endif

</div>
@endsection

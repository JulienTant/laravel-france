@extends('base.layout')

@section('title')
    {{ $content->title }} - Wiki Laravel France
@endsection

@section('content')
<div class="container" id="wiki">
    <article @if($isHomepage)class="homepage"@endif>
        <header>
            <h1 class="page-title">
                {{ $content->title }}
            </h1>

            <div class="page-actions">
                <ul>
                    <li><a class="btn-action" href="{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@edit', array('slug' => $content->slug)) }}"><i class="icon-edit"></i> Modifier</a></li>

                    <li><a class="btn-action" rel="nofollow" href="{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@versions', array('slug' => $content->slug)) }}"><i class="icon-time"></i> Versions</a></li>
            </ul>
            </div>
        </header>

        <div id="page-content">{{ markdownThis($content) }}</div>
    </article>

    @if($isHomepage)
    <div class="page-actions">
        <a href="{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@listAll') }}" class="btn-action"><i class="icon-th-list"></i> Liste des pages</a>
    </div>
    @endif

</div>
@endsection

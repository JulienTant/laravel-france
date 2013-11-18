@extends('base.layout')

@section('content')
<div class="container" id="wiki">
    <article>
        <header>
            <h1>
                {{ $content->title }}
            </h1>
        </header>

        <div>{{ markdownThis($content) }}</div>

        <footer>
            <ul>
                <li><a href="{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@edit', array('slug' => $content->slug)) }}">Modifier</a></li>
                <li><a href="{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@versions', array('slug' => $content->slug)) }}">Versions</a></li>
            </ul>
        </footer>
    </article>
</div>
@endsection

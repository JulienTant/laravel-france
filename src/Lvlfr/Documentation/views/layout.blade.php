@extends('base.layout')

@section('title')
    {{ $title }} - Documentation Laravel {{ $version }} - Laravel France
@endsection

@section('content')
<div class="container" id="pageDoc">

    <div class="sidebar">
        @yield('sidebar')
    </div>

    <div class="documentationContent">

        <div class="alert">
            <p>Attention. La traduction de la documentation n'est plus à jour depuis Septembre 2014. Pour avoir les informations à jour, rendez vous sur la <a href="http://laravel.com/docs" target="_blank">documentation officielle de Laravel</a>.</p>
            <p><a href="http://forums.laravel.fr/vers-la-fin-de-la-mise-a-disposition-de-la-documentation-francaise-t428">Avoir plus d'informations à ce sujet</a></p>
        </div>

        @yield('documentationContent')

        <hr />
        <ul class="PrevNextPage">
            @if($prev)
                <li class="prev"><a href="{{ $prev['URI'] }}" class="btn-orange">&lArr; {{ $prev['title'] }}</a></li>
            @else
                <li class="prev empty"></li>
            @endif

            @if($next)
                <li class="next"><a href="{{ $next['URI'] }}" class="btn-orange">{{ $next['title'] }} &rArr;</a></li>
            @else
                <li class="next empty"></li>
            @endif
        </ul>
    </div>

</div>
@endsection

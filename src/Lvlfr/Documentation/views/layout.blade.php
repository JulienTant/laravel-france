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
        @yield('documentationContent')

        <ul class="PrevNextPage">
            @if($prev)
                <li class="prev"><a href="{{ $prev['URI'] }}">&lArr; {{ $prev['title'] }}</a></li>
            @else
                <li class="prev empty"></li>
            @endif

            @if($next)
                <li class="next"><a href="{{ $next['URI'] }}">{{ $next['title'] }} &rArr;</a></li>
            @else
                <li class="next empty"></li>
            @endif
        </ul>
    </div>

</div>
@endsection

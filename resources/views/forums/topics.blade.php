@extends('layouts.forums')

@section('forums_content')

    <div class="Forums__Searchbar">
        <form action="{{ route('forums.search') }}">
            @if($chosenCategory)
                <input type="hidden" name="c" value="{{ $chosenCategory ? $chosenCategory->slug : '' }}" />
            @endif
            <input type="text" class="Forums__Searchbar__Field" name="q" value="{{ Request::get('q') }}" placeholder="Rechercher{{ $chosenCategory ? ' dans ' . $chosenCategory->name : '' }}" />
        </form>
    </div>

    <ul class="Forums__TopicList">
        @foreach($topics as $topic)
            @include('forums._topic_in_list', ['topic' => $topic])
        @endforeach
    </ul>


    <div class="Forums__Paginator">
        {!! $topics->render() !!}
    </div>

@endsection
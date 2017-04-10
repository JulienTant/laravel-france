@extends('layouts.forums_sidebar')

@section('title', 'Forums'. ($chosenCategory ? ' - ' .$chosenCategory->name : ''). ' - Laravel France')

@section('forums_content')


    <ul class="Forums__TopicList">
        @each('forums._topic_in_list', $topics, 'topic')
    </ul>


    <div class="Forums__Paginator">
        {!! $topics->render() !!}
    </div>

@endsection
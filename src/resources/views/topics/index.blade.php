@extends('layouts.forums_list')

@section('content')
    @each('topics._topic_in_list', $topics, 'topic')
@endsection

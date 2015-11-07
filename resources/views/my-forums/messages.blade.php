@extends('layouts.forums_sidebar')

@section('title', 'Forums - Sujets suivis - Laravel France')

@section('forums_content')


    <ul class="Forums__MyMessages">
        @each('my-forums._messages_in_list', $messages, 'message')
    </ul>


    <div class="Forums__Pagination">
        {!! $messages->render() !!}
    </div>

@endsection
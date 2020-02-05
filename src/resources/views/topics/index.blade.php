@extends('layouts.forums_list')

@section('content')

    <form action="{{ route('search') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Rechercher" name="q"  value="{{ request('q') }}">
            @if($chosenCategory != null)
                <input type="hidden" class="form-control" placeholder="Rechercher" name="forum_category_id"  value="{{ $chosenCategory->id }}">
            @endif

            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>


    @each('topics._topic_in_list', $topics, 'topic')
@endsection

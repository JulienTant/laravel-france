@extends('layouts.general')

@section('title', 'Recherche')

@section('main_content')

    @if($chosenCategory != null)
        <div class="category-banner" style="background-color: {{ $chosenCategory->background_color }}; color: {{ $chosenCategory->font_color }}">
            <div class="container">
                <h2>{{ $chosenCategory->name }}</h2>
                <p>{!! $chosenCategory->description !!}</p>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-3">
                @include('layouts.forums_sidebar')
            </div>

            <div class="col-md-9">

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

                <p class="text-right">
                    Powered by <a href="https://algolia.com" target="_blank" style="color: #5468ff" class="font-weight-bold">Algolia</a>
                </p>


            @foreach($messages as $message)

                    <div class="card mt-3">
                        <div class="card-header"><a href="{{ route('topics.show', [$message->forumsTopic->forumsCategory->slug, $message->forumsTopic->slug]) }}" class="font-weight-bold">{{ $message->forumsTopic->title }}</a><br/><i class="fa fa-user"></i> {{ $message->forumsTopic->user->username }} <i class="fa fa-clock-o"></i> {{ $message->forumsTopic->lastMessage->created_at->diffForHumans() }} </div>
                        <div class="card-body">
                            @markdown($message->markdown)
                            <p class="mb-0">
                                <a href="{{ route('messages.show', ['messageId' => $message->id]) }}">Voir le message <i class="fa fa-long-arrow-right"></i> </a>
                            </p>
                        </div>
                    </div>
                @endforeach

                <div class="topics-pagination">
                    {!! $messages->links() !!}
                </div>

            </div>
        </div>
    </div>
@endsection


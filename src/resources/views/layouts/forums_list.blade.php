@extends('layouts.general')

@section('title', 'Forums' . ($chosenCategory ?  ' - ' .$chosenCategory->name : ''))

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
                @can('forums.can_create_topic')
                <div class="mb-4">
                    <a href="{{ route('topics.create') }}" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Créer un sujet</a>
                </div>
                @endcan

                <ul class="category-list">
                    <li><a href="{{ route('topics.index') }}"><span class="category-color"></span> Toutes les catégories</a></li>
                    @foreach($categories as $category)
                        <li><a href="{{ route('topics.by-category', ['slug' => $category->slug]) }}"><span class="category-color" style="background-color: {{$category->background_color}}"></span> {{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-9">
                @yield('content')

                <div class="topics-pagination">
                    {!! $topics->links() !!}
                </div>

            </div>
        </div>
    </div>
@endsection

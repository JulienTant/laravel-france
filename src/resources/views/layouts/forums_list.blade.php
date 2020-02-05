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
                @include('layouts.forums_sidebar')
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

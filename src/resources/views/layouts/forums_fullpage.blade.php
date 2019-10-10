@extends('layouts.master')

@section('page_class', 'PageForums PageForums--Fullpage')

@section('content')

<div class="Forums Forums--Fullpage">

    @section('top_forums')
        @if(isset($chosenCategory))
            <div class="Forums_ChosenCategory" style="background-color: {{ $chosenCategory->background_color }}; color: {{ $chosenCategory->font_color }};">
                <div class="Utility__Container">
                    <h2>{{ $chosenCategory->name }}</h2>
                    <p>
                        {!! $chosenCategory->description !!}
                    </p>
                </div>
            </div>
        @endif
    @show

    <div class="Utility__Container">
        <section class="Forums__Content">
            @yield('forums_content')
        </section>



    </div>
</div>


@endsection


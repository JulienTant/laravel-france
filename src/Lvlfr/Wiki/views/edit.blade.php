@extends('base.layout')

@section('title')
    @if(!$content->id || Auth::user()->hasRole('Wiki'))
        Création d'un article - Wiki Laravel France
    @else
        Edition d'un article - Wiki Laravel France
    @endif
@endsection

@section('content')
<div class="container" id="wiki">
    
    @if(count($errors))
        <ul class="errors">
        @foreach($errors->all("<li class='error'>:message</li>") as $error)
            {{ $error }}
        @endforeach
        </ul>
    @endif


    {{ Form::open() }}
        <div class="form-line">
            {{ Form::label('title', 'Title') }}
            <div class="form-item">
                {{ Form::text('title', Input::old('title') ?: $content->title) }}
            </div>
        </div>

        @if(!$content->id || Auth::user()->hasRole('Wiki'))
        <div class="form-line">
            {{ Form::label('slug', 'Slug') }}
            <div class="form-item">
                {{ Form::text('slug', Input::old('slug', Input::get('slug')) ?: $content->slug) }}
            </div>
        </div>
        @endif
        <div class="form-line">
            {{ Form::label('content', 'Contenu') }}
            <div class="form-item wmd-panel">
                <div id="wmd-button-bar"></div>
                {{ Form::textarea('content', Input::old('content') ?: $content, ["class"=>"wmd-input", "id"=>"wmd-input"]) }}
            </div>
        </div>
        <div id="wmd-preview" class="wmd-panel wmd-preview"></div>


        {{ Form::submit('Valider')}}

    {{ Form::close()}}
</div>
@endsection

@section("add_css")
<link rel="stylesheet" href="/js/pagedown/pagedown.css">
@endsection

@section("add_js")
<script type="text/javascript" src="/js/pagedown/Markdown.Converter.js"></script>
<script type="text/javascript" src="/js/pagedown/Markdown.Sanitizer.js"></script>
<script type="text/javascript" src="/js/pagedown/Markdown.Editor.js"></script>
<script type="text/javascript">
(function () {
    var converter1 = Markdown.getSanitizingConverter();        
    var editor1 = new Markdown.Editor(converter1);
    editor1.run();
})();
</script>

@endsection

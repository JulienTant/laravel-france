@extends('base.layout')

@section('title')
    Diff d'un article - Wiki Laravel France
@endsection

@section('content')
<div class="container" id="wiki">

    <h1>Différences de versions sur la page "{{ $page->title }}" entre les versions {{ $page->version }} et {{ ($page->version)-1 }} </h1>

    {{ $diff ?: 'Aucune différence' }}

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

<h3>Répondre au sujet</h3>

<a name="answer_form" id="answer_form"></a>
<form method="post" action="{{ route('messages.store', [$category->slug, $topic->slug]) }}">
    @csrf

    <div class="form-group">
        <label for="markdown_input">Message</label>
        @error('markdown')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <textarea name="markdown" id="markdown_input" class="form-control editor-please"></textarea>
    </div>

    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-comment"></i> Répondre</button>
    <div class="clearfix"></div>
</form>

@extends('layouts.general')

@section('title', 'Éditer mon message')

@section('main_content')
    <div class="container mt-5">
        <h2>Éditer mon message</h2>

        <form method="POST" action="{{ route('messages.update', [$category->slug, $topic->slug, $message->id]) }}">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="markdown">Message</label>
                @error('markdown')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <textarea name="markdown" id="markdown" class="form-control editor-please @error('title') is-invalid @enderror">{!! old('markdown', $message->markdown) !!}</textarea>
            </div>

            <div>
                <a class="btn btn-outline-primary" href="{{ Request::get('from', URL::previous()) }}"><i class="fa fa-arrow-left"></i> Annuler</a>
                <div class="float-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i> Éditer</button>
                </div>
                <div class="clearfix"></div>


        </form>
    </div>

@endsection

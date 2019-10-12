@extends('layouts.general')

@section('title', $topic->title)


@section('main_content')

    <div class="container mt-5">

        <h2>Souhaitez vous supprimer ce message ?</h2>

        <div class="message-list">
            @include('topics._message', ['topic' => $topic, 'category' => $category, 'message' => $message, 'noButton' => true])
        </div>

        <div>
            <a class="btn btn-outline-primary" href="{{ Request::get('from', URL::previous()) }}"><i class="fa fa-arrow-left"></i> Annuler</a>
            <div class="float-right">
                <a class="btn btn-primary" href="{{ route('messages.edit', [$category->slug, $topic->slug, $message->id]) }}"><i class="fa fa-pencil"></i> Editer</a>
                <form method="POST" action="{{ route('messages.delete', [$category->slug, $topic->slug, $message->id]) }}" class="d-inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger" href="{{ URL::previous() }}"><i class="fa fa-trash"></i>Supprimer</button>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection

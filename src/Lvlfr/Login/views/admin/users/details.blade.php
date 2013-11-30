@extends('LvlfrLogin::profile.layout')

@section('title')
    Utilisateur - Laravel France
@endsection

@section('profile_content')
    <h1>Modifier un utilisateur</h1>

    <h2>#{{ $user->id }} - {{ $user->username }}</h2>
    <h3>Général</h3>
    {{ Form::open() }}
        <div class="form-line">
            {{ Form::label('username', 'Pseudo* :')}}
            <div class="form-item">
                {{ Form::text('username', Input::old('username', $user->username), ['required' => 'required']) }}
                @if ($errors->has('username'))
                <span class="error">{{ $errors->first('username') }}</span>
                @endif
            </div>
        </div>

        <div class="form-line">
            {{ Form::label('email', 'Email* :')}}
            <div class="form-item">
                {{ Form::text('email', Input::old('email', $user->email), ['required' => 'required']) }}
                @if ($errors->has('email'))
                <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>
        </div>

        <div class="form-line">
            {{ Form::label('canUpdateWiki', 'Peut modifier le wiki ? :')}}
            <div class="form-item">
                {{ Form::checkbox('canUpdateWiki', 1, Input::old('canUpdateWiki', $user->canUpdateWiki)) }}
                @if ($errors->has('canUpdateWiki'))
                <span class="error">{{ $errors->first('canUpdateWiki') }}</span>
                @endif
            </div>
        </div>
        {{ Form::submit('Valider') }}

    {{ Form::close() }}

    <h3>Groupes</h3>
    @if($user->id == 1)
        <strong>Impossible de changer cet utilisateur</strong>
    @else
    {{ Form::open(['url' => action('Lvlfr\Login\Controller\Admin\UsersController@postGroups', array($user->id))]) }}
        <ul>
            @foreach($groups as $group)
            <li>
                {{ Form::checkbox('groups[]', $group->id, $user->hasRole(intval($group->id))) }} {{ $group->name }}
            </li>
            @endforeach
        </ul>

        {{ Form::submit('Valider') }}

    {{ Form::close() }}
    @endif


@endsection


@extends('layouts.profile')

@section('title', 'Changer mon pseudo')


@section('content')
    <h2>Modifier mon pseudo</h2>

    <p>Vous pouvez choisir un nouveau pseudo si vous le souhaitez :</p>

    <form method="post" class="form">
    @csrf

        <div class="form-group">
            <label for="username">Pseudo</label>
            @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="text" name="username" id="username" value="{{ old('username', Auth::user()->username) }}" class="form-control @error('username') is-invalid @enderror" />

        </div>

        <button class="btn btn-primary" type="submit">Enregistrer</button>
    </form>
@endsection

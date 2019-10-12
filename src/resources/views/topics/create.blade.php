@extends('layouts.general')

@section('title', 'Créer un sujet')

@section('main_content')
    <div class="container mt-5">
        <h2>Créer un sujet</h2>

        <form method="POST" action="{{ route('topics.store') }}">
            @csrf

            <div class="form-group">
                <label for="title">Titre</label>
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Titre" value="{{ old('title') }}">
            </div>

            <div class="form-group">
                <label for="category">Catégorie</label>
                @error('category')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <select name="category" id="category" class="form-control @error('title') is-invalid @enderror">
                    <option value="">Veuillez sélectionner une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category') ==  $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="markdown">Message</label>
                @error('markdown')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <textarea name="markdown" id="markdown" class="form-control editor-please @error('title') is-invalid @enderror">{!! old('markdown') !!}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
    </div>

@endsection

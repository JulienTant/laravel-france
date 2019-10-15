@extends('layouts.general')

@section('title', 'Mon profil')

@section('main_content')

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-3">
                @include('users._sidebar')
            </div>

            <div class="col-md-9">
                @yield('content')
            </div>
        </div>
    </div>
@endsection

@extends('layouts.master')

@section('page_class', 'PageProfile')

@section('content')
<div class="Profile">
    <div class="Utility__Container">
        @include('profile._sidebar')
        <section class="Profile__Content">
            @yield('profile_content')
        </section>
    </div>
</div>
@endsection


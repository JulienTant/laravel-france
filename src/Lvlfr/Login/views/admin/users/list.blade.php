@extends('LvlfrLogin::profile.layout')

@section('profile_content')
    <h1>Modifier les catégories</h1>

    <table style="width:100%">
        <thead>
            <tr>
                <th>id</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Date de création</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
        <tr>
            <td>#{{ $user->id }}</td>
            <td><a href="#">{{ $user->username }}</a></td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at->format('d-m-Y') }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection


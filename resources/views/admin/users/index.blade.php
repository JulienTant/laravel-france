@extends('layouts.profile')


@section('profile_content')

    <h2>Gestion des utilisateurs</h2>

    <table style="width: 100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pseudo</th>
                <th>Rôles</th>
                <th>Messages</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ implode(', ', $user->groups) ?: '-' }}</td>
                    <td>{{ $user->nb_messages }}</td>
                    <td>
                        <a href="{{ route('admin.users.groups', [$user->id]) }}">Groupes</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
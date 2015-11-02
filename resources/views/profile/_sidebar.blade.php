<aside class="Profile__Sidebar">


    <nav>
        <h3>Mon profil</h3>
        <ul>
            <li>
                <a href="{{ route('profile.change-username') }}">Changer mon pseudo</a>
            </li>
            <li>
                <a href="{{ route('profile.change-avatar') }}">Changer mon avatar</a>
            </li>
        </ul>
    </nav>

    @can('admin.manage_users')
        <nav>
            <h3>Utilisateurs</h3>
            <ul>
                <li>
                    <a href="{{ route('admin.users.index') }}">Liste des utilisateurs</a>
                </li>
            </ul>
        </nav>
    @endcan

</aside>
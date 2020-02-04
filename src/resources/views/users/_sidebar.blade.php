<aside class="Profile__Sidebar">


    <nav>
        <h3>Mon profil</h3>
        <ul>
            <li>
                <a href="{{ route('user.forums-preferences') }}">Préférences des forums</a>
            </li>
            <li>
                <a href="{{ route('user.change-username') }}">Changer mon pseudo</a>
            </li>
            <li>
                <a href="{{ route('user.change-email') }}">Changer mon avatar</a>
            </li>
            <li>
                <a href="{{ route('user.change-email') }}">Changer mon email</a>
            </li>
        </ul>
    </nav>

    @can('admin.manage_users')
        <nav>
            <h3>Utilisateurs</h3>
            <ul>
                <li>
                    @php
//                   <a href="{{ route('admin.users.index') }}">Liste des utilisateurs</a>
                    @endphp
                </li>
            </ul>
        </nav>
    @endcan

</aside>

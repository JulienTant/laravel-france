<aside class="Forums__Sidebar">

    @if(Auth::user())
        @can('forums.can_create_topic', isset($chosenCategory) ? $chosenCategory : null)
            <new-topic {{ isset($chosenCategory) ? 'current_category='.$chosenCategory->id : '' }} categories="{{ $categories->toJson() }}">Créer un sujet</new-topic>
        @endcan
    @else
        <button class="Button Button--NewTopic" @click="showLoginBox = true">Se connecter</button>
    @endif

    <ul class="Forums__Sidebar__CategoriesList">
        <li class="Forums__Sidebar__CategoriesList__Item Forums__Sidebar__CategoriesList__Item--All">
            <a href="{{ route('forums.index') }}">Toutes les catégories</a>
        </li>
        @foreach($categories as $category)
            <li class="Forums__Sidebar__CategoriesList__Item">
                <a href="{{ route('forums.by-category', [$category->slug]) }}">
                    <span class="Forums__Sidebar__CategoriesList__Item__Color" style="background-color: {{ $category->background_color }}"></span>
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>

    @if(Auth::check())
        <hr />
        <h3>Mon Espace</h3>
        <ul class="Forums__Sidebar__MyForum">
            <li class="">
                <a href="{{ route('my-forums.watched-topics') }}">
                    Sujets suivis
                    @if($nbUnreadWatchers > 0)
                        <span class="Badge Badge-Orange">{{ $nbUnreadWatchers }}</span>
                    @endif
                </a>
            </li>
            <li class="">
                <a href="{{ route('my-forums.my-topics') }}">Mes sujets</a>
            </li>
            <li class="">
                <a href="{{ route('my-forums.my-messages') }}">Mes messages</a>
            </li>
        </ul>
    @endif
</aside>
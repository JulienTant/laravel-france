<aside class="Forums__Sidebar">

    @if(Auth::user())
        <new-topic>Créer un sujet</new-topic>
    @else
        <a href="#" class="Button Button_NewTopic">Se connecter</a>
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
</aside>
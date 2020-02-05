@can('forums.can_create_topic')
    <div class="mb-4">
        <a href="{{ route('topics.create') }}" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Créer un sujet</a>
    </div>
@endcan

<ul class="category-list">
    <li><a href="{{ route('topics.index') }}"><span class="category-color"></span> Toutes les catégories</a></li>
    @foreach($categories as $category)
        <li><a href="{{ route('topics.by-category', ['slug' => $category->slug]) }}"><span class="category-color" style="background-color: {{$category->background_color}}"></span> {{ $category->name }}</a></li>
    @endforeach
</ul>

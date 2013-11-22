@extends('LvlfrLogin::profile.layout')

@section('title')
    Modifier les catégories des forums - Laravel France
@endsection

@section('profile_content')
    <h1>Modifier les catégories</h1>

    <ul id="adminCatList">
        @foreach($categories as $category)
        <li>
            <form method="POST">
                <input type="hidden" name="id" value="{{ $category->id }}" />
                

                Titre : <input type="text" name="title" value="{{ $category->title }}" placeholder="Titre" />
                Ordre : <input type="number" name="order" value="{{ $category->order }}" /> <br />

                <textarea name="desc" style="width:95%; margin-top:10px; margin-bottom:10px;">{{ $category->desc }}</textarea><br />
                
                <input type="submit" value="Envoyer" />
            </form>
        </li>
        @endforeach
        <h2>Nouvelle entrée :</h2>
        <li id="newRow">
            <form method="POST">
                <input type="hidden" name="id" value="-1" />
                

                Titre : <input type="text" name="title" value="" placeholder="Titre" />
                Ordre : <input type="number" name="order" value="" /> <br />

                <textarea name="desc" style="width:95%; margin-top:10px; margin-bottom:10px;"></textarea><br />
                
                <input type="submit" value="Envoyer" />
            </form>
        </li>
    </ul>

    
<style>
#adminCatList li {
    list-style-type: none;
    padding:10px;
    background-color: rgb(255, 252, 249);
    border: 1px solid #ddd;
    margin-bottom:2px;
}
#adminCatList li:nth-child(2n) {
    background-color: rgb(250, 242, 234);
}
</style>
    
@endsection


@extends('base.layout')

@section('content')
<div class="orangebox">
    <div class="container">
        <div class="col">
            <h2>En direct des forums</h2>
            <ul>
                @foreach($topics as $topic)
                <li><a href="{{ action('\Lvlfr\Forums\Controller\TopicsController@moveToLast', array($topic->slug, $topic->id), true) }}" title="{{ $topic->title }} - Dans : {{ $topic->category->title }}" class="forum-link">{{ $topic->title }}</a> <small>{{ diffForHumans($topic->updated_at); }}</small></li>
                @endforeach
            </ul>
        </div>
        <div class="col">
            <a class="download" href="http://docs.laraveldev.fr/4.0/quick">
                <i class="icon-rocket"></i> Démarrage rapide
            </a>
        </div>
    </div>
</div>

<div class="container" id="indexPage">
    <section>
        <h2>Un framework PHP élégant, puissant et robuste</h2>

        <p>
            Disponible aujourd'hui dans sa quatrième version, le framework Laravel créé par <a href="https://github.com/taylorotwell" target="_blank">Taylor Otwell</a> en 2011 remporte un franc succès grâce à des atouts qui le rendent unique. Depuis le début, l'objectif du framework est de rendre le développement fun à nouveau, en fournissant aux développeurs les outils dont ils ont besoin pour travailler efficacement sur leurs projets.
        </p>
    </section>

    
        <section>
            <h2>Rapide à mettre en place</h2>
            <p>Grâce à composer, vous pouvez créer un projet Laravel en une simple commande :</p>

<pre class="prettyprint">
$ composer create-project laravel/laravel nom-de-votre-projet
</pre>
        </section>

        <section>
            <h2>Simple</h2>
            <p>Laravel est simple, voyez par vous même :</p>

<pre class="prettyprint">
Route::get('user/{id}', function($id)
    // On récupère l'utilisateur
    $user = User::find($id);

    // Retourne une vue, en lui passant l'utilisateur
    return View::make('user.show')->with('user', $user);
});</pre>
        </section>

        <section>
            <h2>Intuitif</h2>
            <p>Laravel est intuitif, "<span class="inline-quote" title="Phill Sparks">Il parle votre langue</span>" :</p>
<pre class="prettyprint lang-php">
Route::post('login', function() {
    // On récupère les données du formulaire
    $userdata = array(
        'username' => Input::get('username'),
        'password' => Input::get('password')
    );

    if (Auth::attempt($userdata)) {
        // Nous redirigeons l'utilisateur vers la page où il souhaitait aller,
        // Ou par défaut, sur la route nommée 'home'
        return Redirect::intended('home');
    } else {
        // Redirection vers login
        return Redirect::to('login')
            ->with('login_errors', true);
    }
});
</pre>
        </section>

        <section>
            <h2>Puissant</h2>
            <p>Laravel nous offre des outils puissants ET simple d'utilisation :</p>
<pre class="prettyprint lang-php">
// application/start.php
App::singleton('monWebService', function()
{
    return new ClasseDeMonWebService();
});

// dans votre controller, par exemple
$monMailer = IoC::resolve('mailer');
</pre>
        </section>


        <section>
            <h2>Flexible</h2>
            <p>Laravel est flexible grace à son utilisation de composer, qui nous permet d'installer des packages en une simple commande :</p>
<pre class="prettyprint lang-php">
// Besoin d'utiliser oauth2 ?
$ composer require t4s/camelot-auth dev-master
</pre>
        </section>

</div>
@stop

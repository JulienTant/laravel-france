# Templating

## Au menu

- [Les bases](#the-basics)
- [Sections](#sections)
- [Le moteur de template Blade](#blade-template-engine)
- [Les structures de contrôle de Blade](#blade-control-structures)
- [Blade Layouts](#blade-layouts)

<a name="the-basics"></a>
## Les base

Votre application utilise probablement un layout global, qui se retrouve sur toutes vos pages. Créer manuellement ce layout pour chaque vue peut être une vrai plaie. Préciser à un contrôleur un layout spécifique va rendre votre développement plus jouissif. Voilà comment faire :

#### Spécifie la propriété "layout" à votre contrôleur :

	class Base_Controller extends Controller {

		public $layout = 'layouts.common';

	}

#### Accès au layout depuis l'action d'un contrôleur :

	public function action_profile()
	{
		$this->layout->nest('content', 'user.profile');
	}

> **Note:** Quand vous utilisez les layouts dans vos contrôleurs, les action n'ont pas besoin de retourner quoi que ce soit.

<a name="sections"></a>
## Sections

Les sections de vues fournissent une manière simple d'injecter du contenu dans un layout, depuis une "simple" vue. Par exemple, vous souhaitez peut-être injecter dans du javascript depuis votre vue vers le layout. Voyons comment faire :

#### Création d'une section dans notre vue :

	<?php Section::start('scripts'); ?>
		<script src="jquery.js"></script>
	<?php Section::stop(); ?>

#### Ecriture du contenu d'une section, dans notre layout :

	<head>
		<?php echo Section::yield('scripts'); ?>
	</head>

#### Utilisation des fonctions de Blade pour utiliser les sections :

	@section('scripts')
		<script src="jquery.js"></script>
	@endsection

	<head>
		@yield('scripts')
	</head>

<a name="blade-template-engine"></a>
## Le moteur de template Blade

Avec Blade, l'écriture de vos vues sera un pur bonheur ! Pour créez une vue blade, mettez simplement en extension de fichier ".blade.php". Blade vous autorise à utiliser une syntaxe magnifique et légère pour écrire des structures de contrôle PHP et pour afficher des données. Voici un exemple :

#### Affichage d'une variable avec Blade :

	Bonjour, {{ $name }}.

#### Affichage des assets avec Blade :

	{{ Asset::styles() }}

#### Inclusions d'une vue :

Vous pouvez utiliser **@include** pour inclure une vue dans une autre. La vue incluse a accès à toutes les variables de la vue actuelle.

	<h1>Profil</hi>
	@include('user.profile')

De la même manière, vous pouvez utiliser **@render**, qui a le même comportement que **@include**, mis à part que la vue incluse n'aura **aucun** accès aux données de la vue courante.

	@render('admin.list')

#### Commentaires avec Blade :

	{{-- This is a comment --}}

	{{--
		This is a
		multi-line
		comment.
	--}}

> **Note:** Les commentaires Blade ne sont pas des commentaires HTML : ils n'apparaissent pas dans les sources HTML.

<a name='blade-control-structures'></a>
## Les structures de contrôles

#### Boucle for :

	@for ($i = 0; $i <= count($comments); $i++)
		Le texte du commentaire est : {{ $comments[$i] }}
	@endfor

#### Boucle foreach :

	@foreach ($comments as $comment)
		Le texte du commentaire est : {{ $comment->body }}.
	@endforeach

#### Boucle while :

	@while ($something)
	   Ça boucle !
	@endwhile

#### If :

	@if ( $message == true )
		J'affiche le message !
	@endif

#### If Else :

	@if (count($comments) > 0)
		Il y a des commentaires!
	@else
		il n'y a aucun commentaires!
	@endif

#### Else If :

	@if ( $message == 'success' )
		Ce fut un succès !
	@elseif ( $message == 'error' )
		Une erreur s'est produite.
	@else
		Est-ce que ça a marché ?
	@endif

#### Forelse & Empty:

	@forelse ($posts as $post)
		{{ $post->body }}
	@empty
		Il n'y a aucun post!
	@endforelse

#### Unless ( A moins que ):

	@unless(Auth::check())
		Login
	@endunless

	// Équivalent à...

	<?php if ( ! Auth::check()): ?>
		Login
	<?php endif; ?>

<a name="blade-layouts"></a>
## Les layouts avec Blade

Blade ne fournit pas qu'une syntaxe claire et élégante pour les contrôles PHP les plus communs, il fournit également une méthode merveilleuse pour utiliser des layouts pour nos vues. Par exemple, votre application pourrait utiliser une vue "master" qui contient le *look and feel* global de votre application. Cela donnerait quelque chose comme ça :

	<html>
		<ul class="navigation">
			@section('navigation')
            <li>Example Item 1</li>
            <li>Example Item 2</li>
            @endsection
		</ul>

		<div class="content">
			@yield('content')
		</div>
	</html>

Remarquez la section "content", celle-ci contiendra le contenu de votre vue. Pour remplir cette section, créez une vue qui utilise "master" en tant que layout :

	@layout('master')

	@section('content')
		Bienvenue sur ma page de profil !
	@endsection

Maintenant, nous pouvons simplement retourner la vue "profile" via notre route, ou notre contrôleur. 

	return View::make('profile');

La vue "profile" utilisera automatiquement "master" en tant que layout grâce à la fonction **@layout** de Blade.

> **Important:** La fonction **@layout** doit TOUJOURS être appelée à la toute première ligne de code du fichier.

#### Ajout de contenu à une section avec @parent

Parfois, vous pouvez ajouter du contenu à une section, plutôt que de l'écraser entièrement. Par exemple, regardez la section "navigation" dans notre layout "master". Disons que nous souhaitons simplement y ajouter du contenu. Voilà à quoi ressemblerait au final notre vue profile :

	@layout('master')

	@section('navigation')
		@parent
		<li>Nav Item 3</li>
	@endsection

	@section('content')
        Bienvenue sur ma page de profil !
	@endsection

**@parent** sera remplacé par le contenu de la section navigation du layout, vous fournissant une méthode magnifique et puissante pour étendre votre layout.

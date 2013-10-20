# Templates

- [Layouts de contrôleur](#controller-layouts)
- [Blade Templating](#blade-templating)
- [Other Blade Control Structures](#other-blade-control-structures)

<a name="controller-layouts"></a>
## Layouts de contrôleur

Une méthode pour utiliser les templates dans Laravel est d'utiliser les layouts de contrôleur. En spécifiant la propriété `layout` sur un contrôleur, la vue spécifiée sera créée pour vous et sera utilisée en tant que réponse aux actions.

**Définition d'un layout sur un contrôleur**

	class UserController extends BaseController {

		/**
		 * The layout that should be used for responses.
		 */
		protected $layout = 'layouts.master';

		/**
		 * Show the user profile.
		 */
		public function showProfile()
		{
			$this->layout->content = View::make('user.profile');
		}

	}

<a name="blade-templating"></a>
## Le moteur de template Blade

Blade est un moteur de template simple et puissant fourni par Laravel. A la différence des layouts de contrôleurs, Blade est conduit par _l'héritage de template_ et _les sections_. Les templates Blade doivent avoir comme extension `.blade.php`.

**Définition d'un layout Blade**

	<!-- app/views/layouts/master.blade.php -->

	<html>
		<body>
			@section('sidebar')
				This is the master sidebar.
			@show

			<div class="container">
				@yield('content')
			</div>
		</body>
	</html>

**Utilisation d'un layout Blade**

	@extends('layouts.master')

	@section('sidebar')
		@parent

		<p>This is appended to the master sidebar.</p>
	@stop

	@section('content')
		<p>This is my body content.</p>
	@stop

Notez que les vues qui `extend` un layout Blade surchargent simplement les sections du layout. Le contenu du layout peut être inclus dans une vue enfant en utilisant la directive `@parent` dans une section, vous permettant d'ajouter dans le contenu du layout votre propre contenu, pour par exemple ajouter des liens dans la sidebar ou dans le footer.

<a name="other-blade-control-structures"></a>
## Structures de contrôle Blade

**Affichage de données**

	Hello, {{ $name }}.

	The current UNIX timestamp is {{ time() }}.

Pour échapper la sortie, utilisez trois accollades :

	Hello, {{{ $name }}}.

**Déclaration If**

    @if (count($records) === 1)
        I have one record!
    @elseif (count($records) > 1)
        I have multiple records!
	@else
		I don't have any records!
	@endif

	@unless (Auth::check())
		You are not signed in.
	@endunless

**Boucles**

	@for ($i = 0; $i < 10; $i++)
		The current value is {{ $i }}
	@endfor

	@foreach ($users as $user)
		<p>This is user {{ $user->id }}</p>
	@endforeach

	@while (true)
		<p>I'm looping forever.</p>
	@endwhile

**Inclusion d'une sous-vue**

	@include('view.name')

**Affichage d'une ligne de langue**

	@lang('language.line')

	@choice('language.line', 1);

**Commentaires**

	{{-- This comment will not be in the rendered HTML --}}

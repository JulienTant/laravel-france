@extends('layouts.profile')


@section('title', 'Changer mon email')

@section('content')

    <h2>Modifier mon avatar / Email</h2>

    <p>
        <a href="http://laravel.fr">Laravel.fr</a> utilise le service <a target="_blank" href="http://fr.gravatar.com/">Gravatar</a> pour charger les avatars sur le forum.
    </p>

    <p>
        Pour obtenir l'avatar de votre choix, vous devez remplir une adresse email valide enregistrée sur le site de <a target="_blank" href="http://fr.gravatar.com/">Gravatar</a>,
        et ensuite renseignez ci dessous votre adresse email :
    </p>


    <div class="row">
        <div class="col-auto">
            <figure>
                <img src="//www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}" id="avatar" />
            </figure>
        </div>
        <div>
            <form method="post" class="form" style="flex: 1">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input type="text" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" class="form-control @error('email') is-invalid @enderror" />

                </div>

                <button class="btn btn-primary" type="submit">Enregistrer</button>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.12.0/js/md5.min.js"></script>
    <script>
        function debounce(func) {
            var wait = arguments.length <= 1 || arguments[1] === undefined ? 100 : arguments[1];

            var timeout = void 0;
            return function () {
                var _this = this;

                for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
                    args[_key] = arguments[_key];
                }

                clearTimeout(timeout);
                timeout = setTimeout(function () {
                    func.apply(_this, args);
                }, wait);
            };
        }

        var avator = document.getElementById('avatar')
        function sayHi(event) {
            avator.src = '//www.gravatar.com/avatar/' + md5(this.value);
        }

        var debounced = debounce(sayHi, 500);
        document.getElementById('email').addEventListener('keyup',  debounced);
        document.getElementById('email').addEventListener('change',  debounced);
    </script>
@endsection

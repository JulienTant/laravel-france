@extends('LvlfrLogin::profile.layout')

@section('profile_content')
    <h1>Modifier mon pseudo</h1>

    <div id="errorZone" class="hide alert alert-error"></div>
    <div id="successZone" class="hide alert alert-success"></div>


    {{ Form::open() }}
        <div class="control-group">
            {{ Form::label('pseudo', 'Nouveau pseudo')  }}
            <div class="controls">
                <div class="input-append">
                    {{ Form::text('pseudo', Input::old('pseudo', Auth::user()->username), array('class' => 'span3', 'placeholder' => 'Nouveau pseudo')) }}
                    <button class="btn btn-primary" id="valider" type="button">Valider</button>
                </div>
                <span id="isOk"></span>
            </div>
        </div>
    {{ Form::close() }}

@endsection

@section('add_js')
<script>
jQuery(document).ready(function(){

    $('#pseudo').keyup(function(){
        delay(checkIfAvailable, 100);
    });

    checkIfAvailable();

    function checkIfAvailable() {
        $('#errorZone').hide();
        $('#successZone').hide();

        $.post('{{ action('Lvlfr\Login\Controller\ProfileController@checkPseudo') }}', {pseudo: $('#pseudo').val()}, null, 'html')
        .done(function(html) {
            if(html == 'ok') {
                $("#isOk").html('<span style="color: green">Disponible</span>');
            } else {
                $("#isOk").html('<span style="color: red">Non disponible</span>');
            }
        })
    }

    $("#valider").click(function(){
        $.post('{{ action('Lvlfr\Login\Controller\ProfileController@submitPseudo') }}', {pseudo: $('#pseudo').val()}, null, 'json')
        .done(function(json){
            $('#errorZone').hide();
            $('#successZone').html(json.message).show();
        })
        .fail(function(json){
            $('#successZone').hide();
            $('#errorZone').html(json.responseJSON.message).show();
        });

    });

});

var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();
</script>
@endsection

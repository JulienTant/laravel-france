<form action="{{ action('\\'.\Lvlfr\Forums\Controller\SearchController::class . '@search') }}" method="GET" style="float: right;">
    {{ Form::input('text', 'q', Input::get('q'), ['style' => 'margin-top: -4px; width: 250px; background: #FCF7F3; border-color: #F0523F; border-radius: .5em;', 'placeholder' => 'Rechercher sur les forums']) }}
</form>
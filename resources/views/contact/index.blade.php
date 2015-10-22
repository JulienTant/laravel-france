@extends('layouts.master')

@section('page_class', 'ContactPage')

@section('content')

    <div class="Contact">
        <div class="Utility__Container">


            <h2>Contact</h2>

            <div class="Contact__Warning">
                <i class="fa fa-info-circle"></i>
                Si vous cherchez de l'aide pour Laravel, nous vous invitons à consulter les forums. <strong>Aucune aide ne sera apportée par e-mail.</strong> <br>Merci de votre compréhension.
            </div>

            @if($errors->has())
                <ul class="Form__ErrorList">
                    @foreach($errors->all() as $error)
                        <li class="Form__ErrorList__Item">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif


            <form class="Form" method="POST" accept-charset="UTF-8">
                {!! csrf_field() !!}

                <div class="Form__Row">
                    <label class="Form__Row__Label" for="name">Nom* :</label>
                    <input name="name" type="text" id="name" class="Form__Row__Control">
                </div>

                <div class="Form__Row">
                    <label class="Form__Row__Label" for="phone">Email* :</label>
                    <input name="phone" type="text" id="phone" class="Form__Row__Control">
                </div>

                <div class="Form__Row emailLine" style="display: none;">
                    <label class="Form__Row__Label" for="email">Email* :</label>
                    <input name="email" type="text" id="email" class="Form__Row__Control">
                </div>

                <div class="Form__Row">
                    <label class="Form__Row__Label" for="subject">Sujet :</label>
                    <input name="subject" type="text" id="subject" class="Form__Row__Control">
                </div>

                <div class="Form__Row">
                    <label class="Form__Row__Label" for="mailContent">Message* :</label>
                    <textarea name="mailContent" cols="50" rows="10" id="mailContent" class="Form__Row__Control"></textarea>
                </div>

                <div class="Form__Row Form__Row--Buttons">
                    <button type="submit">Valider</button>
                </div>

            </form>
        </div>
    </div>

@endsection
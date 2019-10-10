@extends('layouts.email')

@section('content')
    <td class="container-padding content" align="left" style="padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#ffffff">
        <br>

        <div class="title" style="font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:600;color:#374550">Contact</div>
        <br>

        <div class="body-text" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333">
            Un formulaire de contact a été soumis sur Laravel France.
            <br />
            <br />
            Par <a href="mailto:{{ $email }}">{{ $name }}</a> &lt;<a href="mailto:{{ $email }}">{{ $email }}</a>&gt;,<br />
            Sujet : {{ $sujet }}<br /><br />

            Message: <br /><br />


            {!!  nl2br(e($content))  !!}
            <br><br>
        </div>

    </td>
@endsection
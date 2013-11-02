<html>
<body style="background: #ddd">

<table width="100%" border="0" cellspacing="0" cellpadding="10">
    <tr>
        <td align="center">
            <table width="600" style="background-color: white;">
                <tr>
                    <td>
                        <p>Bonjour,</p>

                        <p>Vous avez reçu un nouveau message sur le site <a href="http://laravel.fr">laravel.fr</a></p>

                        <p>
                            <strong>Nom :</strong> {{ $name }}<br />
                            <strong>Email :</strong> {{ $email }}<br />
                            @if(isset($subject))
                            <strong>Sujet :</strong> {{ $subject }}<br />
                            @endif
                            <strong>Message :</strong><br />
                        </p>

                        <p>
                            {{ $mailContent }}
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>


</body>
</html>

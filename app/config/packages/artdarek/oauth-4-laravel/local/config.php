<?php

return array(
    'storage' => 'Session',

    'consumers' => array(

        'Google' => array(
            'client_id'     => '718908900119.apps.googleusercontent.com',
            'client_secret' => 'DgV2a4BeRy5hLi8c7tmg-ksu',
            'scope' => array('userinfo_email', 'userinfo_profile'),
        ),

        'GitHub' => array(
            'client_id'     => '4f904d8022cc8a454d09',
            'client_secret' => '76ae30937da6086210b90fe6a238c2ed1da9e93f',
            'scope'  => array('user:email'),
        ),

        'Twitter' => array(
            'client_id'    => 'ZPaL1XTM07bCkolbHrNS1yv0b',
            'client_secret' => 'I0wu3T3DQvu5BLS74qWsHYC4aEn11ON1FNig4p5sMLeoPLY003',
        ),
    )
);

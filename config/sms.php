<?php

/**
 * SMS para códigos de recuperación.
 *
 * driver:
 *  - log: escribe en data/sms-log.txt (útil en local)
 *  - twilio: requiere account_sid, auth_token y from
 */
return [
    'enabled' => true,
    'driver' => 'log',
    'from' => '',
    'twilio' => [
        'account_sid' => '',
        'auth_token' => '',
        'from' => '', // ej. +15005550006
    ],
];

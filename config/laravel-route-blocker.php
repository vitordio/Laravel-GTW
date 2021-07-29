<?php

return [

    /** Whitelist blocks all traffic except matching rules. */
    'whitelist' => [
        'ips_habilitados' => [
            '179.93.95.6',
            '179.184.182.91',
            '189.55.195.64',
            '142.93.204.193',
        ],
    ],

    /* Response & Redirect Settings **/
    'redirect_to'      => '',   // URL TO REDIRECT IF BLOCKED (LEAVE BLANK TO THROW STATUS)
    'response_status'  => 403,  // STATUS CODE (403, 404 ...)
    'response_message' => ''    // MESSAGE (COMBINED WITH STATUS CODE)
];

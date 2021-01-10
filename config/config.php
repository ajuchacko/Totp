<?php

return [

    /*
     * Database table name that will be used in migration
     */
    'table' => 'users',

    /*
     * Duration for which otp will be valid. Default is 10 minutes / 600 seconds
     */
    'ttl' => 600,

    /*
     * Default otp length/size
     */
    'size' => 4,
];

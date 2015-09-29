<?php

return [

    /** the name of the redis node set */
    'nodeSetName' => 'mymaster',

    'cluster' => false,

    /** Array of sentinels */
    'masters' => [
        [
            'host' => '221.132.35.179',
            'port' => '26379',
        ],
        [
            'host' => '221.132.35.184',
            'port' => '26379',
        ]
    ]
];

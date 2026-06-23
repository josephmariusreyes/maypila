<?php

namespace App\Constants;

class SampleDocs
{
    //Sample response
    public const CUSTOMER_ADDRESS = [
        'id' => 1,
        'name' => 'John Doe'
    ];

    //Example wherein we use another constant to build the data response
    public const CUSTOMER = [
        'id' => 1,
        'name' => 'John Doe',
        'address' => self::CUSTOMER_ADDRESS
    ];

    //Example with collection
    public const CUSTOMER_COLLECTION = [
        [
            'id' => 1,
            'name' => 'John Doe',
        ],
        [
            'id' => 2,
            'name' => 'Jane Doe',
        ],
    ];
}

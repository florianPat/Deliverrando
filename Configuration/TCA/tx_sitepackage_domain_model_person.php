<?php

return [
    'ctrl' => [
        'title' => 'Person',
        'label' => 'name',
    ],
    'columns' => [
        'name' => [
            'label' => 'Name',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required',
                'max' => 30,
            ],
        ],
        'address' => [
            'label' => 'Address',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required',
                'max' => 50,
            ],
        ],
        'telephonenumber' => [
            'label' => 'Telephone number',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,num',
                'max' => 16,
            ],
        ],
        'password' => [
            'label' => 'Password',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'required,saltedPassword,password',
                'max' => 30,
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'name, password, address, telephonenumber'],
    ],
];
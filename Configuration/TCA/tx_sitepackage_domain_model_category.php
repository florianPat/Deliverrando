<?php

return [
    'ctrl' => [
        'title' => 'Category',
        'label' => 'name',
    ],
    'columns' => [
        'name' => [
            'label' => 'Name',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required',
                'max' => '30',
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'name'],
    ],
];
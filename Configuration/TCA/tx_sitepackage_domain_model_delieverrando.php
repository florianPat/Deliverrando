<?php

return [
    'ctrl' => [
        'title' => 'Delieverrando',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
    ],
    'columns' => [
        'name' => [
            'label' => 'Name',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'alpha,trim,required',
                'max' => '20',
            ],
        ],
        'products' => [
            'label' => 'Products',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_sitepackage_domain_model_product',
                'foreign_field' => 'delieverrando',
            ],
        ],
        'userGroup' => [
            'label' => 'UserGroup',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_groups',
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'name, products, userGroup'],
    ],
];
<?php

use MyVendor\SitePackage\Command\ProductOrderCommand;

return [
    'site:products:order' => [
        'class' => ProductOrderCommand::class
    ],
];
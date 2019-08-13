<?php
$EM_CONF[$_EXTKEY] = [
	'title' => 'Sitepackage',
	'description' => 'Sitepackage',
	'category' => 'templates',
	'author' => 'Florian',
	'author-email' => '...',
	'author-company' => 'HDNET',
	'state' => 'STABLE',
	'version' => '0.0.0',
	'constraints' => [
		'depends' => [
			'typo3' => '8.7.0',
			'fluid_styled_content' => '8.7.0'
		],
	'conflicts' => [
		],
	],
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearCacheOnLoad' => 1,
	'autoload' => [
        'psr-4' => [
            'MyVendor\\SitePackage\\' => 'Classes'
        ],
    ],
];

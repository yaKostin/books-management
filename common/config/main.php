<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'modules' => [
        'books' => [
            'class' => 'common\modules\books\Module',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],
];

<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@brianfaust.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    'default' => 'local',

    'adapters' => [

        'awss3' => [
            'driver'     => 'BrianFaust\Picible\Adapters\AwsS3',
            'connection' => 'awss3',
        ],

        'azure' => [
            'driver'     => 'BrianFaust\Picible\Adapters\Azure',
            'connection' => 'azure',
        ],

        'copy' => [
            'driver'     => 'BrianFaust\Picible\Adapters\Copy',
            'connection' => 'copy',
        ],

        'dropbox' => [
            'driver'     => 'BrianFaust\Picible\Adapters\Dropbox',
            'connection' => 'dropbox',
        ],

        'ftp' => [
            'driver'     => 'BrianFaust\Picible\Adapters\Ftp',
            'connection' => 'ftp',
        ],

        'gridfs' => [
            'driver'     => 'BrianFaust\Picible\Adapters\GridFs',
            'connection' => 'gridfs',
        ],

        'local' => [
            'driver'     => 'BrianFaust\Picible\Adapters\Local',
            'connection' => 'local',
        ],

        'rackspace' => [
            'driver'     => 'BrianFaust\Picible\Adapters\Rackspace',
            'connection' => 'rackspace',
        ],

        'sftp' => [
            'driver'     => 'BrianFaust\Picible\Adapters\Sftp',
            'connection' => 'sftp',
        ],

        'webdav' => [
            'driver'     => 'BrianFaust\Picible\Adapters\WebDav',
            'connection' => 'webdav',
        ],

        'zip' => [
            'driver'     => 'BrianFaust\Picible\Adapters\ZipArchive',
            'connection' => 'zip',
        ],

    ],

    'driver' => 'gd',

    'filters' => [

        'colorize' => [
            'driver' => 'BrianFaust\Picible\Filters\Colorize',
            'config' => [
                'red'   => 50,
                'green' => 64,
                'blue'  => 32,
            ],
        ],

        'greyscale' => [
            'driver' => 'BrianFaust\Picible\Filters\Greyscale',
        ],

        'pixelate' => [
            'driver' => 'BrianFaust\Picible\Filters\Pixelate',
            'config' => [
                'amount' => 15,
            ],
        ],

        'resize' => [
            'driver' => 'BrianFaust\Picible\Filters\Resize',
            'config' => [
                'width'          => 300,
                'height'         => 300,
                'preserve_ratio' => true,
            ],
        ],

        'watermark' => [
            'driver' => 'BrianFaust\Picible\Filters\Watermark',
            'config' => [
                'watermarkPath' => storage_path('files/watermark.png'),
                'position'      => 'bottom-right',
                'coordinatesX'  => 10,
                'coordinatesY'  => 0,
            ],
        ],

        'avatarize' => [
            [
                'driver' => 'BrianFaust\Picible\Filters\Pixelate',
                'config' => [
                    'amount' => 15,
                ],
            ], [
                'driver' => 'BrianFaust\Picible\Filters\Resize',
                'config' => [
                    'width'          => 300,
                    'height'         => 300,
                    'preserve_ratio' => true,
                ],
            ], [
                'driver' => 'BrianFaust\Picible\Filters\Colorize',
                'config' => [
                    'red'   => 50,
                    'green' => 64,
                    'blue'  => 32,
                ],
            ], [
                'driver' => 'BrianFaust\Picible\Filters\Greyscale',
            ], [
                'driver' => 'BrianFaust\Picible\Filters\Watermark',
                'config' => [
                    'watermarkPath' => storage_path('files/watermark.png'),
                    'position'      => 'bottom-right',
                    'coordinatesX'  => 10,
                    'coordinatesY'  => 10,
                ],
            ],
        ],
    ],
];

<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@basecode.sh>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    'default' => 'local',

    'adapters' => [

        'awss3' => [
            'driver'     => 'Artisanry\Picible\Adapters\AwsS3',
            'connection' => 'awss3',
        ],

        'azure' => [
            'driver'     => 'Artisanry\Picible\Adapters\Azure',
            'connection' => 'azure',
        ],

        'copy' => [
            'driver'     => 'Artisanry\Picible\Adapters\Copy',
            'connection' => 'copy',
        ],

        'dropbox' => [
            'driver'     => 'Artisanry\Picible\Adapters\Dropbox',
            'connection' => 'dropbox',
        ],

        'ftp' => [
            'driver'     => 'Artisanry\Picible\Adapters\Ftp',
            'connection' => 'ftp',
        ],

        'gridfs' => [
            'driver'     => 'Artisanry\Picible\Adapters\GridFs',
            'connection' => 'gridfs',
        ],

        'local' => [
            'driver'     => 'Artisanry\Picible\Adapters\Local',
            'connection' => 'local',
        ],

        'rackspace' => [
            'driver'     => 'Artisanry\Picible\Adapters\Rackspace',
            'connection' => 'rackspace',
        ],

        'sftp' => [
            'driver'     => 'Artisanry\Picible\Adapters\Sftp',
            'connection' => 'sftp',
        ],

        'webdav' => [
            'driver'     => 'Artisanry\Picible\Adapters\WebDav',
            'connection' => 'webdav',
        ],

        'zip' => [
            'driver'     => 'Artisanry\Picible\Adapters\ZipArchive',
            'connection' => 'zip',
        ],

    ],

    'driver' => 'gd',

    'filters' => [

        'colorize' => [
            'driver' => 'Artisanry\Picible\Filters\Colorize',
            'config' => [
                'red'   => 50,
                'green' => 64,
                'blue'  => 32,
            ],
        ],

        'greyscale' => [
            'driver' => 'Artisanry\Picible\Filters\Greyscale',
        ],

        'pixelate' => [
            'driver' => 'Artisanry\Picible\Filters\Pixelate',
            'config' => [
                'amount' => 15,
            ],
        ],

        'resize' => [
            'driver' => 'Artisanry\Picible\Filters\Resize',
            'config' => [
                'width'          => 300,
                'height'         => 300,
                'preserve_ratio' => true,
            ],
        ],

        'watermark' => [
            'driver' => 'Artisanry\Picible\Filters\Watermark',
            'config' => [
                'watermarkPath' => storage_path('files/watermark.png'),
                'position'      => 'bottom-right',
                'coordinatesX'  => 10,
                'coordinatesY'  => 0,
            ],
        ],

        'avatarize' => [
            [
                'driver' => 'Artisanry\Picible\Filters\Pixelate',
                'config' => [
                    'amount' => 15,
                ],
            ], [
                'driver' => 'Artisanry\Picible\Filters\Resize',
                'config' => [
                    'width'          => 300,
                    'height'         => 300,
                    'preserve_ratio' => true,
                ],
            ], [
                'driver' => 'Artisanry\Picible\Filters\Colorize',
                'config' => [
                    'red'   => 50,
                    'green' => 64,
                    'blue'  => 32,
                ],
            ], [
                'driver' => 'Artisanry\Picible\Filters\Greyscale',
            ], [
                'driver' => 'Artisanry\Picible\Filters\Watermark',
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

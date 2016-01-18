<?php


return [

    'default' => 'local',

    'adapters' => [

        'awss3' => [
            'driver' => 'DraperStudio\Picible\Adapters\AwsS3',
            'connection' => 'awss3',
        ],

        'azure' => [
            'driver' => 'DraperStudio\Picible\Adapters\Azure',
            'connection' => 'azure',
        ],

        'copy' => [
            'driver' => 'DraperStudio\Picible\Adapters\Copy',
            'connection' => 'copy',
        ],

        'dropbox' => [
            'driver' => 'DraperStudio\Picible\Adapters\Dropbox',
            'connection' => 'dropbox',
        ],

        'ftp' => [
            'driver' => 'DraperStudio\Picible\Adapters\Ftp',
            'connection' => 'ftp',
        ],

        'gridfs' => [
            'driver' => 'DraperStudio\Picible\Adapters\GridFs',
            'connection' => 'gridfs',
        ],

        'local' => [
            'driver' => 'DraperStudio\Picible\Adapters\Local',
            'connection' => 'local',
        ],

        'rackspace' => [
            'driver' => 'DraperStudio\Picible\Adapters\Rackspace',
            'connection' => 'rackspace',
        ],

        'sftp' => [
            'driver' => 'DraperStudio\Picible\Adapters\Sftp',
            'connection' => 'sftp',
        ],

        'webdav' => [
            'driver' => 'DraperStudio\Picible\Adapters\WebDav',
            'connection' => 'webdav',
        ],

        'zip' => [
            'driver' => 'DraperStudio\Picible\Adapters\ZipArchive',
            'connection' => 'zip',
        ],

    ],

    'driver' => 'gd',

    'filters' => [

        'colorize' => [
            'driver' => 'DraperStudio\Picible\Filters\Colorize',
            'config' => [
                'red' => 50,
                'green' => 64,
                'blue' => 32,
            ],
        ],

        'greyscale' => [
            'driver' => 'DraperStudio\Picible\Filters\Greyscale',
        ],

        'pixelate' => [
            'driver' => 'DraperStudio\Picible\Filters\Pixelate',
            'config' => [
                'amount' => 15,
            ],
        ],

        'resize' => [
            'driver' => 'DraperStudio\Picible\Filters\Resize',
            'config' => [
                'width' => 300,
                'height' => 300,
                'preserve_ratio' => true,
            ],
        ],

        'watermark' => [
            'driver' => 'DraperStudio\Picible\Filters\Watermark',
            'config' => [
                'watermarkPath' => storage_path('files/watermark.png'),
                'position' => 'bottom-right',
                'coordinatesX' => 10,
                'coordinatesY' => 0,
            ],
        ],

        'avatarize' => [
            [
                'driver' => 'DraperStudio\Picible\Filters\Pixelate',
                'config' => [
                    'amount' => 15,
                ],
            ], [
                'driver' => 'DraperStudio\Picible\Filters\Resize',
                'config' => [
                    'width' => 300,
                    'height' => 300,
                    'preserve_ratio' => true,
                ],
            ], [
                'driver' => 'DraperStudio\Picible\Filters\Colorize',
                'config' => [
                    'red' => 50,
                    'green' => 64,
                    'blue' => 32,
                ],
            ], [
                'driver' => 'DraperStudio\Picible\Filters\Greyscale',
            ], [
                'driver' => 'DraperStudio\Picible\Filters\Watermark',
                'config' => [
                    'watermarkPath' => storage_path('files/watermark.png'),
                    'position' => 'bottom-right',
                    'coordinatesX' => 10,
                    'coordinatesY' => 10,
                ],
            ],
        ],
    ],
];

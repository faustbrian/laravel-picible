<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Picible\Adapters;

use Aws\S3\S3Client;
use DraperStudio\Picible\Contracts\ShareableInterface;
use DraperStudio\Picible\Models\Picture;
use League\Flysystem\AwsS3v2\AwsS3Adapter;
use League\Flysystem\Filesystem;

/**
 * Class AwsS3.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class AwsS3 extends AbstractAdapter implements ShareableInterface
{
    /**
     * @param Picture $picture
     * @param array   $filters
     *
     * @return mixed
     */
    public function getShareableLink(Picture $picture, array $filters = [])
    {
        $config = $this->loadFlysystemConfig();
        $client = S3Client::factory([
            'key' => $config['key'],
            'secret' => $config['secret'],
            'region' => isset($config['region']) ? $config['region'] : null,
        ]);

        $adapter = new AwsS3Adapter($client, $config['bucket']);
        $filesystem = new Filesystem($adapter);

        $key = $this->buildFileName($picture, $filters);

        return $filesystem->getAdapter()
                            ->getClient()
                            ->getObjectUrl($config['bucket'], $key);
    }
}

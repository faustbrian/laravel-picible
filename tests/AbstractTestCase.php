<?php

namespace BrianFaust\Tests\Picible;

use GrahamCampbell\TestBench\AbstractPackageTestCase;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    protected function getServiceProviderClass($app)
    {
        return \BrianFaust\Picible\ServiceProvider::class;
    }
}

# Laravel Picible

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

## Install

Via Composer

``` bash
$ composer require draperstudio/laravel-picible
```

And then include the service provider within `app/config/app.php`.

``` php
'providers' => [
    'DraperStudio\Picible\PicibleServiceProvider'
];
```

To get started, you'll need to publish the vendor assets and modify it:

```bash
php artisan vendor:publish
```

The package configuration will now be located at `app/config/picible.php` and the migration at `database/migrations/2015_01_30_000000_create_picible_table.php`.

To finish the installation you need to migrate the picible table by executing:

```bash
php artisan migrate
```

## Usage

#### Including the Trait
``` php
<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use DraperStudio\Picible\Contracts\Picible as PicibleContract;
use DraperStudio\Picible\Traits\PicibleTrait;

class User extends Model implements PicibleContract {

    use PicibleTrait;

}
```

#### Example
``` php
<?php



namespace App\Http\Controllers;

use App\User;
use DraperStudio\Picible\PicibleService as Picible;
use Illuminate\Http\Request;

class PicibleController extends Controller {

    public function index(Request $request, Picible $picible)
    {
        // Load the model the picture will be attached to
        $user = User::find(1);

        // The picture that should be uploaded
        $file = $request->files->all()['picture'];

        // Upload the picture and create a database record
        $picture = $picible->withFile($file)
                         ->withModel($user)
                         ->withAttributes(['slot' => 'trailer'])
                         ->withFilters(['watermark'])
                         ->commit(true);

        // Get the shareable url of the created picture
        $picture = $picible->withFilters(['watermark'])
                         ->getShareableLink($picture);

        // Display the shareable url
        echo($picture);
    }

}
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email hello@draperstudio.tech instead of using the issue tracker.

## Credits

- [DraperStudio][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/DraperStudio/laravel-picible.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/DraperStudio/Laravel-Picible/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/DraperStudio/laravel-picible.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/DraperStudio/laravel-picible.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/DraperStudio/laravel-picible.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/DraperStudio/laravel-picible
[link-travis]: https://travis-ci.org/DraperStudio/Laravel-Picible
[link-scrutinizer]: https://scrutinizer-ci.com/g/DraperStudio/laravel-picible/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/DraperStudio/laravel-picible
[link-downloads]: https://packagist.org/packages/DraperStudio/laravel-picible
[link-author]: https://github.com/DraperStudio
[link-contributors]: ../../contributors


<!-- ## To-Do
- Implement **Batch processing** with an easy to use syntax.
- Implement **Move to Slot** with an easy to use syntax.
- Implement **getShareableLink** for the following adapters
    - Azure
    - Copy
    - Ftp
    - GridFs
    - Rackspace
    - Sftp
    - WebDav
    - ZipArchive
- Refactoring and Package structuring
- Write more about how to use the package
- Write more descriptive comments -->

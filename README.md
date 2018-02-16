# Laravel Picible

[![Build Status](https://img.shields.io/travis/faustbrian/Laravel-Picible/master.svg?style=flat-square)](https://travis-ci.org/faustbrian/Laravel-Picible)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/faustbrian/laravel-picible.svg?style=flat-square)]()
[![Latest Version](https://img.shields.io/github/release/faustbrian/Laravel-Picible.svg?style=flat-square)](https://github.com/faustbrian/Laravel-Picible/releases)
[![License](https://img.shields.io/packagist/l/faustbrian/Laravel-Picible.svg?style=flat-square)](https://packagist.org/packages/faustbrian/Laravel-Picible)

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

``` bash
$ composer require faustbrian/laravel-picible
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

namespace App;

use BrianFaust\Picible\Contracts\Picible as PicibleContract;
use BrianFaust\Picible\Traits\PicibleTrait;

class User extends Model implements PicibleContract {

    use PicibleTrait;

}
```

#### Example
``` php
<?php

namespace App\Http\Controllers;

use App\User;
use BrianFaust\Picible\PicibleService as Picible;
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

## Testing

``` bash
$ phpunit
```

## Security

If you discover a security vulnerability within this package, please send an e-mail to hello@brianfaust.me. All security vulnerabilities will be promptly addressed.

## Credits

- [Brian Faust](https://github.com/faustbrian)
- [All Contributors](../../contributors)

## License

[MIT](LICENSE) © [Brian Faust](https://brianfaust.me)

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

# Laravel Picible

## Installation

First, pull in the package through Composer.

```js
composer require draperstudio/laravel-picible:1.0.*@dev
```

And then include the service provider within `app/config/app.php`.

```php
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

#### Including the Trait
```php
<?php

namespace App;

use DraperStudio\Picible\Contracts\Picible as PicibleContract;
use DraperStudio\Picible\Traits\PicibleTrait;

class User extends Model implements PicibleContract {

    use PicibleTrait;

}
```

#### Example
```php
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

## To-Do
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
- Write more descriptive comments

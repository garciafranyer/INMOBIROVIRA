<?php

use App\Providers\AppServiceProvider;
use App\Providers\SeguridadServiceProvider;

return [
    AppServiceProvider::class,
    SeguridadServiceProvider::class,
    App\Providers\RepositoryServiceProvider::class,
];

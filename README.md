# Jetstrap

[![Latest Stable Version](https://poser.pugx.org/nascent-africa/jetstrap/v)](//packagist.org/packages/nascent-africa/jetstrap)
[![License](https://poser.pugx.org/nascent-africa/jetstrap/license)](//packagist.org/packages/nascent-africa/jetstrap)

  
## Description

On September 8th after spending some time with my fresh sandbox installation of Laravel 8 the first question I asked myself was, "Am I going to learn a new CSS framework or convert the jetstream resources back to Bootstrap", I also tried to let the two co-exist but that created more chaos than the problem it solved.

As a backend developer, Livewire was a dream come true, and since the inception of Vue I've been moving away from jquery so AlpineJS was a welcomed idea, but with Bootstrap 5 on the horizon promising everything that makes Tailwind special I couldn't find a strong reason to commit to learning a new CSS framework also considering the fact that am not supposed to be meddling with front end codes, to begin with.

Jetstrap focus is on the `VIEW` side of [Jetstream](https://github.com/laravel/jetstream) package installed in your Laravel application, so when a swap is performed, the `Action`, `MODEL`, `CONTROLLER` even the `Component` and `Action` classes of your project is still 100% Jetstream with no added layer of complexity.

> This package offers an option for of Bootstrap 5 by default so check out the [Bootstrap 5](https://v5.getbootstrap.com/docs/5.0/getting-started/introduction/) documentation for more details.

## Table of Content
  * [Installation](#installation)
    + [Installing Jetstream](#installing-jetstream)
      - [Install Jetstream With Livewire](#install-jetstream-with-livewire)
      - [Or, Install Jetstream With Inertia](#or--install-jetstream-with-inertia)
    + [Install Jetstrap](#install-jetstrap)
    + [Choosing a Bootstrap version](#choosing-a-bootstrap-version)
    + [Finalizing The Installation](#finalizing-the-installation)
    + [Extras](#extras)
      - [Pagination](#pagination)
  * [Presets](#presets)
    + [Core Ui](#core-ui)
    + [AdminLTE](#adminlte)
  * [Testing](#testing)
  * [License](#license)
  
## Installation

### Installing Jetstream

You may use Composer to install Jetstream into your new Laravel project:

```
composer require laravel/jetstream
```

If you choose to install Jetstream through Composer, you should run the jetstream:install Artisan command. This command accepts the name of the stack you prefer (livewire or inertia). You are highly encouraged to read through the entire documentation of Livewire or Inertia before beginning your Jetstream project. In addition, you may use the --teams switch to enable team support:

#### Install Jetstream With Livewire

```
php artisan jetstream:install livewire --teams
```

#### Or, Install Jetstream With Inertia

```
php artisan jetstream:install inertia --teams
```

### Install Jetstrap

Use Composer to install Jetstream into your new Laravel project as dev dependency:

```
composer require nascent-africa/jetstrap --dev
```

### Choosing a Bootstrap version

Jetstrap supports two different versions of Bootstrap, version 4 and 5. Version 5 is set as the default version, 
but you can easily switch to version 4 by using the Jetstrap's bootstrap4 method within your AppServiceProvider before performing a swap:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NascentAfrica\Jetstrap\JetstrapFacade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JetstrapFacade::bootstrap4();
    }
}
```

Regardless how you install Jetstream, Jetstrap commands are very similar to that
of Jetstream as it accepts the name of the stack you would like to swap (livewire or inertia).

> It is important you install and configure [Laravel Jetstream](https://github.com/laravel/jetstream) before performing a swap.

You are highly encouraged to read through the entire documentation of [Jetstream](https://jetstream.laravel.com/1.x/introduction.html)
before beginning your Jetstrap project. In addition, you may use the `--teams` switch to swap team assets just like you would in Jetstream:

```bash

php artisan jetstrap:swap livewire

or

php artisan jetstrap:swap livewire --teams

php artisan jetstrap:swap inertia --teams
```

This will publish overrides to enable Bootstrap like the good old days!

### Finalizing The Installation

After installing Jetsrtap and swapping Jetstream resources, remove tailwindCSS and its dependencies if any from your package.json and then install and build your NPM dependencies and migrate your database:

```
npm install && npm run dev

php artisan migrate
```

### Extras

#### Pagination

It is also important to point out that Laravel 8 still includes pagination views built using Bootstrap CSS. To use these views instead of the default Tailwind views, you may call the paginator's useBootstrap method within your AppServiceProvider:

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
```

## Presets

Presets are custom third party templates built using bootstrap. We've thought about it, what are the chances that you're going to use the default template provided by Laravel or Laravel Jetstream.

> Presets are only supported in Bootstrap 4 at the moment.

### Core Ui

[Core Ui](https://coreui.io/) lets you save thousands of priceless hours because it offers everything you need to create modern, beautiful, and responsive applications as stated on their website.

To use Core Ui presets, simply call the `useCoreUi3` method within your AppServiceProvider:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NascentAfrica\Jetstrap\JetstrapFacade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JetstrapFacade::bootstrap4();
        JetstrapFacade::useCoreUi3();
    }
}
```

### AdminLTE

[AdminLTE](https://adminlte.io/) is an open source admin dashboard & control panel theme. Built on top of Bootstrap, AdminLTE provides a range of responsive, reusable, and commonly used components.

To use AdminLte presets, simply call the `useAdminLte3` method within your AppServiceProvider:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NascentAfrica\Jetstrap\JetstrapFacade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JetstrapFacade::bootstrap4();
        JetstrapFacade::useAdminLte3();
    }
}
```

## Testing
Run the tests with:

```bash
vendor/bin/phpunit
```

or 

```bash
composer tests
```

## License
Jetstrap is open-sourced software licensed under the [MIT license](https://github.com/nascent-africa/jetstrap/blob/master/LICENSE).

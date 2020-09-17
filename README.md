# Jetstrap

> This package is no where near ready for production so we strongly advise against
using it for live project. Also please help us make it better by contributing.

## Description

Laravel Jetstream is a wonderful upgrade for Laravel UI, however it does not
come with an option to use Bootstrap scaffolding out of the box instead your
given a single option of TailwindCSS. Tailwind is an excellent framework but
for folks with a long standing relationship with Bootstrap it may be difficult
to make the sudden switch.

This package makes use of Bootstrap 5 even though its still at Alpha because
just like TailwindCSS, it leans towards utility classes and also drops JQuery
giving room for AlpineJs, so instead of a #TALL stack, you would have a #BALL stack.

## Installation

After installing and configuring Laravel Jetstream, install Jetstrap in your project

```
composer require nascent-africa/jetstrap
```

Regardless how you install Jetstream. Jetstrap command is very similar to that
of Jetstream as it accepts accepts the name of the stack you prefer (livewire or inertia).

> It is important you install Jetstream before performing a swap.

You are highly encouraged to read through the entire documentation of Jetstream
before beginning your Jetstrap project. In addition, you may use the --teams switch to swap team assets:

```bash
php artisan jetstrap:swap livewire

or

php artisan jetstrap:swap livewire --teams

// Yet to commence development for inertia swap
php artisan jetstrap:swap inertia --teams
```

This will publish overrides in the `views/vendor/Jetstream` directory and a few
familiar files to enable Bootstrap like the good old days!

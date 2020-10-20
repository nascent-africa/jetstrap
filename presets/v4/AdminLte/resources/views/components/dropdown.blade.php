@props(['id' => 'navbarDropdown'])

<li {!! $attributes->merge(['class' => 'nav-item dropdown']) !!}>
    <a id="{{ $id }}" href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
        {{ $trigger }}
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">
        {{ $content }}
    </div>
</li>

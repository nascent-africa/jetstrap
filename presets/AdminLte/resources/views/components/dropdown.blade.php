@props(['id' => 'navbarDropdown'])

<li {!! $attributes->merge(['class' => 'nav-item dropdown']) !!}>
    <a id="{{ $id }}" href="#" class="nav-link" role="button" data-toggle="dropdown" aria-expanded="false">
        {{ $trigger }}
    </a>

    <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="{{ $id }}">
        {{ $content }}
    </div>
</li>

@props(['id' => 'navbarDropdown'])

<li class="nav-item dropdown">
    <a id="{{ $id }}" {!! $attributes->merge(['class' => 'nav-link dropdown-toggle']) !!} role="button" data-toggle="dropdown" aria-expanded="false">
        {{ $trigger }}
    </a>

    <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="{{ $id }}">
        {{ $content }}
    </div>
</li>
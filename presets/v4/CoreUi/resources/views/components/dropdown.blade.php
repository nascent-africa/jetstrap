@props(['id' => 'navbarDropdown'])

<li class="c-header-nav-item dropdown">
    <a id="{{ $id }}" {!! $attributes->merge(['class' => 'c-header-nav-link']) !!} data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        {{ $trigger }}
    </a>

    <div class="dropdown-menu dropdown-menu-right pt-0" aria-labelledby="{{ $id }}">
        {{ $content }}
    </div>
</li>

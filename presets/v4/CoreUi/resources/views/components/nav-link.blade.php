@props(['active'])

@php
$classes = ($active ?? false)
            ? 'c-header-nav-link active font-weight-bold'
            : 'c-header-nav-link';
@endphp

<li class="nav-item">
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>

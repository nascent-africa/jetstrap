<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-dark']) }}>
    {{ $slot }}
</button>

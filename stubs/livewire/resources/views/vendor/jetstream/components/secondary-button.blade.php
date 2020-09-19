<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-outline-secondary']) }}>
    {{ $slot }}
</button>

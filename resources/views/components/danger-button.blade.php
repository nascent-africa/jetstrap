<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-danger']) }}>
    {{ $slot }}
</button>

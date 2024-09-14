<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-secondary mt-3']) }}>
    {{ $slot }}
</button>

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary text-white mt-3']) }}>
    {{ $slot }}
</button>

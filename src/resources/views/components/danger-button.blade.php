<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-danger text-white mt-3']) }}>
    {{ $slot }}
</button>

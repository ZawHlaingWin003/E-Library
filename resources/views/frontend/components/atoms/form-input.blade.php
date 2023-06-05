
@props([
    'name',
    'class'
])

<input {{ $attributes->merge(['class' => 'primary-input']) }}>
<strong>
    <small>
        <span class="text-danger error {{ $name }}-error"></span>
    </small>
</strong>

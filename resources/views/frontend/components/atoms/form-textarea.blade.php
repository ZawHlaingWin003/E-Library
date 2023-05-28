
@props([
    'name'
])

<textarea {{ $attributes->merge(['class' => 'primary-input']) }} rows="3"></textarea>
<strong>
    <small>
        <span class="text-danger error {{ $name }}-error"></span>
    </small>
</strong>

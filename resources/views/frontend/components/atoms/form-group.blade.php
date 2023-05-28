@props(['label' => null])

<div {{ $attributes->merge(['class' => 'form-group']) }}>
    @if ($label)
        <label for="{{ $attributes->get('id') }}">{{ $label }}</label>
    @endif
    {{ $slot }}
</div>

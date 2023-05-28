@props(['buttonId', 'loaderId', 'iconName', 'iconId'])

<button {{ $attributes->merge(['class' => 'btn btn-primary primary-btn cursor-pointer d-inline-flex gap-2 align-items-center']) }} id="{{ $buttonId }}">
    <div class="custom-loader button-loader d-none" id="{{ $loaderId }}"></div>
    <div class="button-icon" id="{{ $iconId }}">
        <i class="fa-solid {{ $iconName }}"></i>
    </div>
    <span>{{ $slot }}</span>
</button>

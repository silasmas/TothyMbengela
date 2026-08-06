@php
    use App\Models\Slide;
    $action = $action ?? Slide::ACTION_NONE;
    $label = $label ?: (Slide::actionLabels()[$action] ?? '');
    $styleClass = ($style ?? 'one') === 'two' ? 'btn-style-two' : 'btn-style-one';
    if (($style ?? '') === 'two' && in_array($action, [Slide::ACTION_ADD_CART, Slide::ACTION_BUY], true)) {
        $styleClass = 'btn-style-one light-bg';
    }
@endphp
@if($action === Slide::ACTION_NONE || $label === '')
@elseif($action === Slide::ACTION_ADD_CART && $cartItem)
    <button type="button" class="theme-btn {{ $styleClass }} js-add-to-cart" data-item='@json($cartItem)'>
        <span class="btn-title"><i class="fa fa-cart-plus"></i> {{ $label }}</span>
    </button>
@elseif($action === Slide::ACTION_BUY && $cartItem)
    <button type="button" class="theme-btn {{ $styleClass }} js-buy-now" data-item='@json($cartItem)'>
        <span class="btn-title"><i class="fa fa-bolt"></i> {{ $label }}</span>
    </button>
@elseif($action === Slide::ACTION_DONATE)
    <a href="#" class="theme-btn {{ $styleClass }}" data-bs-toggle="modal" data-bs-target="#donatePartnerModal">
        <span class="btn-title">{{ $label }}</span>
    </a>
@elseif($action === Slide::ACTION_PARTNER)
    <a href="#" class="theme-btn alliance-btn-partner js-donate-modal-partner">
        <span class="btn-title"><i class="fa fa-handshake"></i> {{ $label }}</span>
    </a>
@elseif($action === Slide::ACTION_CONTENTS)
    <a href="{{ route('contents.index') }}" class="theme-btn {{ $styleClass }}"><span class="btn-title">{{ $label }}</span></a>
@elseif($action === Slide::ACTION_ABOUT)
    <a href="{{ route('about') }}" class="theme-btn {{ $styleClass }}"><span class="btn-title">{{ $label }}</span></a>
@elseif($action === Slide::ACTION_SHOP)
    <a href="{{ route('books.index') }}" class="theme-btn {{ $styleClass }}"><span class="btn-title">{{ $label }}</span></a>
@elseif($action === Slide::ACTION_LINK && $url)
    <a href="{{ $url }}" class="theme-btn {{ $styleClass }}" @if(\Illuminate\Support\Str::startsWith($url, ['http://', 'https://'])) target="_blank" rel="noopener noreferrer" @endif>
        <span class="btn-title">{{ $label }}</span>
    </a>
@endif

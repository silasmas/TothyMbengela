@php
    $u = auth()->user();
    $navAvatarSize = $navAvatarSize ?? 40;
    $avatarUrl = null;
    if ($u->avatar_path) {
        $p = $u->avatar_path;
        $avatarUrl = \Illuminate\Support\Str::startsWith($p, ['http://', 'https://'])
            ? $p
            : \Illuminate\Support\Facades\Storage::disk('public')->url($p);
    }
    $nm = trim((string) $u->name);
    $initial = $nm !== '' ? mb_strtoupper(mb_substr($nm, 0, 1)) : '?';
@endphp
@if ($avatarUrl)
    <img src="{{ $avatarUrl }}" alt="" class="alliance-nav-avatar-img" width="{{ $navAvatarSize }}" height="{{ $navAvatarSize }}" loading="lazy" decoding="async">
@else
    <span class="alliance-nav-avatar-fallback" style="width:{{ $navAvatarSize }}px;height:{{ $navAvatarSize }}px;" aria-hidden="true">{{ $initial }}</span>
@endif

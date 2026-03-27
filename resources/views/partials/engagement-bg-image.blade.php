{{-- Portrait latéral : URL + ?v=filemtime pour forcer le rechargement après remplacement du fichier --}}
@php
    $path = public_path('assets/images/' . $filename);
    $ver = file_exists($path) ? filemtime($path) : 1;
@endphp
<div class="bg-image"><img src="{{ asset('assets/images/' . $filename) }}?v={{ $ver }}" alt="{{ $alt }}"></div>


<!-- Start main-content -->
<section class="page-title" style="background-image: url({{ asset('assets/images/banner.jpeg') }});">
    <div class="auto-container">
        <div class="title-outer">
            <h1 class="title">
                {{-- Utilise la variable définie dans chaque page ou fallback --}}
                @hasSection('page_banner_title')
                    @yield('page_banner_title')
                @else
                    {{ $title ?? 'Titre de la page' }}
                @endif
            </h1>
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ route('home') }}">Accueil</a>
                </li>
                @hasSection('page_banner_breadcrumbs')
                    @yield('page_banner_breadcrumbs')
                @else
                    {{-- Breadcrumb dynamique, peut être personnalisé dans chaque page --}}
                    @if(!empty($breadcrumbs) && is_array($breadcrumbs))
                        @foreach($breadcrumbs as $breadcrumb)
                            <li>
                                @if(isset($breadcrumb['url']))
                                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                                @else
                                    {{ $breadcrumb['label'] }}
                                @endif
                            </li>
                        @endforeach
                    @endif
                @endif
            </ul>
        </div>
    </div>
</section>
<!-- end main-content -->

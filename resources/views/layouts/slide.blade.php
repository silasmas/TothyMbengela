{{-- ═══ REVOLUTION SLIDER — slides dynamiques (admin) ═══ --}}
@php
    use App\Models\Slide;
    $slides = isset($homeSlides) ? $homeSlides : collect();
@endphp
<section class="main-slider">
    <div class="rev_slider_wrapper fullwidthbanner-container" id="rev_slider_one_wrapper" data-source="gallery">
        <div class="rev_slider fullwidthabanner" id="rev_slider_one" data-version="5.4.1">
            <ul>
                @forelse($slides as $slide)
                    @php
                        $bg = $slide->image_path
                            ? $slide->image_url
                            : ($loop->first
                                ? asset('assets/images/Ima1.jpg.jpeg')
                                : asset('assets/images/s1.jpeg'));
                        $product = $slide->book;
                        $cartItem = ($product && $product->isPurchasable()) ? $product->toCartItem() : null;
                    @endphp
                    <li data-index="rs-{{ $slide->id }}" data-transition="zoomout">
                        <img src="{{ $bg }}" alt="{{ $slide->title }}" class="rev-slidebg">

                        <div class="tp-caption"
                            data-paddingbottom="[10,0,0,0]"
                            data-paddingleft="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]"
                            data-paddingtop="[0,0,0,0]"
                            data-responsive_offset="on"
                            data-type="text" data-height="none"
                            data-width="['900','800','600','500']"
                            data-whitespace="normal"
                            data-hoffset="['0','0','0','0']"
                            data-voffset="['-40','-30','-25','-40']"
                            data-x="['center','center','center','center']"
                            data-y="['middle','middle','middle','middle']"
                            data-textalign="['top','top','top','top']"
                            data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
                            <h1>{!! nl2br(e($slide->title)) !!}</h1>
                        </div>

                        <div class="tp-caption"
                            data-paddingbottom="[0,0,0,0]"
                            data-paddingleft="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]"
                            data-paddingtop="[0,0,0,0]"
                            data-responsive_offset="on"
                            data-type="text" data-height="none"
                            data-width="['750','750','750','450']"
                            data-whitespace="normal"
                            data-hoffset="['0','0','0','0']"
                            data-voffset="['90','80','75','55']"
                            data-x="['center','center','center','center']"
                            data-y="['middle','middle','middle','middle']"
                            data-textalign="['top','top','top','top']"
                            data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
                            <div class="text">
                                @if($slide->subtitle)
                                    <span class="alliance-slide-product-type">{{ $slide->subtitle }}</span>
                                    @if($slide->body) — @endif
                                @endif
                                @if($slide->body)
                                    {{ \Illuminate\Support\Str::limit(strip_tags($slide->body), 110) }}
                                @endif
                            </div>
                        </div>

                        <div class="tp-caption"
                            data-paddingbottom="[0,0,0,0]"
                            data-paddingleft="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]"
                            data-paddingtop="[0,0,0,0]"
                            data-responsive_offset="on"
                            data-type="text" data-height="none"
                            data-width="['700','750','700','450']"
                            data-whitespace="normal"
                            data-hoffset="['0','0','0','0']"
                            data-voffset="['185','175','170','140']"
                            data-x="['center','center','center','center']"
                            data-y="['middle','middle','middle','middle']"
                            data-textalign="['top','top','top','top']"
                            data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
                            <div class="btn-box alliance-slide-product-actions">
                                @include('partials.slide-action-button', ['action' => $slide->primary_action, 'label' => $slide->primary_label, 'url' => $slide->primary_url, 'cartItem' => $cartItem, 'style' => 'one'])
                                @include('partials.slide-action-button', ['action' => $slide->secondary_action, 'label' => $slide->secondary_label, 'url' => $slide->secondary_url, 'cartItem' => $cartItem, 'style' => 'two'])
                            </div>
                        </div>
                    </li>
                @empty
                    <li data-index="rs-fallback" data-transition="zoomout">
                        <img src="{{ asset('assets/images/Ima1.jpg.jpeg') }}" alt="" class="rev-slidebg">
                        <div class="tp-caption"
                            data-responsive_offset="on" data-type="text" data-height="none"
                            data-width="['900','800','600','500']" data-whitespace="normal"
                            data-hoffset="['0','0','0','0']" data-voffset="['-20','-15','-15','-30']"
                            data-x="['center','center','center','center']" data-y="['middle','middle','middle','middle']"
                            data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
                            <h1>Bienvenue chez<br>Alliance</h1>
                        </div>
                        <div class="tp-caption"
                            data-responsive_offset="on" data-type="text" data-height="none"
                            data-width="['700','750','700','450']" data-whitespace="normal"
                            data-hoffset="['0','0','0','0']" data-voffset="['190','185','180','150']"
                            data-x="['center','center','center','center']" data-y="['middle','middle','middle','middle']"
                            data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
                            <div class="btn-box">
                                <a href="{{ route('books.index') }}" class="theme-btn btn-style-one"><span class="btn-title">Voir la boutique</span></a>
                            </div>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
    <ul class="social-links">
        <li><a href="#"><i class="fab fa-facebook"></i></a></li>
        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
    </ul>
</section>

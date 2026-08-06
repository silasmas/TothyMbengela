<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>

<!-- Revolution Slider -->
<script src="{{ asset('assets/plugins/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
<script src="{{ asset('assets/plugins/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
<script src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
<script src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.carousel.min.js') }}"></script>
<script src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
<script src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
<script src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.migration.min.js') }}"></script>
<script src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
<script src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
<script src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
<script src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
<script src="{{ asset('assets/js/main-slider-script.js') }}"></script>

<!-- Librairies -->
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.fancybox.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/wow.js') }}"></script>
<script src="{{ asset('assets/js/appear.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/swiper.min.js') }}"></script>
<script src="{{ asset('assets/js/owl.js') }}"></script>
<script src="{{ asset('assets/js/mixitup.js') }}"></script>
<script src="{{ asset('assets/js/bxslider.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>

<!-- Panier (localStorage), toasts, formulaires AJAX -->
<script>
(function(){
    function updateCartBadge(){
        var cart = JSON.parse(localStorage.getItem('alliance_cart') || '[]');
        var total = 0;
        cart.forEach(function(item){ total += (item.qty || 1); });
        document.querySelectorAll('.cart-count-badge').forEach(function(b){
            if(total > 0){ b.textContent = total > 99 ? '99+' : total; b.style.display = 'inline-block'; }
            else { b.style.display = 'none'; }
        });
    }

    function shopCurrencyCfg() {
        return window.allianceShopCurrency || { rate: 2850, default: 'USD', allowSwitch: true };
    }

    function getDisplayCurrency() {
        try {
            var stored = localStorage.getItem('alliance_display_currency');
            if (stored === 'USD' || stored === 'CDF') return stored;
        } catch (e) {}
        return shopCurrencyCfg().default || 'USD';
    }

    function setDisplayCurrency(cur) {
        cur = String(cur || 'USD').toUpperCase();
        if (cur !== 'USD' && cur !== 'CDF') cur = 'USD';
        try { localStorage.setItem('alliance_display_currency', cur); } catch (e) {}
        document.querySelectorAll('.js-site-currency').forEach(function(btn) {
            btn.classList.toggle('active', btn.getAttribute('data-currency') === cur);
        });
        refreshPriceLabels();
        renderCartModal();
        return cur;
    }

    function convertFromUsd(amountUsd, currency) {
        var n = Number(amountUsd) || 0;
        if (String(currency).toUpperCase() === 'CDF') {
            return Math.round(n * (Number(shopCurrencyCfg().rate) || 2850) * 100) / 100;
        }
        return Math.round(n * 100) / 100;
    }

    function formatMoney(amountUsd, currency) {
        var cur = currency || getDisplayCurrency();
        var v = convertFromUsd(amountUsd, cur);
        var digits = cur === 'CDF' ? 0 : 2;
        return v.toFixed(digits).replace('.', ',') + ' ' + cur;
    }

    function refreshPriceLabels() {
        document.querySelectorAll('.js-alliance-price[data-price-usd]').forEach(function(el) {
            var usd = parseFloat(el.getAttribute('data-price-usd'));
            if (isNaN(usd)) return;
            el.textContent = formatMoney(usd);
        });
    }

    window.allianceGetDisplayCurrency = getDisplayCurrency;
    window.allianceSetDisplayCurrency = setDisplayCurrency;
    window.allianceFormatMoney = formatMoney;

    function renderCartModal(){
        var list = document.getElementById('alliance-cart-list');
        var empty = document.getElementById('alliance-cart-empty');
        var totalEl = document.getElementById('alliance-cart-total');
        if (!list || !empty) return;
        var cart = JSON.parse(localStorage.getItem('alliance_cart') || '[]');
        list.innerHTML = '';
        if (cart.length === 0) {
            empty.classList.remove('d-none');
            if (totalEl) totalEl.textContent = '';
            return;
        }
        empty.classList.add('d-none');
        var totalUsd = 0;
        cart.forEach(function(item){
            var qty = item.qty || 1;
            var unitUsd = item.price != null ? Number(item.price) : 0;
            totalUsd += unitUsd * qty;
            var li = document.createElement('li');
            li.className = 'd-flex justify-content-between align-items-start py-2 border-bottom gap-2';
            var priceStr = item.price != null ? formatMoney(unitUsd) : '';
            var lineStr = item.price != null ? formatMoney(unitUsd * qty) : '';
            var thumb = item.cover_url
                ? '<img src="' + escapeHtml(item.cover_url) + '" alt="" width="48" height="64" class="flex-shrink-0 rounded" style="object-fit:cover;">'
                : '';
            li.innerHTML = thumb +
                '<div class="min-w-0 flex-grow-1">' +
                '<strong>' + escapeHtml(item.title) + '</strong><br>' +
                '<small class="text-muted">' + (priceStr ? priceStr + ' / u · ' : '') + 'Ligne : ' + lineStr + '</small>' +
                '<div class="d-flex align-items-center gap-2 mt-2">' +
                '<button type="button" class="btn btn-sm btn-outline-secondary alliance-cart-qty-dec" data-id="' + String(item.id) + '" aria-label="Diminuer">−</button>' +
                '<input type="number" class="form-control form-control-sm alliance-cart-qty-input" data-id="' + String(item.id) + '" value="' + qty + '" min="1" max="99" style="width:64px;text-align:center;border:2px solid #A86C3C;background:#fff;color:#141414;font-weight:700;">' +
                '<button type="button" class="btn btn-sm btn-outline-secondary alliance-cart-qty-inc" data-id="' + String(item.id) + '" aria-label="Augmenter">+</button>' +
                '</div></div>' +
                '<button type="button" class="btn btn-sm btn-outline-danger alliance-cart-remove flex-shrink-0" data-id="' + String(item.id) + '" aria-label="Retirer">×</button>';
            list.appendChild(li);
        });
        if (totalEl) totalEl.textContent = 'Total : ' + formatMoney(totalUsd);
    }

    function escapeHtml(s){
        var d = document.createElement('div');
        d.textContent = s;
        return d.innerHTML;
    }

    window.allianceSiteToast = function(message, variant){
        var el = document.getElementById('alliance-site-toast');
        if (!el) return;
        el.textContent = message;
        var cls = variant === 'error' ? 'error' : (variant === 'info' ? 'info' : 'success');
        el.className = 'alliance-site-toast ' + cls;
        el.classList.add('show');
        clearTimeout(el._allianceToastT);
        el._allianceToastT = setTimeout(function(){ el.classList.remove('show'); }, variant === 'error' ? 6200 : 5200);
    };

    window.allianceCart = {
        add: function(id, title, price, qty, currency, coverUrl){
            var cart = JSON.parse(localStorage.getItem('alliance_cart') || '[]');
            var sid = String(id);
            var found = cart.find(function(i){ return String(i.id) === sid; });
            if (found) {
                found.qty += (qty || 1);
                if (coverUrl) { found.cover_url = coverUrl; }
            } else {
                cart.push({ id: id, title: title, price: price, qty: qty || 1, currency: 'USD', cover_url: coverUrl || '' });
            }
            localStorage.setItem('alliance_cart', JSON.stringify(cart));
            updateCartBadge();
            renderCartModal();
        },
        setQty: function(id, qty){
            var sid = String(id);
            var q = parseInt(qty, 10);
            if (isNaN(q) || q < 1) q = 1;
            if (q > 99) q = 99;
            var cart = JSON.parse(localStorage.getItem('alliance_cart') || '[]');
            var found = cart.find(function(i){ return String(i.id) === sid; });
            if (!found) return;
            found.qty = q;
            localStorage.setItem('alliance_cart', JSON.stringify(cart));
            updateCartBadge();
            renderCartModal();
        },
        removeById: function(id){
            var sid = String(id);
            var cart = JSON.parse(localStorage.getItem('alliance_cart') || '[]').filter(function(i){ return String(i.id) !== sid; });
            localStorage.setItem('alliance_cart', JSON.stringify(cart));
            updateCartBadge();
            renderCartModal();
        },
        get: function(){ return JSON.parse(localStorage.getItem('alliance_cart') || '[]'); },
        count: function(){ var c = this.get(); var t = 0; c.forEach(function(i){ t += i.qty || 1; }); return t; },
        clear: function(){ localStorage.removeItem('alliance_cart'); updateCartBadge(); renderCartModal(); }
    };

    function allianceSetSubmitLoading(btn, loading) {
        if (!btn) return;
        if (loading) {
            if (!btn.dataset.allianceSavedHtml) {
                btn.dataset.allianceSavedHtml = btn.innerHTML;
            }
            btn.classList.add('alliance-submit-loading');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span><span>Patientez…</span>';
            btn.disabled = true;
            btn.setAttribute('aria-busy', 'true');
        } else {
            btn.classList.remove('alliance-submit-loading');
            btn.disabled = false;
            btn.removeAttribute('aria-busy');
            if (btn.dataset.allianceSavedHtml) {
                btn.innerHTML = btn.dataset.allianceSavedHtml;
                delete btn.dataset.allianceSavedHtml;
            }
        }
    }

    window.allianceSetSubmitLoading = allianceSetSubmitLoading;

    function bindAjaxForm(form){
        if (!form || form.getAttribute('data-ajax-bound')) return;
        form.setAttribute('data-ajax-bound', '1');
        form.addEventListener('submit', function(e){
            e.preventDefault();
            var fd = new FormData(form);
            var btn = form.querySelector('[type="submit"]');
            allianceSetSubmitLoading(btn, true);
            fetch(form.action, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: fd,
                credentials: 'same-origin'
            }).then(function(res){
                return res.json().then(function(data){ return { res: res, data: data }; }).catch(function(){
                    return { res: res, data: {} };
                });
            }).then(function(pair){
                var res = pair.res, data = pair.data;
                if (res.ok && data.success) {
                    window.allianceSiteToast(data.message || 'Envoyé.', 'success');
                    form.reset();
                } else if (res.status === 422 && data.errors) {
                    var msg = Object.values(data.errors).flat().join(' ');
                    window.allianceSiteToast(msg || 'Vérifiez le formulaire.', 'error');
                } else {
                    window.allianceSiteToast(data.message || 'Une erreur est survenue.', 'error');
                }
            }).catch(function(){
                window.allianceSiteToast('Erreur réseau.', 'error');
            }).finally(function(){
                allianceSetSubmitLoading(btn, false);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function(){
        updateCartBadge();
        renderCartModal();

        var cartModal = document.getElementById('allianceCartModal');
        if (cartModal) {
            cartModal.addEventListener('show.bs.modal', function(){ renderCartModal(); });
        }

        document.getElementById('alliance-cart-clear')?.addEventListener('click', function(){
            window.allianceCart.clear();
            window.allianceSiteToast('Panier vidé.', 'success');
        });

        document.getElementById('alliance-cart-list')?.addEventListener('click', function(e){
            var rm = e.target.closest('.alliance-cart-remove');
            if (rm && rm.getAttribute('data-id')) {
                window.allianceCart.removeById(rm.getAttribute('data-id'));
                return;
            }
            var dec = e.target.closest('.alliance-cart-qty-dec');
            if (dec && dec.getAttribute('data-id')) {
                var cartDec = window.allianceCart.get();
                var itemDec = cartDec.find(function(i){ return String(i.id) === String(dec.getAttribute('data-id')); });
                if (itemDec) window.allianceCart.setQty(itemDec.id, (itemDec.qty || 1) - 1);
                return;
            }
            var inc = e.target.closest('.alliance-cart-qty-inc');
            if (inc && inc.getAttribute('data-id')) {
                var cartInc = window.allianceCart.get();
                var itemInc = cartInc.find(function(i){ return String(i.id) === String(inc.getAttribute('data-id')); });
                if (itemInc) window.allianceCart.setQty(itemInc.id, (itemInc.qty || 1) + 1);
            }
        });

        document.getElementById('alliance-cart-list')?.addEventListener('change', function(e){
            var input = e.target.closest('.alliance-cart-qty-input');
            if (!input || !input.getAttribute('data-id')) return;
            window.allianceCart.setQty(input.getAttribute('data-id'), input.value);
        });

        document.querySelectorAll('.js-site-currency').forEach(function(btn){
            btn.addEventListener('click', function(){
                if (shopCurrencyCfg().allowSwitch === false) return;
                setDisplayCurrency(btn.getAttribute('data-currency'));
            });
        });

        setDisplayCurrency(getDisplayCurrency());

        document.addEventListener('click', function(e){
            var btn = e.target.closest('.js-add-to-cart');
            if (!btn || btn.disabled) return;
            e.preventDefault();
            e.stopPropagation();
            var raw = btn.getAttribute('data-item');
            if (!raw) return;
            try {
                var item = JSON.parse(raw);
                var qtyInput = document.getElementById('alliance-book-qty');
                var qty = 1;
                if (qtyInput) {
                    qty = parseInt(qtyInput.value, 10);
                    if (isNaN(qty) || qty < 1) qty = 1;
                    if (qty > 999) qty = 999;
                }
                window.allianceCart.add(item.id, item.title, item.price, qty, item.currency, item.cover_url);
                window.allianceSiteToast('« ' + item.title + ' » (' + qty + ') ajouté au panier.', 'success');
            } catch (err) { console.error(err); }
        });

        document.addEventListener('click', function(e){
            var bulk = e.target.closest('.js-add-all-books-to-cart');
            if (!bulk || bulk.disabled) return;
            e.preventDefault();
            var raw = bulk.getAttribute('data-books');
            if (!raw) return;
            try {
                var books = JSON.parse(raw);
                if (!Array.isArray(books) || !books.length) return;
                books.forEach(function(item){
                    window.allianceCart.add(item.id, item.title, item.price, 1, item.currency, item.cover_url);
                });
                window.allianceSiteToast(books.length + ' produit(s) ajouté(s) au panier.', 'success');
            } catch (err) { console.error(err); }
        });

        /** Ajoute au panier puis ouvre le checkout (action « Acheter » slider / modale). */
        document.addEventListener('click', function(e){
            var buy = e.target.closest('.js-buy-now');
            if (!buy || buy.disabled) return;
            e.preventDefault();
            e.stopPropagation();
            var raw = buy.getAttribute('data-item');
            if (!raw) return;
            try {
                var item = JSON.parse(raw);
                window.allianceCart.add(item.id, item.title, item.price, 1, item.currency, item.cover_url);
                window.allianceSiteToast('« ' + item.title + ' » — finalisation de la commande…', 'success');
                var cartModal = document.getElementById('allianceCartModal');
                if (cartModal) {
                    bootstrap.Modal.getInstance(cartModal)?.hide();
                }
                setTimeout(function(){
                    var checkout = document.getElementById('allianceCheckoutModal');
                    if (checkout && typeof bootstrap !== 'undefined') {
                        bootstrap.Modal.getOrCreateInstance(checkout).show();
                    }
                }, 350);
            } catch (err) { console.error(err); }
        });

        bindAjaxForm(document.getElementById('contact-page-form'));
        bindAjaxForm(document.getElementById('home-appointment-form'));
        bindAjaxForm(document.getElementById('footer-newsletter-form'));

        (function initHeaderLiveSearch(){
            var inner = document.querySelector('.search-inner[data-search-suggest-url]');
            if (!inner) return;
            var urlBase = inner.getAttribute('data-search-suggest-url');
            var input = document.getElementById('header-search-q');
            var box = document.getElementById('search-live-results');
            if (!input || !box || !urlBase) return;

            var suggestTimer = null;
            var suggestAbort = null;

            function contentTypeLabel(t) {
                var m = { video: 'Vidéo', audio: 'Audio', podcast: 'Podcast', article: 'Article' };
                return m[t] || (t ? t : 'Contenu');
            }

            function hideLiveResults() {
                box.classList.add('d-none');
                box.innerHTML = '';
            }

            function renderLiveResults(data) {
                var html = '';
                var nc = (data.contents && data.contents.length) || 0;
                var nb = (data.books && data.books.length) || 0;
                var ns = (data.series && data.series.length) || 0;
                var na = (data.activities && data.activities.length) || 0;
                if (nc + nb + ns + na === 0) {
                    box.innerHTML = '<p class="search-live-empty">Aucun résultat pour cette recherche.</p>';
                    box.classList.remove('d-none');
                    return;
                }
                if (nc) {
                    html += '<p class="search-live-section-title">Contenus</p>';
                    data.contents.forEach(function(item){
                        html += '<a href="' + escapeHtml(item.url) + '"><span>' + escapeHtml(item.title) + '</span><span class="search-live-meta">' + escapeHtml(contentTypeLabel(item.type)) + '</span></a>';
                    });
                }
                if (nb) {
                    html += '<p class="search-live-section-title">Livres</p>';
                    data.books.forEach(function(item){
                        html += '<a href="' + escapeHtml(item.url) + '"><span>' + escapeHtml(item.title) + '</span><span class="search-live-meta">Livre</span></a>';
                    });
                }
                if (ns) {
                    html += '<p class="search-live-section-title">Séries</p>';
                    data.series.forEach(function(item){
                        html += '<a href="' + escapeHtml(item.url) + '"><span>' + escapeHtml(item.title) + '</span><span class="search-live-meta">Série</span></a>';
                    });
                }
                if (na) {
                    html += '<p class="search-live-section-title">Agenda</p>';
                    data.activities.forEach(function(item){
                        var meta = item.meta ? escapeHtml(item.meta) : 'Activité';
                        html += '<a href="' + escapeHtml(item.url) + '"><span>' + escapeHtml(item.title) + '</span><span class="search-live-meta">' + meta + '</span></a>';
                    });
                }
                box.innerHTML = html;
                box.classList.remove('d-none');
            }

            box.addEventListener('click', function(e){
                var a = e.target.closest('a[href]');
                if (!a || !box.contains(a)) return;
                document.querySelector('.main-header')?.classList.remove('moblie-search-active');
                hideLiveResults();
            });

            input.addEventListener('input', function(){
                var q = input.value.trim();
                clearTimeout(suggestTimer);
                if (suggestAbort) suggestAbort.abort();
                if (q.length < 2) {
                    hideLiveResults();
                    return;
                }
                suggestTimer = setTimeout(function(){
                    suggestAbort = new AbortController();
                    box.innerHTML = '<p class="search-live-loading">Recherche en cours…</p>';
                    box.classList.remove('d-none');
                    fetch(urlBase + '?q=' + encodeURIComponent(q), {
                        method: 'GET',
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        signal: suggestAbort.signal,
                        credentials: 'same-origin'
                    }).then(function(r){ return r.json(); })
                        .then(renderLiveResults)
                        .catch(function(err){
                            if (err.name === 'AbortError') return;
                            hideLiveResults();
                        });
                }, 320);
            });

            function onSearchClosed() {
                hideLiveResults();
                if (suggestAbort) suggestAbort.abort();
                clearTimeout(suggestTimer);
            }

            document.querySelector('.search-popup .close-search')?.addEventListener('click', onSearchClosed);
            document.querySelector('.search-popup .search-back-drop')?.addEventListener('click', onSearchClosed);

            document.addEventListener('keydown', function(e){
                if (e.key !== 'Escape') return;
                if (!document.querySelector('.main-header')?.classList.contains('moblie-search-active')) return;
                onSearchClosed();
            });
        })();
    });
})();
</script>

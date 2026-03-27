<script>
document.addEventListener('DOMContentLoaded', function () {
    var csrf = document.querySelector('meta[name="csrf-token"]');
    var token = csrf ? csrf.getAttribute('content') : '';

    function setContentLikeLoading(btn, on) {
        if (!btn) return;
        btn.classList.toggle('alliance-async-busy', !!on);
        btn.disabled = !!on;
        btn.setAttribute('aria-busy', on ? 'true' : 'false');
        var sp = btn.querySelector('.alliance-async-spinner');
        if (on) {
            if (!sp) {
                sp = document.createElement('span');
                sp.className = 'spinner-border spinner-border-sm alliance-async-spinner me-1';
                sp.setAttribute('role', 'status');
                sp.innerHTML = '<span class="visually-hidden">Chargement…</span>';
                btn.insertBefore(sp, btn.firstChild);
            }
            sp.classList.remove('d-none');
        } else if (sp) {
            sp.classList.add('d-none');
        }
    }

    function updateContentLikeUi(slug, btn, data) {
        if (typeof data.count !== 'number' || !slug) return;
        document.querySelectorAll('.alliance-content-like-count-num[data-for-slug="' + slug + '"]').forEach(function (el) {
            el.textContent = data.count;
        });
        document.querySelectorAll('.alliance-content-like-btn:not(.alliance-content-like-guest)[data-content-slug="' + slug + '"]').forEach(function (b) {
            var icon = b.querySelector('i');
            if (data.liked) {
                b.classList.remove('btn-outline-secondary');
                b.classList.add('btn-warning', 'text-dark');
                b.setAttribute('aria-pressed', 'true');
                b.setAttribute('data-liked', '1');
                if (icon) icon.className = 'fa fa-heart';
            } else {
                b.classList.add('btn-outline-secondary');
                b.classList.remove('btn-warning', 'text-dark');
                b.setAttribute('aria-pressed', 'false');
                b.setAttribute('data-liked', '0');
                if (icon) icon.className = 'fa fa-heart-o';
            }
        });
    }

    document.querySelectorAll('.alliance-content-like-btn.alliance-content-like-guest').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var url = btn.getAttribute('data-like-url');
            if (!url) return;
            sessionStorage.setItem('alliance_pending_content_like_url', url);
            btn.setAttribute('data-pending-sync', '1');
            var m = document.getElementById('allianceOtpAuthModal');
            if (m && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                bootstrap.Modal.getOrCreateInstance(m).show();
            }
        });
    });

    document.querySelectorAll('.alliance-content-like-btn:not(.alliance-content-like-guest)').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var url = btn.getAttribute('data-like-url');
            var slug = btn.getAttribute('data-content-slug');
            if (!url) return;
            setContentLikeLoading(btn, true);
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: '{}',
                credentials: 'same-origin'
            }).then(function (r) {
                if (r.status === 401) {
                    sessionStorage.setItem('alliance_pending_content_like_url', url);
                    btn.setAttribute('data-pending-sync', '1');
                    var om = document.getElementById('allianceOtpAuthModal');
                    if (om && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        bootstrap.Modal.getOrCreateInstance(om).show();
                    }
                    return Promise.reject();
                }
                return r.json();
            }).then(function (data) {
                if (data) updateContentLikeUi(slug, btn, data);
            }).catch(function () {})
            .finally(function () { setContentLikeLoading(btn, false); });
        });
    });
});
</script>
<style>
    .alliance-content-like-pill.alliance-async-busy { opacity: 0.88; }
    .alliance-content-like-pill .alliance-async-spinner { vertical-align: -0.125em; }
</style>

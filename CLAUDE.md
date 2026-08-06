# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project overview

Laravel 13 (PHP 8.3) website for a pastoral/ministry organization ("Tothy Mbengela"): public site with sermons/teachings ("contenus"), series, a book shop, donations, partnership/pledge commitments, appointment requests, and a newsletter — plus a Filament 5 admin panel for managing all of it. Auth uses Laravel Breeze with an added OTP (one-time-code) flow for register/login.

## Commands

- Install deps: `composer install && npm install`
- Local dev (server + queue + logs + vite, all at once): `composer run dev`
- Build frontend assets: `npm run build`
- Dev-only asset watch: `npm run dev` (vite)
- Run all tests: `composer run test` (clears config, then `php artisan test`)
- Run a single test: `php artisan test --filter=TestName` (PHPUnit, see `phpunit.xml`)
- Filament admin panel upgrade hook runs automatically post-autoload (`filament:upgrade`)

## Architecture

- **Public site controllers** (`app/Http/Controllers`): content/series/books browsing, search, contact, appointment requests, donations, partner pledges, checkout, newsletter (double opt-in via signed token), and an `AccountController` for the authenticated "Mon compte" area (activity, purchases, donations, partnerships).
- **Admin panel**: Filament v5 resources under `app/Filament/Resources` (one folder per model: Books, Donations, Orders, PastorActivities, TeamMembers, Themes, Users, etc.), each split into `Schemas` (form) and `Tables` (list) plus `Pages` (Create/Edit/List). `bezhansalleh/filament-shield` is installed for role/permission-gated resource access.
- **Models** (`app/Models`): core domain is Content/Series/Rubrique (sermons & categories), Book/Order/OrderItem (shop), Donation/PartnerCommitment (giving), TeamMember/PastorActivity (org content), ContactMessage/AppointmentRequest, NewsletterSubscriber, Testimonial, Theme, plus `Admin` and `User`.
- **Payments**: FlexPay (Mobile Money + card) integration, implemented in `app/Services/FlexPayService.php` and `DonationPaymentController`. Full integration guide (config, backend files, frontend snippets, routes, migrations) lives in `docs/integration-paiement-flexpay/` — read `docs/integration-paiement-flexpay/README.md` first if touching payments. Payment flow: form submits to `/paiement/init-don` or `/commande/init` → mobile money polls `/paiement/statut`, card redirects to FlexPay and returns to `/paid/{reference}/{amount}/{currency}/{status}`.
- **Auth**: Breeze-based (`routes/auth.php`) extended with `Auth/OtpAuthController` for code-based register/login (throttled endpoints `register/send-code`, `register/verify`, `login/send-code`, etc.), in addition to standard password reset/email verification/confirm-password controllers.
- **Routing**: all public/user routes in `routes/web.php` (French URL segments: `/don`, `/boutique`, `/partenaire`, `/mon-compte`, etc.), auth routes required in from `routes/auth.php`.
- Frontend: Blade + Tailwind + Alpine.js, bundled via Vite; `shepherd.js` is included (likely for onboarding/guided tours).

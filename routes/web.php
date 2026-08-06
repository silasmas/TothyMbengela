<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentCommentController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ContentLikeController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationPaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OpsMigrateController;
use App\Http\Controllers\PastorActivityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\ShopCheckoutController;
use App\Http\Controllers\TeamMemberController;
use Illuminate\Support\Facades\Route;

// ─── Pages publiques ──────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [HomeController::class, 'about'])->name('about');
Route::get('/activites-pasteure', [PastorActivityController::class, 'index'])->name('pastor-activities.index');
Route::get('/activites-pasteure/{pastorActivity:slug}', [PastorActivityController::class, 'show'])->name('pastor-activities.show');
Route::get('/equipe/{teamMember:slug}', [TeamMemberController::class, 'show'])->name('team.show');

// Contenus (prédications, enseignements, etc.)
Route::get('/recherche/suggestions', [SearchController::class, 'suggestions'])->name('search.suggest');
Route::get('/recherche', [SearchController::class, 'index'])->name('search');

Route::get('/contenus', [ContentController::class, 'index'])->name('contents.index');
Route::get('/contenus/{slug}', [ContentController::class, 'show'])->name('contents.show');
Route::post('/contenus/{slug}/commentaires', [ContentCommentController::class, 'store'])
    ->middleware('auth')
    ->name('contents.comments.store');
Route::post('/contenus/{slug}/commentaires/{comment}/like', [ContentCommentController::class, 'toggleLike'])
    ->middleware('auth')
    ->name('contents.comments.like');
Route::post('/contenus/{slug}/like', [ContentLikeController::class, 'toggle'])
    ->middleware('auth')
    ->name('contents.like');

// Séries
Route::get('/series', [SeriesController::class, 'index'])->name('series.index');
Route::get('/series/{slug}', [SeriesController::class, 'show'])->name('series.show');

// Boutique (livres)
Route::get('/boutique', [BookController::class, 'index'])->name('books.index');
Route::get('/boutique/{slug}', [BookController::class, 'show'])->name('books.show');

// Contact
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Rendez-vous (formulaire global en bas de page — ancre #prise-rendez-vous)
Route::post('/rendez-vous', [ContactController::class, 'appointmentStore'])->name('appointment.store');

// Don
Route::get('/don', [DonationController::class, 'donateForm'])->name('donate.create');
Route::post('/don', [DonationController::class, 'donateStore'])->name('donate.store');
Route::get('/don/merci', fn () => view('pages.donate-thanks'))->name('donate.merci');

// Paiement en ligne (prestataire configuré dans .env — voir docs/integration-paiement-flexpay/)
Route::post('/paiement/init-don', [DonationPaymentController::class, 'initDon'])->name('payment.init.don');
Route::post('/paiement/init-partenaire', [DonationPaymentController::class, 'initPartner'])->middleware('auth')->name('payment.init.partner');
Route::post('/commande/init', [ShopCheckoutController::class, 'initOrder'])->name('shop.order.init');
Route::post('/paiement/process', [DonationPaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/paiement/statut', [DonationPaymentController::class, 'checkTransactionStatus'])->name('payment.check');
Route::get('/paid/{reference}/{amount}/{currency}/{status}', [DonationPaymentController::class, 'paid'])
    ->where([
        'reference' => '[A-Za-z0-9\-]+',
        'amount' => '[0-9.]+',
        'currency' => '[A-Z]{3}',
        'status' => 'success|cancel|decline',
    ])
    ->name('paid');

// Partenariat
Route::get('/partenaire', [DonationController::class, 'partnerForm'])->name('partner.create');
Route::post('/partenaire', [DonationController::class, 'partnerStore'])->name('partner.store');

// Newsletter (double opt-in)
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');
Route::get('/newsletter/confirmer/{token}', [NewsletterController::class, 'confirm'])
    ->name('newsletter.confirm')
    ->where('token', '[A-Za-z0-9]+');

// ─── Espace utilisateur (Breeze) ──────────────────────────
// Même écran que « Mon compte » (après connexion, liens Breeze/OTP vers dashboard).
Route::get('/dashboard', [AccountController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/mon-compte', [AccountController::class, 'index'])->name('account.index');
    Route::get('/mon-compte/transactions', [AccountController::class, 'activity'])->name('account.activity');
    Route::get('/mon-compte/achats', [AccountController::class, 'purchases'])->name('account.purchases');
    Route::get('/mon-compte/dons', [AccountController::class, 'donations'])->name('account.donations');
    Route::get('/mon-compte/partenariats', [AccountController::class, 'partnerships'])->name('account.partnerships');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Generate symbolic link
Route::get('/symlink', function () {
    return view('symlink');
})->name('generate_symlink');

// Migrations en production via URL (protégé par MIGRATE_TOKEN)
Route::get('/ops/migrate', OpsMigrateController::class)
    ->middleware('throttle:3,10')
    ->name('ops.migrate');

require __DIR__.'/auth.php';


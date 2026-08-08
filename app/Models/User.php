<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

#[Fillable([
    'name',
    'email',
    'email_verified_at',
    'password',
    'phone',
    'whatsapp',
    'country',
    'city',
    'address_line',
    'bio',
    'avatar_path',
    'preferred_locale',
    'birthdate',
    'gender',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthdate' => 'date',
        ];
    }

    public function partnerCommitments(): HasMany
    {
        return $this->hasMany(PartnerCommitment::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function contentLikes(): HasMany
    {
        return $this->hasMany(ContentLike::class);
    }

    /**
     * Retrouve un utilisateur par e-mail ou en crée un (mot de passe aléatoire).
     *
     * @param  string  $email  E-mail
     * @param  string  $name  Nom affiché
     * @return self
     */
    public static function findOrRegisterByEmail(string $email, string $name): self
    {
        $email = mb_strtolower(trim($email));
        $name = trim($name) !== '' ? trim($name) : 'Partenaire Alliance';

        $user = static::query()->where('email', $email)->first();
        if ($user) {
            if ($user->name === '' || $user->name === null) {
                $user->forceFill(['name' => $name])->save();
            }

            return $user;
        }

        return static::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make(Str::random(32)),
            'email_verified_at' => now(),
            'preferred_locale' => 'fr',
        ]);
    }
}

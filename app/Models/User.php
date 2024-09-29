<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Nom_Fr',
        'Prenom_Fr',
        'Nom_Ar',
        'Prenom_Ar',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
     // Relation avec le modèle EntiteTerritoriale
     public function entiteTerritoriale()
     {
         return $this->hasOne(Entiteterritorielle::class, 'managed_by');
     }
    public function auxiliaires()
{
    return $this->hasMany(Auxiliaire::class);
}
public function enfants()
{
    return $this->hasMany(Enfant::class);
}
public function conjoints()
{
    return $this->hasMany(Conjoint::class);
}

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entiteterritorielle extends Model
{
    use HasFactory;

    protected $fillable = [
        'Nom',
        'Nom_Ar',
        'type',
        'managed_by',
    ];

    // Relation avec l'utilisateur qui gère
    public function manager()
    {
        return $this->belongsTo(User::class, 'managed_by');
    }
    
    public function auxiliaires()
{
    return $this->hasMany(Auxiliaire::class);
}

}

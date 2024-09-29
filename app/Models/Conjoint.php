<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conjoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'Nom_Fr',
        'Prenom_Fr',
        'Nom_Ar',
        'Prenom_Ar',
        'CNIE',
        'user_id',
        'updated_by',
        'auxiliaire_id',
    ];

    /**
     * Relationship to the `Auxiliaire` model.
     * A Conjoint belongs to an Auxiliaire.
     */
    public function auxiliaire()
    {
        return $this->belongsTo(Auxiliaire::class);
    }

    /**
     * Relationship to the `User` model for created_by.
     * A Conjoint is created by a User.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship to the `User` model for updated_by.
     * A Conjoint is updated by a User.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

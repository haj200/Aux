<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auxiliaire extends Model

{
    use HasFactory;

    protected $fillable = [
        'Nom_Fr',
        'Prenom_Fr',
        'Nom_Ar',
        'Prenom_Ar',
        'Email',
        'Grade',
        'CNIE',
        'url_photo',
        'RIB',
        'date_de_naissance',
        'date_de_recrutement',
        'Type',
        'pensionne',
        'user_id',
        'updated_by',
        'entiteterritorielle_id',
    ];

    // Define relationships if needed
    public function entiteTerritorielle() {
        return $this->belongsTo(Entiteterritorielle::class,'entiteterritorielle_id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function enfants()
    {
        return $this->hasMany(Enfant::class);
    }

    // Relation avec les conjoints
    public function conjoints()
    {
        return $this->hasMany(Conjoint::class);
    }
}

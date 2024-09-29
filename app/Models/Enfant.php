<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfant extends Model
{
    use HasFactory;

    // Define the table if it's not the plural of the model name
    protected $table = 'enfants';

    // Define fillable attributes
    protected $fillable = [
        'Nom_Fr',
        'Prenom_Fr',
        'Nom_Ar',
        'Prenom_Ar',
        'Date_De_Naissance',
        'user_id',
        'updated_by',
        'auxiliaire_id',
    ];

    /**
     * Relationships
     */

    // Creator
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Updater
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Auxiliaire
    public function auxiliaire()
    {
        return $this->belongsTo(Auxiliaire::class);
    }}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'specialite',
        'telephone',
        'email',
        'horaires_disponibles'
    ];

    protected $casts = [
        'horaires_disponibles' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }
}
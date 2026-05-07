<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'telephone',
        'date_naissance',
        'adresse'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class, 'patient_id');
    }
}
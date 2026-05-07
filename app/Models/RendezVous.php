<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    // ← Forcer le nom de la table
    protected $table = 'rendez_vous';

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'date',
        'heure',
        'motif',
        'statut'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }
}
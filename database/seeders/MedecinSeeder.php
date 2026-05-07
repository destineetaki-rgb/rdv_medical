<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medecin;

class MedecinSeeder extends Seeder
{
    public function run(): void
    {
        $medecins = [
            [
                'nom'       => 'Ben Ali',
                'prenom'    => 'Karim',
                'specialite'=> 'Cardiologie',
                'telephone' => '0551234567',
                'email'     => 'k.benali@rdv.com',
                'horaires_disponibles' => json_encode(['lundi', 'mercredi', 'vendredi']),
            ],
            [
                'nom'       => 'Cherif',
                'prenom'    => 'Samira',
                'specialite'=> 'Pédiatrie',
                'telephone' => '0559876543',
                'email'     => 's.cherif@rdv.com',
                'horaires_disponibles' => json_encode(['mardi', 'jeudi']),
            ],
            [
                'nom'       => 'Mansouri',
                'prenom'    => 'Youcef',
                'specialite'=> 'Médecine Générale',
                'telephone' => '0555555555',
                'email'     => 'y.mansouri@rdv.com',
                'horaires_disponibles' => json_encode(['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi']),
            ],
            [
                'nom'       => 'Boudiaf',
                'prenom'    => 'Leila',
                'specialite'=> 'Dermatologie',
                'telephone' => '0553332211',
                'email'     => 'l.boudiaf@rdv.com',
                'horaires_disponibles' => json_encode(['lundi', 'jeudi']),
            ],
        ];

        foreach ($medecins as $medecin) {
            Medecin::create($medecin);
        }
    }
}
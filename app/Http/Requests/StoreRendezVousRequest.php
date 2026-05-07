<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRendezVousRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'medecin_id' => 'required|exists:medecins,id',
            'date'       => 'required|date|after_or_equal:today',
            'heure'      => [
                'required',
                'date_format:H:i',
                Rule::unique('rendez_vous')->where(
                    fn($q) => $q
                        ->where('medecin_id', $this->medecin_id)
                        ->where('date', $this->date)
                ),
            ],
            'motif' => 'required|string|min:5',
        ];
    }

    public function messages(): array
    {
        return [
            'medecin_id.required' => 'Veuillez choisir un médecin.',
            'medecin_id.exists'   => "Ce médecin n'existe pas.",
            'date.required'       => 'La date est obligatoire.',
            'date.after_or_equal' => 'La date doit être aujourd\'hui ou dans le futur.',
            'heure.required'      => 'L\'heure est obligatoire.',
            'heure.date_format'   => 'Format d\'heure invalide (HH:MM).',
            'heure.unique'        => 'Ce créneau est déjà réservé.',
            'motif.required'      => 'Le motif est obligatoire.',
            'motif.min'           => 'Le motif doit contenir au moins 5 caractères.',
        ];
    }
}
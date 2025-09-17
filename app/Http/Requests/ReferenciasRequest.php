<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReferenciasRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function prepareForValidation(): void
    {
        // Normaliza colección
        $refs = $this->referencias ?? [];
        if (is_array($refs)) {
            $refs = array_map(function($r){
                if (!is_array($r)) return $r;
                $r['nombre']   = isset($r['nombre']) ? trim($r['nombre']) : null;
                $r['relacion'] = isset($r['relacion']) ? trim($r['relacion']) : null;
                $r['email']    = isset($r['email']) ? mb_strtolower(trim($r['email'])) : null;
                $r['telefono'] = isset($r['telefono']) ? preg_replace('/\D+/', '', $r['telefono']) : null;
                return $r;
            }, $refs);
        }
        $this->merge(['referencias' => $refs]);
    }

    public function rules(): array
    {
        return [
            'solicitud_id'           => ['required','uuid','exists:solicitudes,id'],
            'referencias'            => ['required','array','min:1','max:5'],
            'referencias.*.nombre'   => ['required','string','max:150'],
            'referencias.*.relacion' => ['nullable','string','max:100'],
            'referencias.*.telefono' => ['nullable','digits_between:7,15'],
            'referencias.*.email'    => ['nullable','email','max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'referencias.required' => 'Debes proporcionar al menos una referencia.',
            'referencias.min'      => 'Debes proporcionar al menos una referencia.',
            'referencias.*.nombre.required' => 'Cada referencia debe tener un nombre.',
        ];
    }
}

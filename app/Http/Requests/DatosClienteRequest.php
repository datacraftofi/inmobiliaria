<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DatosClienteRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function prepareForValidation(): void
    {
        // Normaliza strings y formatos comunes
        $doc = isset($this->documento) ? preg_replace('/\D+/', '', $this->documento) : null; // solo dígitos
        $tel = isset($this->telefono) ? preg_replace('/\D+/', '', $this->telefono) : null;   // solo dígitos

        $this->merge([
            'tipo_persona' => $this->tipo_persona ? strtoupper(trim($this->tipo_persona)) : null, // PN|PJ
            'perfil_laboral' => $this->perfil_laboral ? strtolower(trim($this->perfil_laboral)) : null, // asalariado|independiente
            'nombre' => isset($this->nombre) ? trim($this->nombre) : null,
            'razon_social' => isset($this->razon_social) ? trim($this->razon_social) : null,
            'email' => isset($this->email) ? mb_strtolower(trim($this->email)) : null,
            'documento' => $doc,
            'telefono'  => $tel,
        ]);
    }

    public function rules(): array
    {
        // Nota: ‘tipo_persona’ PN (persona natural) o PJ (persona jurídica)
        // ‘perfil_laboral’ asalariado|independiente (solo aplica para PN)
        return [
            'tipo_persona'   => ['required', Rule::in(['PN','PJ'])],

            // PN: nombre, documento (CC), email, telefono obligatorios
            'nombre'         => ['required_if:tipo_persona,PN','string','max:150'],
            'documento'      => ['required_if:tipo_persona,PN','string','min:5','max:20'],
            'email'          => ['required_if:tipo_persona,PN','email','max:255'],
            'telefono'       => ['nullable','digits_between:7,15'],

            // PJ: razón social, NIT
            'razon_social'   => ['required_if:tipo_persona,PJ','string','max:255'],
            'nit'            => ['required_if:tipo_persona,PJ','string','max:20'], // puedes validar dígito verificación aparte

            // Perfil laboral PN
            'perfil_laboral' => ['required_if:tipo_persona,PN', Rule::in(['asalariado','independiente'])],

            // Campos condicionales por perfil
            'empresa'        => ['required_if:perfil_laboral,asalariado','nullable','string','max:255'],
            'ingresos_mensuales' => ['required','numeric','min:0'],

            // Dirección opcional (normalizada)
            'direccion'      => ['nullable','string','max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'tipo_persona.required' => 'Debes indicar si es Persona Natural (PN) o Jurídica (PJ).',
            'tipo_persona.in'       => 'El tipo_persona debe ser PN o PJ.',

            'nombre.required_if'    => 'El nombre es obligatorio para Persona Natural.',
            'documento.required_if' => 'El documento es obligatorio para Persona Natural.',
            'email.required_if'     => 'El email es obligatorio para Persona Natural.',
            'razon_social.required_if' => 'La razón social es obligatoria para Persona Jurídica.',
            'nit.required_if'       => 'El NIT es obligatorio para Persona Jurídica.',

            'perfil_laboral.required_if' => 'Debes indicar el perfil laboral para PN.',
            'perfil_laboral.in'     => 'El perfil laboral debe ser asalariado o independiente.',

            'empresa.required_if'   => 'La empresa es obligatoria para asalariados.',
            'ingresos_mensuales.required' => 'Debes informar ingresos_mensuales.',
        ];
    }
}

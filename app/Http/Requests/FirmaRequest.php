<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class FirmaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function prepareForValidation(): void
    {
        // Si recibes base64, puedes normalizarlo aquí (quitar encabezado data:image/png;base64,)
        if ($this->filled('firma_base64')) {
            $b64 = trim($this->firma_base64);
            $b64 = preg_replace('#^data:image/\w+;base64,#', '', $b64);
            $this->merge(['firma_base64' => $b64]);
        }
    }

    public function rules(): array
    {
        return [
            'solicitud_id' => ['required','uuid','exists:solicitudes,id'],

            // Opción A: archivo subido (PNG/JPG)
            'firma'        => [
                'nullable',
                'file',
                File::image()->max(5 * 1024), // 5 MB
            ],

            // Opción B: base64 (si tu front lo envía así)
            'firma_base64' => ['nullable','string'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($v){
            // Exige al menos una fuente de firma
            if (!$this->hasFile('firma') && !$this->filled('firma_base64')) {
                $v->errors()->add('firma', 'Debes proporcionar la firma como archivo o en base64.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'firma.image' => 'La firma debe ser una imagen (PNG/JPG).',
        ];
    }
}

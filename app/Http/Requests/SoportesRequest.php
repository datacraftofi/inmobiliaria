<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class SoportesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // 'max' en archivos es en KB
        $maxPdfMb = 10; // ajusta a gusto
        $maxImgMb = 5;
        $maxPdfKb = $maxPdfMb * 1024;
        $maxImgKb = $maxImgMb * 1024;

        return [
            'solicitud_id' => ['required', 'uuid', 'exists:solicitudes,id'],

            // Opción 1: supports[] (simple)
            'supports'     => ['nullable', 'array', 'min:1'],
            'supports.*'   => [
                'file',
                // Permitimos pdf e imágenes (ambos comparten el mismo max aquí)
                File::types(['pdf', 'jpeg', 'png', 'jpg'])->max($maxPdfKb),
            ],

            // Opción 2: items[].file + items[].tipo (estructurado)
            'items'        => ['nullable', 'array', 'min:1'],
            'items.*.file' => [
                'required_with:items',
                'file',
                File::types(['pdf', 'jpeg', 'png', 'jpg'])->max($maxPdfKb),
            ],
            'items.*.tipo' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'solicitud_id.required' => 'Debes indicar el ID de la solicitud.',
            'solicitud_id.uuid'     => 'El ID de la solicitud no es un UUID válido.',
            'solicitud_id.exists'   => 'La solicitud indicada no existe.',

            'supports.array'        => 'El campo supports debe ser un arreglo.',
            'supports.min'          => 'Debes enviar al menos un soporte en supports.',
            'supports.*.file'       => 'Cada soporte debe ser un archivo válido.',
            'supports.*.mimes'      => 'Formato no permitido en supports. Usa PDF, JPG o PNG.',
            'supports.*.max'        => 'El archivo en supports excede el tamaño permitido.',

            'items.array'           => 'El campo items debe ser un arreglo.',
            'items.min'             => 'Debes enviar al menos un soporte en items.',
            'items.*.file.required_with' => 'Falta el archivo del soporte en items.',
            'items.*.file.file'     => 'El campo items.*.file debe ser un archivo.',
            'items.*.file.mimes'    => 'Formato no permitido en items.*.file. Usa PDF, JPG o PNG.',
            'items.*.file.max'      => 'El archivo en items.*.file excede el tamaño permitido.',
            'items.*.tipo.string'   => 'El tipo del soporte debe ser texto.',
            'items.*.tipo.max'      => 'El tipo del soporte no puede superar 100 caracteres.',
        ];
    }
}

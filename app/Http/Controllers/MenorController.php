<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatosUsuario;
use App\Models\Menor;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MenorController extends Controller
{
    // Mostrar formulario para agregar menores ligados a tutor
    public function formulario(DatosUsuario $usuario)
    {
        return view('inscripcion.menor', compact('usuario'));
    }

    // Guardar menores ligados a tutor
    public function guardar(Request $request, DatosUsuario $usuario)
{
    $request->validate([
        'nombres' => 'required|regex:/^[\pL\s]+$/u',
        'ap_paterno' => 'required|regex:/^[\pL\s]+$/u',
        'ap_materno' => 'required|regex:/^[\pL\s]+$/u',
        'rut' => 'required|regex:/^\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]$/|unique:menores,rut',
        'fecha_nacimiento' => 'required|date',
        'genero' => 'required|in:Masculino,Femenino,Otro',
        'carnet_control_sano' => 'required|file|mimes:pdf,jpg,png|max:2048',
        'certificado_nacimiento' => 'required|file|mimes:pdf,jpg,png|max:2048',
    ]);

    $edad = \Carbon\Carbon::parse($request->fecha_nacimiento)->age;
    if ($edad >= 6) {
        return back()->withErrors(['fecha_nacimiento' => 'El menor debe ser menor de 6 años'])->withInput();
    }

    $archivoControlSano = $request->file('carnet_control_sano')->store('public/archivos');
    $archivoCertificado = $request->file('certificado_nacimiento')->store('public/archivos');

    Menor::create([
        'usuario_id' => $usuario->id,
        'nombres' => $request->nombres,
        'ap_paterno' => $request->ap_paterno,
        'ap_materno' => $request->ap_materno,
        'rut' => $request->rut,
        'fecha_nacimiento' => $request->fecha_nacimiento,
        'genero' => $request->genero,
        'edad' => $edad,
        'carnet_control_sano' => $archivoControlSano,
        'certificado_nacimiento' => $archivoCertificado,
    ]);

    return redirect()->route('menor.formulario', $usuario->id)
        ->with('success', 'Menor registrado correctamente. Puede agregar otro o finalizar.');
}

}

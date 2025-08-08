<?php

namespace App\Http\Controllers;

use App\Models\Menor;
use App\Models\DatosUsuario;
use Illuminate\Http\Request;

class MenorController extends Controller
{
    public function formulario($usuario_id)
    {
        $usuario = DatosUsuario::findOrFail($usuario_id);
        return view('inscripcion.menor', compact('usuario'));
    }

    public function guardar(Request $request, $usuario_id)
    {
        $request->validate([
            'nombres' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'ap_paterno' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'ap_materno' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'rut' => 'required|unique:menores,rut',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:Masculino,Femenino',
            'carnet_control_sano' => 'required|file|mimes:pdf',
            'certificado_nacimiento' => 'required|file|mimes:pdf',
        ]);

        $edad = \Carbon\Carbon::parse($request->fecha_nacimiento)->age;

        $carnet = $request->file('carnet_control_sano')->store('public/archivos');
        $certificado = $request->file('certificado_nacimiento')->store('public/archivos');

        Menor::create([
            'usuario_id' => $usuario_id,
            'nombres' => $request->nombres,
            'ap_paterno' => $request->ap_paterno,
            'ap_materno' => $request->ap_materno,
            'rut' => $request->rut,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
            'edad' => $edad,
            'carnet_control_sano' => $carnet,
            'certificado_nacimiento' => $certificado,
        ]);

        return redirect()->route('menor.formulario', $usuario_id)->with('success', 'Menor registrado. Puedes agregar otro o finalizar.');
    }
}

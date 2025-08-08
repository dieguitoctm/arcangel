<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatosUsuario;
use App\Models\Embarazada;
use App\Models\Menor;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class InscripcionController extends Controller
{
    // Página de bienvenida
    public function bienvenida()
    {
        return view('bienvenida');
    }

    // Mostrar formulario único combinado
    public function formulario()
    {
        return view('inscripcion.formulario');
    }

    // Guardar datos del formulario combinado
    public function guardar(Request $request)
    {
        // Validar datos básicos del usuario
        $request->validate([
            'nombres' => 'required|regex:/^[\pL\s]+$/u',
            'ap_paterno' => 'required|regex:/^[\pL\s]+$/u',
            'ap_materno' => 'required|regex:/^[\pL\s]+$/u',
            'telefono' => 'required|regex:/^\+569\d{8}$/',
            'direccion' => 'required|max:50',
            'rut' => 'required|regex:/^\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]$/|unique:datos_usuarios,rut',
            'registro_social' => 'required|mimes:pdf,jpg,png|max:2048',
            // Datos embarazo opcionales si está embarazada
            'embarazada' => 'nullable|in:si,no',
            'meses_gestacion' => 'required_if:embarazada,si|integer|min:1|max:9',
            'carnet_gestacion' => 'required_if:embarazada,si|mimes:pdf,jpg,png|max:2048',
            // Datos menor - si tiene menor(s)
            'tiene_menor' => 'nullable|in:si,no',
            'menores' => 'required_if:tiene_menor,si|array',
            'menores.*.nombres' => 'required_with:menores|regex:/^[\pL\s]+$/u',
            'menores.*.ap_paterno' => 'required_with:menores|regex:/^[\pL\s]+$/u',
            'menores.*.ap_materno' => 'required_with:menores|regex:/^[\pL\s]+$/u',
            'menores.*.rut' => 'required_with:menores|regex:/^\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]$/|distinct',
            'menores.*.fecha_nacimiento' => 'required_with:menores|date',
            'menores.*.genero' => 'required_with:menores|in:Masculino,Femenino,Otro',
            'menores.*.carnet_control_sano' => 'required_with:menores|file|mimes:pdf,jpg,png|max:2048',
            'menores.*.certificado_nacimiento' => 'required_with:menores|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // Guardar archivo registro social
        $archivoRegistroSocial = $request->file('registro_social')->store('public/archivos');

        // Crear usuario
        $usuario = DatosUsuario::create([
            'nombres' => $request->nombres,
            'ap_paterno' => $request->ap_paterno,
            'ap_materno' => $request->ap_materno,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'rut' => $request->rut,
            'registro_social' => $archivoRegistroSocial,
        ]);

        // Si está embarazada, guardar datos embarazo
        if ($request->embarazada === 'si') {
            $archivoCarnet = $request->file('carnet_gestacion')->store('public/archivos');
            Embarazada::create([
                'usuario_id' => $usuario->id,
                'meses_gestacion' => $request->meses_gestacion,
                'carnet_gestacion' => $archivoCarnet,
            ]);
        }

        // Guardar menores si hay
        if ($request->tiene_menor === 'si' && is_array($request->menores)) {
            foreach ($request->menores as $menor) {
                $edad = Carbon::parse($menor['fecha_nacimiento'])->age;
                if ($edad >= 6) {
                    return back()
                        ->withErrors(['menores' => 'Todos los menores deben ser menores de 6 años'])
                        ->withInput();
                }

                $archivoControlSano = $menor['carnet_control_sano']->store('public/archivos');
                $archivoCertificado = $menor['certificado_nacimiento']->store('public/archivos');

                Menor::create([
                    'usuario_id' => $usuario->id,
                    'nombres' => $menor['nombres'],
                    'ap_paterno' => $menor['ap_paterno'],
                    'ap_materno' => $menor['ap_materno'],
                    'rut' => $menor['rut'],
                    'fecha_nacimiento' => $menor['fecha_nacimiento'],
                    'genero' => $menor['genero'],
                    'edad' => $edad,
                    'carnet_control_sano' => $archivoControlSano,
                    'certificado_nacimiento' => $archivoCertificado,
                ]);
            }
        }

        return redirect()->route('inscripcion.despedida');
    }
    public function index()
    {
        $usuarios = DatosUsuario::with(['embarazada', 'menores'])->paginate(10);

        return view('admin', compact('usuarios'));
    }
    public function update(Request $request, $id)
    {
        $usuario = DatosUsuario::findOrFail($id);

        $request->validate([
            'nombres' => 'required|regex:/^[\pL\s]+$/u',
            'ap_paterno' => 'required|regex:/^[\pL\s]+$/u',
            'ap_materno' => 'required|regex:/^[\pL\s]+$/u',
            'telefono' => 'required|regex:/^\+569\d{8}$/',
            'direccion' => 'required|max:50',
            'rut' => "required|regex:/^\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]$/|unique:datos_usuarios,rut,$id",
            // agrega reglas para archivos si es necesario
        ]);

        $usuario->update([
            'nombres' => $request->nombres,
            'ap_paterno' => $request->ap_paterno,
            'ap_materno' => $request->ap_materno,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'rut' => $request->rut,
        ]);

        return redirect()->route('admin.index')->with('success', 'Usuario actualizado');
    }


    public function destroy($id)
    {
        $usuario = DatosUsuario::findOrFail($id);
        $usuario->delete();
        return redirect()->route('admin.index')->with('success', 'Usuario eliminado correctamente.');
    }



    // Vista despedida
    public function despedida()
    {
        return view('despedida');
    }
}

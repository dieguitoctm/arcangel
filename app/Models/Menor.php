<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menor extends Model
{
    use HasFactory;

    protected $table = 'menores';

    protected $fillable = [
        'usuario_id',
        'nombres',
        'ap_paterno',
        'ap_materno',
        'rut',
        'fecha_nacimiento',
        'genero',
        'edad',
        'carnet_control_sano',
        'certificado_nacimiento',
    ];

    public function usuario()
    {
        return $this->belongsTo(DatosUsuario::class, 'usuario_id');
    }
}

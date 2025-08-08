<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosUsuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres', 'ap_paterno', 'ap_materno', 'telefono', 'direccion', 'rut', 'registro_social'
    ];

    // Relaciones:
    public function embarazada()
    {
        return $this->hasOne(Embarazada::class, 'usuario_id');
    }

    public function menores()
    {
        return $this->hasMany(Menor::class, 'usuario_id');
    }
}

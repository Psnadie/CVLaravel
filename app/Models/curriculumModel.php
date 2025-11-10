<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class curriculumModel extends Model
{
    protected $table = 'curriculos';

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'correo',
        'fecha_nac',
        'nota_med',
        'formacion',
        'habilidades',
        'path',
    ];

    // Devuelve URL pública de la imagen (o una por defecto)
    public function getPathUrl()
    {
        if ($this->path) {
            return url('storage/' . $this->path);
        }
        return url('assets/img/default-cv.jpg');
    }
}

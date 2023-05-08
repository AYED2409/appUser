<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    public $timestamps = false;

    use HasFactory;
    protected $table = 'etiqueta';
    protected $fillable = [
        'etiqueta',
    ];
    
    public function etiquetas() {
        return $this->hasMany ('App\Models\EnlaceEtiqueta', 'idetiqueta');
    }

}

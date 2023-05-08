<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnlaceEtiqueta extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'enlaceEtiqueta';
    protected $fillable = [
        'idenlace',
        'idetiqueta',
    ];
    
    public function etiqueta() {
        return $this->belongsTo('App\Models\Etiqueta', 'idetiqueta');
    }
    
    public function enlace() {
        return $this->belongsTo('App\Models\Enlace', 'idenlace');
    }

}

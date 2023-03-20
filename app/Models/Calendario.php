<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'ano_lectivo_id',
        'codigo',
        'data_inicio',
        'data_fim',
        'descricao',
        'is_terminado',
        'simestre',
        'tipo',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function ano_lectivo(){
        return $this->belongsTo(AnoLectivo::class);
    }

    public function calendario_prova(){
        return $this->hasMany(CalendarioProva::class);
    }    

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prova extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'professor_turma_id',
        'simestre',
        'tipo',
        'is_terminado',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'  
    ];

 
    public function professor_turma(){
        return $this->belongsTo(TurmaProfessor::class,'professor_turma_id','id');
    }

    public function notas(){
        return $this->hasMany(Nota::class);
    }

    public function calendario_prova(){
        return $this->hasMany(CalendarioProva::class);
    }


}

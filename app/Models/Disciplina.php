<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory, HasUuids;

    protected  $fillable = [
        'id',
        'nome',
        'descricao',
        'is_fechado',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'        
    ];

    public function cursos(){
        $anolectivo = AnoLectivo::actual();
        return $this->belongsToMany(Curso::class)
                    ->wherePivot('ano_lectivo_id',$anolectivo->id);
    }

    public function curso_disciplina(){
        return $this->hasMany(CursoDisciplina::class);
    }         
    
    public function professor_turma(){
        return $this->belongsTo(TurmaProfessor::class,'id','disciplina_id');
    }
    

}

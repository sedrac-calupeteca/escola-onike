<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurmaProfessor extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'professor_id',
        'turma_id',
        'disciplina_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $table = "professor_turma";

    public function turma(){
        return $this->hasOne(Turma::class,'id','turma_id');
    }

    public function disciplina(){
        return $this->hasOne(Disciplina::class,'id','disciplina_id');
    }
 
    public function professor(){
        return $this->hasOne(Professor::class,'id','professor_id');
    } 

    public function provas(){
        return $this->hasMany(Prova::class,'professor_turma_id','id');
    }     
 
    public function disciplinas(){
        return $this->hasMany(Disciplina::class,'id','disciplina_id');
    }   

}

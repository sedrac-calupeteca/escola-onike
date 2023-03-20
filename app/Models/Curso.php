<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory, HasUuids;

    protected  $fillable = [
        'id',
        'nome',
        'nivel',
        'num_classe',
        'descricao',
        'is_fechado',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'        
    ];

    protected $casts = [
        'is_fechado' => 'boolean',
    ];

    public function disciplinas(){
        $anolectivo = AnoLectivo::actual();
        return $this->belongsToMany(Disciplina::class)
                ->wherePivot('ano_lectivo_id',$anolectivo->id);
    }

    public function curso_disciplina(){
        return $this->hasMany(CursoDisciplina::class);
    }    

    public function turmas(){
        return $this->hasMany(Turma::class);
    }    

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'curso_id',
        'ano_lectivo_id',
        'periodo',
        'sala',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'sala' => 'string'
    ]; 

    public function curso(){
        return $this->belongsTo(Curso::class);
    }

    public function ano_lectivo(){
        return $this->belongsTo(AnoLectivo::class);
    }

    public function alunos(){
        return $this->hasMany(Aluno::class);
    }    

    public function professors(){
        return $this->belongsToMany(Professor::class);
    }    


}

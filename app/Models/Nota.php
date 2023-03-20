<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'prova_id',
        'aluno_id',
        'valor',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'        
    ];

    protected $casts = [
        'valor' => 'string',
    ];    

    public function aluno(){
        return $this->belongsTo(Aluno::class);
    }

    public function prova(){
        return $this->belongsTo(Prova::class);
    }

    public function turma_professor(){
        return $this->belongsTo(TurmaProfessor::class);
    }    

}

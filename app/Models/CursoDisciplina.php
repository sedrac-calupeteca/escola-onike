<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursoDisciplina extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'curso_id',
        'ano_lectivo_id',
        'disciplina_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'        
    ];

    protected $table = "curso_disciplina";

    public function disciplina(){
        $anolectivo = AnoLectivo::actual();
        return $this->belongsTo(Disciplina::class)->where('ano_lectivo_id', $anolectivo->id);
    }

    public function curso(){
        $anolectivo = AnoLectivo::actual();
        return $this->belongsTo(Curso::class)->where('ano_lectivo_id', $anolectivo->id);
    }    

}

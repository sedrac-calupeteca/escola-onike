<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnoLectivo extends Model
{
    use HasFactory, HasUuids; 

    protected $fillable = [
        'id',
        'codigo',
        'data_inicio',
        'data_fim',
        'descricao',
        'is_terminado',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'        
    ];

    public static function actual() : AnoLectivo{
        return AnoLectivo::where('data_inicio','<',CarboN::now())
                    ->orderBy('data_inicio','DESC')
                    ->first();
    }

    public static function selecionado() : AnoLectivo{
        return AnoLectivo::where('is_current','=',1)->first();
    }    

    public function turmas(){
        return $this->hasMany(Turma::class);
    }

    public function provas(){
        return $this->hasMany(Prova::class);
    }

    public function calendarios(){
        return $this->hasMany(Calendario::class);
    }    

}

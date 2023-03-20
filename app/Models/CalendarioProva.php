<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarioProva extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'calendario_id',
        'prova_id',
        'data',
        'hora_comeco',
        'hora_fim',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'        
    ];

    protected $table = "calendario_prova";

    public function calendario(){
        return $this->hasOne(Calendario::class);
    }

    public function prova(){
        return $this->hasOne(Prova::class,'id','prova_id');
    }    

}

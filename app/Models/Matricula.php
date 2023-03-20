<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'aluno_id',
        'ano_lectivo_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'        
    ];
    
}

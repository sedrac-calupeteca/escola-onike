<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reuniao extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'nome',
        'data_inicio',
        'data_fim',
        'descricao',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function professors(){
        return $this->belongsToMany(Professor::class);
    }

}

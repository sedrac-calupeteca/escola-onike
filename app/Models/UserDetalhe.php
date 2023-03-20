<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetalhe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'descricao',
        'contacto',
        'email_opt'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}

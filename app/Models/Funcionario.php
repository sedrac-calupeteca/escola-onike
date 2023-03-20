<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Funcionario extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'user_id',
        'funcao',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function newFuncionario($request, $user)
    {
        Funcionario::create([
            'user_id' => $user->id,
            'funcao' => $request->funcao,
            'created_by' => Auth::user()->id, 'updated_by' => Auth::user()->id
        ]);
    }

    public static function upFuncionario($request, $user)
    {
        $funcionario = Funcionario::where('user_id', $user->id)->first();
        if (isset($request->funcao)) {
            $funcionario->update([
                'user_id' => $user->id,
                'funcao' => $request->funcao,
                'updated_by' => Auth::user()->id
            ]);
        }
    }
}

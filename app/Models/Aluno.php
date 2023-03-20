<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Aluno extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'turma_id',
        'user_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'        
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function turma(){
        return $this->belongsTo(Turma::class);
    }    

    public function notas(){
        return $this->hasMany(Nota::class);
    }      

    public static function newAluno($request, $user){
        Aluno::create([
            'turma_id' => $request->turma_id,
            'user_id' => $user->id,
            'created_by' => Auth::user()->id, 'updated_by' => Auth::user()->id
        ]);
    }

    public static function upAluno($request, $user){
        $aluno = Aluno::where('user_id',$user->id)->first();
        $aluno->update([
            'turma_id' => $request->turma_id,
            'user_id' => $user->id,
            'updated_by' => Auth::user()->id
        ]);
    }    

}

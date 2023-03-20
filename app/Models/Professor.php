<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Professor extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'user_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function turmas()
    {
        return $this->belongsToMany(Turma::class);
    }

    public function reuniaos()
    {
        return $this->belongsToMany(Reuniao::class);
    }  

    public function professor_turma(){
        return $this->belongsTo(TurmaProfessor::class,'id','professor_id');
    }

    public static function newProfessorWithTurma($request, $user)
    {
        $professor = Professor::create([
            'user_id' => $user->id,
            'created_by' => Auth::user()->id, 'updated_by' => Auth::user()->id
        ]);
        $array[$request->turma_id] = [
            'disciplina_id' => $request->disciplina_id,
            'created_by' => Auth::user()->id, 'updated_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
        ];
        $professor->turmas()->attach($array);
    }

    public static function upProfessorWithTurma($request, $user)
    {
        $professor = Professor::where('user_id', $user->id)->first();
        
        $professor->update([
            'user_id' => $user->id,
            'updated_by' => Auth::user()->id
        ]);

        if (isset($request->turma_id) && isset($request->disciplina_id)) {
            $array[$request->turma_id] = [
                'disciplina_id' => $request->disciplina_id,
                'created_by' => Auth::user()->id, 'updated_by' => Auth::user()->id,
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ];
            $professor->turmas()->attach($array);
        }

    }
}

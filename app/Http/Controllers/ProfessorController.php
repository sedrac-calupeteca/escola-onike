<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Disciplina;
use App\Models\Professor;
use App\Models\ProfessorReuniao;
use App\Models\TurmaProfessor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\type;

class ProfessorController extends Controller
{
    public function list(Request $request)
    {
        if (!isset($request->search)) return response()->json(["professores" => []]);
        if (empty($request->search)) return response()->json(["professores" => []]);
        $professores =  User::join('professors', 'user_id', '=', 'users.id')
            ->join('professor_turma', 'professor_id', '=', 'professors.id')
            ->where('name', 'like', '%' . $request->search . '%')
            ->select('users.*')
            ->get();
        return response()->json(["professores" => $professores]);
    }

    public function list_by(Request $request)
    {
        if (!isset($request->search) || !isset($request->reuniao)) return response()->json(["professores" => []]);
        if (empty($request->search)) return response()->json(["professores" => []]);
        $professores =  User::join('professors', 'user_id', '=', 'users.id')
            ->join('professor_turma', 'professor_turma.professor_id', '=', 'professors.id')
            ->join('turmas', 'turma_id', '=', 'turmas.id')
            ->join('cursos', 'curso_id', '=', 'cursos.id')
            ->select(
                'users.name as professor',
                'professors.id',
                'cursos.nome as curso'
            )->get();
        $professores = $professores->map(function ($item) use ($request) {
            $convidado = ProfessorReuniao::where([
                'professor_id' => $item['id'], 'reuniao_id' => $request->reuniao
            ])->first();
            $item['convidado'] = isset($convidado->id);
            return $item;
        });
        return response()->json(["professores" => $professores]);
    }


    private function action_discplina_by($request, $professor, $disciplinas,$array = [])
    {
        if (isset($request->query) && isset($request->arg)) {
            $arg = $request->get('query');
            switch ($request->arg) {
                case "disciplina":
                    $disciplinas = $disciplinas->where("disciplinas.nome","like","%{$arg}%");
                break;
                case "curso":
                    $disciplinas = $disciplinas->join('turmas','turma_id','turmas.id')
                        ->join('cursos','curso_id','cursos.id')
                        ->where('cursos.nome','like',"%{$arg}%");
                break;
                case "nivel":
                    $disciplinas = $disciplinas->join('turmas','turma_id','turmas.id')
                                ->join('cursos','curso_id','cursos.id')
                                ->where('cursos.nivel','like',"%{$arg}%");                                
                break;   
                case "periodo":
                    $disciplinas = $disciplinas->join('turmas','turma_id','turmas.id')
                                ->where('turmas.periodo','like',"%{$arg}%");                               
                break;                             
            }
        }        

        $search = (object)[
            "fields" => [ 'disciplina' => 'Disciplina', 'curso' => 'Curso', 'nivel' => 'Nível', 'periodo' => 'Periodo' ]
        ];

        $data = [
            "auth" => Auth::user(),
            "disciplinas" => $disciplinas->paginate(),
            "professor" => $professor,
            "search" =>  $search      
        ];

        if (sizeof($array) > 0)
            return view('pages.leciona', array_merge($data, $array));

        return view('pages.leciona', $data);
    }

    public function leciona_disciplina(Request $request, $id)
    {

        $professor = Professor::with('user')->find($id);

        $disciplinas =  Disciplina::with('professor_turma.turma.curso')
        ->join('professor_turma', 'disciplina_id', 'disciplinas.id')
        ->where('professor_id', '=', $id)
        ->orderBy('professor_turma.created_at', 'DESC')
        ->select('disciplinas.*');

        $disciplinasProf = TurmaProfessor::where('professor_id',$id)->select('disciplina_id as id')->get();
        
        $disciplinasSelected = $disciplinasProf->map(function ($item) {
            return $item->id;
        })->unique()->all();

        return $this->action_discplina_by($request, $professor, $disciplinas,[
            "action_add_remove" => true,
            "disciplinasOfprofessor" => $disciplinasSelected
        ]);
    }

}

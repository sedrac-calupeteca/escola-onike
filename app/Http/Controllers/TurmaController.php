<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TurmaRequest;
use App\Models\Turma;
use App\Models\TurmaProfessor;
use App\Util\SearchField;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TurmaController extends Controller
{
    public function index(Request $request){
        $turmas = Turma::with('ano_lectivo','curso')->orderBy('turmas.created_at','DESC')->select('turmas.*');

        if(isset($request->query) && isset($request->arg)){
            $arg = $request->get('arg');
            $query = $request->get('query');
            if($arg == "curso"){
                $turmas = $turmas->join('cursos','cursos.id','curso_id')
                               ->where('cursos.nome','like','%'.$query.'%');
            }else if($arg == "periodo"){
                $turmas = $turmas->where('periodo','like','%'.$query.'%');
            }else if($arg == "anolectivo"){
                $turmas = $turmas->join('ano_lectivos','ano_lectivos.id','ano_lectivo_id')
                                 ->where('ano_lectivos.codigo','like','%'.$query.'%');
            }
        }

        return view('pages.turma',[
            'auth' => Auth::user(),
            'turmas' => $turmas->paginate(),
            'search' => SearchField::turma()
        ]);
    }

    public function store(TurmaRequest $request){
        try{
            $data = $request->all();
            $data['created_by'] = $data['updated_by'] = Auth::user()->id;
            $data['created_at'] = $data['updated_at'] = Carbon::now();
            Turma::create($data);
            toastr()->success("Operação de criação foi realizada com sucesso","Successo");
        }catch(Exception $e){
            dd("error: ".$e->getMessage());
            toastr()->error("Operação de criação não foi possível a sua realização","Erro");
        }
        return redirect()->back();
    }

    private function query($case, $operador,$anolectivo_id,$search){
        if($case == 1)
            return Turma::join('cursos','curso_id','=','cursos.id')
                    ->join('ano_lectivos','ano_lectivo_id','=','ano_lectivos.id')
                    ->where("cursos.nome","like","%".$search."%")
                    ->where("ano_lectivo_id",$operador, $anolectivo_id)
                    ->select(
                    'turmas.id','turmas.periodo','turmas.sala',
                    'cursos.nome','num_classe','nivel','codigo'
                    )->get();

        return TurmaProfessor::join('professors','professors.id','=','professor_id')
                      ->join('turmas','turmas.id','=','turma_id')
                      ->join('disciplinas','disciplinas.id','=','disciplina_id')
                      ->join('users','users.id','=','professors.user_id')
                      ->join('ano_lectivos','ano_lectivos.id','=','turmas.ano_lectivo_id')
                      ->join('cursos','cursos.id','=','turmas.curso_id')
                      ->where("ano_lectivos.id",$operador, $anolectivo_id)
                      ->where("cursos.nome","like","%".$search."%")
                      ->select(
                            'professor_turma.id','turmas.periodo','turmas.sala',
                            'cursos.nome','num_classe','nivel','codigo',
                            'users.name as professor','professor_id',
                            'disciplinas.nome as disciplina'
                       )->get();
    }

    public function list(Request $request){
        if(!isset($request->search) ) return response()->json(["turmas" => []]);
        if(empty($request->search)) return response()->json(["turmas" => []]);
        $anolectivo_id = isset($request->anolectivo) ? $request->anolectivo : "0" ;
        $operador = $anolectivo_id != "0" ? "=" : "<>";
        $code = isset($request->code) ? 2 : 1;
        $turmas = $this->query($code, $operador, $anolectivo_id, $request->search);
        return response()->json(["turmas" => $turmas]);
    }

    public function update(TurmaRequest $request,$id){
        try{
            $data = $request->all();
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = Carbon::now();
            $turma = Turma::find($id);
            $turma->update($data);
            toastr()->success("Operação de actualização foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de actualização não foi possível a sua realização","Erro");
        }
        return redirect()->back();
    }

    public function destroy($id){
        try{
            $turma = Turma::find($id);
            $turma->delete();
            toastr()->success("Operação de eliminação foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de eliminação não foi possível a sua realização","Erro");
        }
        return redirect()->back();
    }

}

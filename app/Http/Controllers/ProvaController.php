<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProvaRequest;
use App\Models\Aluno;
use App\Models\AnoLectivo;
use App\Models\Prova;
use App\Util\SearchField;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProvaController extends Controller
{

    private function simestreText($text){
        foreach(simestres() as $key => $value)
            if(str_contains(strtolower($value), strtolower($text))) return $key;
        return 0;
    }

    private function tipoText($text){
        foreach(tipoProvas() as $key => $value)
            if(str_contains(strtolower($value), strtolower($text))) return $key;
        return 0;
    }    

    public function index(Request $request)
    {
        $provas = Prova::with('professor_turma')->orderBy('provas.created_at','DESC')
                    ->select('provas.*');
        $anolectivos = AnoLectivo::orderBy('data_inicio', 'DESC')->limit(50)->get();

        if(isset($request->query) && isset($request->arg)){
            $arg = $request->get('arg');
            $query = $request->get('query');
            if($arg == "simestre"){
                $code = $this->simestreText($query);
                if( $code != 0) $provas = $provas->where('simestre',$code);
            }else if($arg == "tipo"){
                $code = $this->tipoText($query);
                if( $code != 0) $provas = $provas->where('tipo',$code);
            }else if($arg == "professor"){
                $provas = $provas->join('professor_turma','professor_turma.id','professor_turma_id')
                           ->join('professors','professors.id','professor_turma.professor_id')
                           ->join('users','users.id','professors.user_id')
                           ->where('users.name','like','%'.$query.'%')
                           ->select('provas.*');
            }else if($arg == "disciplina"){
                $provas = $provas->join('professor_turma','professor_turma.id','professor_turma_id')
                           ->join('disciplinas','disciplinas.id','professor_turma.disciplina_id')
                           ->where('disciplinas.nome','like','%'.$query.'%')
                           ->select('provas.*');
            }else if($arg == "curso"){
                $provas = $provas->join('professor_turma','professor_turma.id','professor_turma_id')
                           ->join('turmas','turmas.id','professor_turma.turma_id')
                           ->join('cursos','cursos.id','turmas.curso_id')
                           ->where('cursos.nome','like','%'.$query.'%')
                           ->select('provas.*');
            }
        }

        $data = [
            'auth' => Auth::user(),
            'provas' => $provas->paginate(),
            'anolectivos' => $anolectivos,
            'search' => SearchField::prova()
        ];

        $alunoView = $request->get('aluno-view');
        if($alunoView){
            $provas = $provas->join('alunos','alunos.turma_id','professor_turma.turma_id')
                             ->where('alunos.id',$alunoView);
            $data['aluno_view'] = $alunoView;
            $data['aluno'] = Aluno::find($alunoView);
        }

        return view('pages.prova', $data);
    }

    public function store(ProvaRequest $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = $data['updated_by'] = Auth::user()->id;
            $data['created_at'] = $data['updated_at'] = Carbon::now();
            Prova::create($data);
            toastr()->success("Operação de criação foi realizada com sucesso", "Successo");
        } catch (Exception) {
            toastr()->error("Operação de criação não foi possível a sua realização", "Erro");
        }
        return redirect()->back();
    }

    public function update(ProvaRequest $request, $id)
    {
        try {
            $data = $request->all();
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = Carbon::now();
            $prova = Prova::find($id); 
            $prova->update($data);
            toastr()->success("Operação de actualização foi realizada com sucesso", "Successo");
        } catch (Exception) {
            toastr()->error("Operação de actualização não foi possível a sua realização", "Erro");
        }
        return redirect()->back();
    }    

    public function destroy($id){
        try{
            $prova = Prova::find($id);
            $prova->delete();
            toastr()->success("Operação de eliminação foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de eliminação não foi possível a sua realização","Erro");
        }
        return redirect()->back(); 
    }     

    public function list(Request $request)
    {

        if (!isset($request->searchBy)) return response()->json(["provas" => []]);
        if (!isset($request->simestre)) return response()->json(["provas" => []]);
        if (!isset($request->tipo)) return response()->json(["provas" => []]);
        if (empty($request->search)) return response()->json(["provas" => []]);

        $provas = [];
        switch ($request->searchBy) {
            case "nome_prof":
                $provas = $this->defaultQuery($request)
                    ->where("users.name", "like", "%" . $request->search . "%")
                    ->get();
                break;
            case "nome_disc":
                $provas = $this->defaultQuery($request)
                    ->where("disciplinas.nome", "like", "%" . $request->search . "%")
                    ->get();
                break;
            case "nome_curs":
                $provas = $this->defaultQuery($request)
                    ->where("cursos.nome", "like", "%" . $request->search . "%")
                    ->get();
                break;
        }
        return response()->json(["provas" => $provas]);
    }


    private function defaultQuery($request)
    {
        return Prova::join('professor_turma', 'professor_turma.id', 'professor_turma_id')
            ->join('disciplinas', 'disciplinas.id', 'professor_turma.disciplina_id')
            ->join('professors', 'professors.id', 'professor_turma.professor_id')
            ->join('turmas', 'turmas.id', 'professor_turma.turma_id')
            ->join('cursos', 'cursos.id', 'turmas.curso_id')
            ->join('ano_lectivos','ano_lectivos.id','turmas.ano_lectivo_id')
            ->join('users', 'users.id', 'professors.user_id')
            ->where('simestre', $request->simestre)
            ->where('tipo', $request->tipo)
            ->where('provas.is_fechado',0)
            ->select(
                'provas.id',
                'users.name as professor',
                'disciplinas.nome as disciplina',
                'cursos.nome as curso',
                'ano_lectivos.codigo as anolectivo'
            );
    }
}

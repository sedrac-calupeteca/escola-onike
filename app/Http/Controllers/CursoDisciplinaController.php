<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivo;
use App\Models\Curso;
use App\Models\CursoDisciplina;
use App\Models\Disciplina;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CursoDisciplinaController extends Controller
{

    private $action = "view";
    private $anolectivos = null;
    private $type = "";

    private function type_query($params=true){
        switch($this->type){
            case "curso_by":
                return Curso::join('curso_disciplina', 'curso_id', '=', 'cursos.id')
                ->where('disciplina_id', $params)
                ->select('cursos.*')
                ->paginate();
            case "disciplina_by":
                return Disciplina::join('curso_disciplina', 'disciplina_id', '=', 'disciplinas.id')
                ->where('curso_id', $params)
                ->select('disciplinas.*')
                ->paginate();
            case "curso_add":
                return Curso::paginate();
            case "disciplina_add":
                return Disciplina::paginate();
        }
    }

    public function curso_by($id){
        try {
            $this->type = $this->type != "" ? $this->type : "curso_by";
            $disciplina = Disciplina::find($id);
            $cursos = $this->type_query($disciplina->id);
            return view('pages.curso', [
                'disciplina' => $disciplina, 
                'auth' => Auth::user(),  
                'cursos' => $cursos, 
                'action' => $this->action,
                'anolectivos' => $this->anolectivos,
            ]);
        } catch (Exception) {
            toastr()->error("Não é possível a exibição desta página","Erro");
            return redirect()->back();
        }
    }    

    public function curso_add($id){
        $this->action = "choose";
        $this->type = "curso_add";
        $this->anolectivos = AnoLectivo::orderBy('data_inicio','DESC')->limit(10)->get();
        return $this->curso_by($id);
    }    

    public function disciplina_by($id){
        try {
            $this->type = $this->type != "" ? $this->type : "disciplina_by";
            $curso = Curso::find($id);
            $disciplinas = $this->type_query($curso->id);
            return view('pages.disciplina', [
                'curso' => $curso, 
                'auth' => Auth::user(), 
                'disciplinas' => $disciplinas, 
                'action' => $this->action,
                'anolectivos' => $this->anolectivos,
            ]);
        } catch (Exception) {
            toastr()->error("Não é possível a exibição desta página","Erro");
            return redirect()->back();
        }
    }

    public function disciplina_add($id){
        $this->action = "choose";
        $this->type = "disciplina_add";
        $this->anolectivos = AnoLectivo::orderBy('data_inicio','DESC')->limit(10)->get();
        return $this->disciplina_by($id);
    }   

    private function lecionado($disciplina_id,$curso_id,$anolectivo_id,$auth){
        CursoDisciplina::updateOrCreate(
            [
                'disciplina_id' => $disciplina_id,
                'curso_id'=> $curso_id, 
                'ano_lectivo_id' => $anolectivo_id
            ],[
                'disciplina_id' => $disciplina_id,
                'curso_id'=> $curso_id, 
                'ano_lectivo_id' => $anolectivo_id,
                'created_by' => $auth,
                'updated_by' => $auth
            ]
        );
    }
    
    public function curso_store(Request $request, $id){
        try{
            $request->validate(['anolectivo' => ['required'], 'cursos' => ['required']]);
            $auth = Auth::user()->id;
            foreach($request->cursos as $curso_id)
                $this->lecionado($id,$curso_id,$request->anolectivo,$auth);
            toastr()->success("Os cursos foram adicionados esta disciplina","Successo");
        }catch(Exception){
            toastr()->error("Não é possível a exibição desta página","Erro");
        }
        return redirect()->back();
    }

    public function disciplina_store(Request $request, $id){
        try{
            $request->validate(['anolectivo' => ['required'], 'cursos' => ['required']]);
            $auth = Auth::user()->id;
            foreach($request->disciplinas as $disciplina_id)
                $this->lecionado($disciplina_id,$id,$request->anolectivo,$auth);
            toastr()->success("As disciplinas foram adicionados no curso","Successo");
        }catch(Exception){
            toastr()->error("Não é possível a exibição desta página","Erro");
        }
        return redirect()->back();
    }

}

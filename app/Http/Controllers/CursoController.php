<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CursoRequest;
use App\Models\Curso;
use App\Models\Turma;
use App\Util\SearchField;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CursoController extends Controller
{


    public function index(Request $request){
        $cursos = Curso::with('disciplinas','turmas')->orderBy('created_at','DESC');
        if(isset($request->query) && isset($request->arg)){
            $arg = $request->get('arg');
            $query = $request->get('query');
            if($arg == "classe"){
                $cursos = $cursos->where($arg ,$query);
            }else{
                $cursos = $cursos->where($arg ,'like', '%'.$query.'%');
            }
        }        
        return view('pages.curso',[
            'auth' => Auth::user(),
            'cursos' => $cursos->paginate(),
            'search' => SearchField::curso()
        ]);
    }

    public function store(CursoRequest $request){
        try{
            $data = $request->all(); 
            $data['created_by'] = $data['updated_by'] = Auth::user()->id;
            $data['created_at'] = $data['updated_at'] = Carbon::now();
            Curso::create($data);
            toastr()->success("Operação de criação foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de criação não foi possível a sua realização","Erro");
        }
        return redirect()->back();
    }

    public function update(CursoRequest $request, $id){
        try{
            $data = $request->all(); 
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = Carbon::now();
            $curso = Curso::find($id);
            $curso->update($data);
            toastr()->success("Operação de actualização foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de actualização não foi possível a sua realização","Erro");
        }
        return redirect()->back();        
    }    

    public function destroy($id){
        try{
            $curso = Curso::find($id);
            $curso->delete();
            toastr()->success("Operação de eliminação foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de eliminação não foi possível a sua realização","Erro");
        }
        return redirect()->back(); 
    }

    public function list(Request $request){
        if(!isset($request->search) ) return response()->json(["cursos" => []]);
        if(empty($request->search)) return response()->json(["cursos" => []]);
        
        $cursos = Curso::where("nome","like","%".$request->search."%")->get();
        return response()->json(["cursos" => $cursos]);
    }    

    public function turma_curso_by($id){
        $curso = Curso::find($id);
        $turmas = Turma::with('ano_lectivo', 'curso')->where('curso_id',$id)->paginate();
        return view('pages.turma', [
            'auth' => Auth::user(),
            'turmas' => $turmas,
            'curso' => $curso
        ]);
    }
    
}

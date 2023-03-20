<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisciplinaRequest;
use App\Models\Disciplina;
use App\Util\SearchField;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisciplinaController extends Controller
{
    public function index(Request $request){
        $disciplinas = Disciplina::with('cursos')->orderBy('created_at','DESC');

        if(isset($request->query) && isset($request->arg)){
            $disciplinas = $disciplinas->where($request->get('arg'),'like', '%'.$request->get('query').'%');
        }

        return view('pages.disciplina',[
            'auth' => Auth::user(),
            'disciplinas' => $disciplinas->paginate(),
            'search' => SearchField::disciplina()
        ]);
    }

    public function store(DisciplinaRequest $request){
        try{
            $data = $request->all(); 
            $data['created_by'] = $data['updated_by'] = Auth::user()->id;
            $data['created_at'] = $data['updated_at'] = Carbon::now();
            Disciplina::create($data);
            toastr()->success("Operação de criação foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de criação não foi possível a sua realização","Erro");
        }
        return redirect()->back();
    }

    public function update(DisciplinaRequest $request, $id){
        try{
            $data = $request->all();
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = Carbon::now();
            $disciplina = Disciplina::find($id);
            $disciplina->update($data);
            toastr()->success("Operação de actualização foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de actualização não foi possível a sua realização","Erro");
        }
        return redirect()->back();        
    }    

    public function destroy($id){
        try{
            $disciplina = Disciplina::find($id);
            $disciplina->delete();
            toastr()->success("Operação de eliminação foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de eliminação não foi possível a sua realização","Erro");
        }
        return redirect()->back(); 
    }

    public function list(Request $request){
        if(!isset($request->search) ) return response()->json(["disciplinas" => []]);
        if(empty($request->search)) return response()->json(["disciplinas" => []]);
        
        $disciplinas = Disciplina::where("nome","like","%".$request->search."%")->get();
        return response()->json(["disciplinas" => $disciplinas]);
    }

}

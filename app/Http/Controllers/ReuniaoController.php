<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReuniaoRequest;
use App\Models\Reuniao;
use App\Util\SearchField;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReuniaoController extends Controller
{
    public function index(Request $request){
        $reunioes = Reuniao::with('professors')->orderBy('created_at','DESC');

        if(isset($request->query) && isset($request->arg)){
            $reunioes = $reunioes->where($request->get('arg'),'like', '%'.$request->get('query').'%');
        }

        return view('pages.reuniao',[
            'auth' => Auth::user(),
            'reunioes' => $reunioes->paginate(),
            'search' => SearchField::reuniao()
        ]);
    }

    public function store(ReuniaoRequest $request){
        try{
            $data = $request->all(); 
            if(strtotime($data['data_fim']) < strtotime($data['data_inicio'])){
                toastr()->warning("A data de fim é menor que a data inicio, isto não é aceitavel","Aviso");
                return redirect()->back();
            } 
            $data['created_by'] = $data['updated_by'] = Auth::user()->id;
            $data['created_at'] = $data['updated_at'] = Carbon::now();
            Reuniao::create($data);
            toastr()->success("Operação de criação foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de criação não foi possível a sua realização","Erro");
        }
        return redirect()->back();
    }

    public function update(ReuniaoRequest $request, $id){
        try{
            $data = $request->all(); 
            if(strtotime($data['data_fim']) < strtotime($data['data_inicio'])){
                toastr()->warning("A data de fim é menor que a data inicio, isto não é aceitavel","Aviso");
                return redirect()->back();
            } 
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = Carbon::now();
            $reuniao = Reuniao::find($id);
            $reuniao->update($data);
            toastr()->success("Operação de actualização foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de actualização não foi possível a sua realização","Erro");
        }
        return redirect()->back();        
    }    

    public function destroy($id){
        try{
            $reuniao = Reuniao::find($id);
            $reuniao->delete();
            toastr()->success("Operação de eliminação foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de eliminação não foi possível a sua realização","Erro");
        }
        return redirect()->back(); 
    }
    
}

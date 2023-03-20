<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalendarioRequest;
use App\Models\AnoLectivo;
use App\Models\Calendario;
use App\Util\SearchField;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
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

    public function index(Request $request){
        $anolectivos = AnoLectivo::orderBy('created_at')->limit(50)->get();
        $calendarios = Calendario::with('ano_lectivo')->orderBy('created_at','DESC');
        if(isset($request->query) && isset($request->arg)){
            $arg = $request->get('arg');
            $query = $request->get('query');
            if($arg == "simestre"){
                $code = $this->simestreText($query);
                if( $code != 0) $calendarios = $calendarios->where('simestre',$code);
            }else if($arg == "tipo"){
                $code = $this->tipoText($query);
                if( $code != 0) $calendarios = $calendarios->where('tipo',$code);
            }else{
                $calendarios = $calendarios->where($arg ,'like', '%'.$query.'%');
            }
        }
        return view('pages.calendario', [
            'auth' => Auth::user(),
            'anolectivos' => $anolectivos,
            'calendarios' => $calendarios->paginate(),
            'search' => SearchField::calendario()
        ]);
    }

    private function dataFimMenorDataInicio($fim,$inicio) : bool{
        return strtotime($fim) < strtotime($inicio);
    }

    public function store(CalendarioRequest $request){
        try{

            if ($this->dataFimMenorDataInicio($request->data_fim,$request->data_inicio)) {
                toastr()->warning("O conflito no intervalo de data, a data de inicio é maior que a data de termino.", "Aviso");
                return redirect()->back();
            }    
            
            $calendario = Calendario::where([
                "ano_lectivo_id" => $request->ano_lectivo_id,
                "simestre" => $request->simestre,
                "tipo" => $request->tipo
            ])->first();

            if(isset($calendario->id)){
                toastr()->warning("O Calendário (".tipoProvas()[$calendario->tipo].") já esta criado neste simestre (".simestres()[$calendario->simestre].") referente ao ano lectivo","Aviso");
                return redirect()->back();
            }

            $data = $request->all(); 
            $data['created_by'] = $data['updated_by'] = Auth::user()->id;
            $data['created_at'] = $data['updated_at'] = Carbon::now();

            Calendario::create($data);
            toastr()->success("Operação de criação foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de criação não foi possível a sua realização","Erro");
        }
        return redirect()->back();
    }

    public function update(CalendarioRequest $request, $id){
        try{

            if ($this->dataFimMenorDataInicio($request->data_fim,$request->data_inicio)) {
                toastr()->warning("O conflito no intervalo de data, a data de inicio é maior que a data de termino.", "Aviso");
                return redirect()->back();
            } 

            $data = $request->all(); 
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = Carbon::now();
            $calendario = Calendario::find($id);
            $calendario->update($data);
            toastr()->success("Operação de actualização foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de actualização não foi possível a sua realização","Erro");
        }
        return redirect()->back();        
    }    

    public function destroy($id){
        try{
            $calendario = Calendario::find($id);
            $calendario->delete();
            toastr()->success("Operação de eliminação foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de eliminação não foi possível a sua realização","Erro");
        }
        return redirect()->back(); 
    }    

    public function list(){
        $anolectivos = AnoLectivo::orderBy('created_at')->limit(50)->get();
        $calendarios = Calendario::with('ano_lectivo')->orderBy('created_at','DESC')->paginate();
        return view('pages.calendario', [
            'auth' => Auth::user(),
            'anolectivos' => $anolectivos,
            'hidden_action' => true,
            'calendarios' => $calendarios
        ]);
    }    

}

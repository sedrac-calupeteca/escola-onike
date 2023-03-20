<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnoLectivoRequest;
use App\Models\AnoLectivo;
use App\Models\Turma;
use App\Util\SearchField;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Any;

class AnoLectivoController extends Controller
{
    public function index(Request $request)
    {
        $anolectivos = AnoLectivo::with('turmas')->orderBy('created_at','DESC');

        if(isset($request->query) && isset($request->arg)){
            $anolectivos = $anolectivos->where($request->get('arg'),'like', '%'.$request->get('query').'%');
        }

        return view('pages.anolectivo', [
            'auth' => Auth::user(),
            'anolectivos' => $anolectivos->paginate(),
            'search' => SearchField::anolectivo()
        ]);
    }

    private function dataFimMenorDataInicio($fim,$inicio) : bool{
        return strtotime($fim) < strtotime($inicio);
    }

    public function store(AnoLectivoRequest $request)
    {
        try {
            $data = $request->all();
            if ($this->dataFimMenorDataInicio($data['data_fim'],$data['data_inicio'])) {
                toastr()->warning("A data de fim é menor que a data inicio, isto não é aceitavel", "Aviso");
                return redirect()->back();
            }

            $anoLectivoLast = AnoLectivo::orderBy('data_fim','DESC')->first();

            if (isset($anoLectivoLast->id) && !$this->dataFimMenorDataInicio($anoLectivoLast->data_fim,$data['data_inicio'])) {
                $format_i = $data['data_inicio'] . ' - ' . $data['data_fim'];
                $format_c = $anoLectivoLast->data_fim . ' - ' . $anoLectivoLast->data_inicio . '['.$anoLectivoLast->codigo.']';
                toastr()->warning("O intervalo escollhido (".$format_i.") esta em conflito (".$format_c."),.", "Aviso");
                return redirect()->back();
            }

            $data['created_by'] = $data['updated_by'] = Auth::user()->id;
            $data['created_at'] = $data['updated_at'] = Carbon::now();
            AnoLectivo::create($data);
            toastr()->success("Operação de criação foi realizada com sucesso", "Successo");
        } catch (Exception) {
            toastr()->error("Operação de criação não foi possível a sua realização", "Erro");
        }
        return redirect()->back();
    }

    public function update(AnoLectivoRequest $request, $id)
    {
        try {
            $data = $request->all();
            if (strtotime($data['data_fim']) < strtotime($data['data_inicio'])) {
                toastr()->warning("A data de fim é menor que a data inicio, isto não é aceitavel", "Aviso");
                return redirect()->back();
            }
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = Carbon::now();
            $anoLectivo = AnoLectivo::find($id);
            $anoLectivo->update($data);
            toastr()->success("Operação de actualização foi realizada com sucesso", "Successo");
        } catch (Exception) {
            toastr()->error("Operação de actualização não foi possível a sua realização", "Erro");
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $anoLectivo = AnoLectivo::find($id);
            $anoLectivo->delete();
            toastr()->success("Operação de eliminação foi realizada com sucesso", "Successo");
        } catch (Exception) {
            toastr()->error("Operação de eliminação não foi possível a sua realização", "Erro");
        }
        return redirect()->back();
    }

    public function list(Request $request)
    {
        if (!isset($request->search)) return response()->json(["anolectivos" => []]);
        if (empty($request->search)) return response()->json(["anolectivos" => []]);

        $anolectivos = AnoLectivo::where("codigo", "like", "%" . $request->search . "%")->get();
        return response()->json(["anolectivos" => $anolectivos]);
    }

    public function turma_anolectivo_by(Request $request, $id)
    {
        $anoLectivo = AnoLectivo::find($id);
        $turmas = Turma::with('ano_lectivo', 'curso')->where('ano_lectivo_id',$id);
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
            }else if($arg == "nivel"){
                $turmas = $turmas->join('cursos','cursos.id','curso_id')
                                ->where('cursos.nivel','like','%'.$query.'%');
            }
        }           
        return view('pages.turma', [
            'auth' => Auth::user(),
            'turmas' => $turmas->paginate(),
            'anolectivo' => $anoLectivo,
            'search' => (object)[
                "fields" => [
                    'curso' => 'Curso',
                    'periodo' => 'Período',
                    'nivel' => 'Nível'
                ]
            ]
        ]);
    }
}

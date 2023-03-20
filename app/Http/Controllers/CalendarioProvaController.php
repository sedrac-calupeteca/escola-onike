<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalendarioProvaRequest;
use App\Models\AnoLectivo;
use App\Models\Calendario;
use App\Models\CalendarioProva;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarioProvaController extends Controller
{


    public function show(Request $request, $id)
    {  
        $calendario = Calendario::find($id);
        $calendarioProvas = CalendarioProva::with('prova')->where('calendario_id', $id);
        
        if(isset($request->query) && isset($request->arg)){
            $query = $request->get('query');
            switch($request->arg){
                case "professor":
                    $calendarioProvas = $calendarioProvas->join('provas','prova_id','provas.id')
                        ->join('professor_turma','professor_turma_id','professor_turma.id')
                        ->join('professors','professor_id','professors.id')
                        ->join('users','user_id','users.id')
                        ->where('users.name','like',"%{$query}%")
                        ->select('calendario_prova.*');
                break;
                case "disciplina":
                    $calendarioProvas = $calendarioProvas->join('provas','prova_id','provas.id')
                        ->join('professor_turma','professor_turma_id','professor_turma.id')
                        ->join('disciplinas','disciplina_id','disciplinas.id')
                        ->where('disciplinas.nome','like',"%{$query}%")
                        ->select('calendario_prova.*');
                break; 
                case "curso":
                    $calendarioProvas = $calendarioProvas->join('provas','prova_id','provas.id')
                        ->join('professor_turma','professor_turma_id','professor_turma.id')
                        ->join('turmas','turma_id','turmas.id')
                        ->join('cursos','curso_id','cursos.id')
                        ->where('cursos.nome','like',"%{$query}%")
                        ->select('calendario_prova.*');
                break;
                case "hora_comeco":
                case "hora_fim":
                case "data":
                    $calendarioProvas = $calendarioProvas
                        ->where($request->get('arg'),'like',"%{$query}%");
                break;                                               
            }

        }

        return view('pages.agendar', [
            'auth' => Auth::user(),
            'calendario' => $calendario,
            'calendarioProvas' => $calendarioProvas->paginate(),
            'search' => (object)[
                "fields" => [
                    'professor' => 'Professor',  
                    'disciplina' => 'Disciplina',
                    'curso' => 'Curso',
                    'hora_comeco' => 'Hora inicio',
                    'hora_fim' => 'Hora fim',
                    'data_marcacao' => 'Data marcação',
                ]
            ]
        ]);
    }

    public function store(CalendarioProvaRequest $request)
    {
        try {
            $data = $request->all();
            $calendario = Calendario::find($request->calendario_id);

            if ($this->dataFimMenorDataInicio($calendario->data_fim, $data['data'])) {
                $format = "(" . $calendario->data_inicio . "  à " . $calendario->data_fim . ")";
                toastr()->warning("A data de marcação ({$data['data']}) está fora do intervelo de realização das provas do calendarío {$format}, verifica a data de termino", "Aviso|Erro");
                return redirect()->back();
            }

            if ($this->dataFimMenorDataInicio($data['data'], $calendario->data_inicio)) {
                $format = "(" . $calendario->data_inicio . "  à " . $calendario->data_fim . ")";
                toastr()->warning("A data de marcação ({$data['data']}) está fora do intervelo de realização das provas do calendarío {$format}, verifica a date de início", "Aviso|Erro");
                return redirect()->back();
            }

            if ($this->dataFimMenorDataInicio($data['hora_fim'], $data['hora_comeco'])) {
                toastr()->warning("A hora de termino ({$data['hora_fim']}) não pode ser menor que a hora de começo ({$data['hora_comeco']})", "Aviso|Erro");
                return redirect()->back();
            }

            $calendarioLast = CalendarioProva::where('calendario_id', $request->calendario_id)
                ->orderBy('created_at', 'DESC')
                ->first();

            if (isset($calendarioLast->id)) {

                $case1 = !$this->dataFimMenorDataInicio($calendarioLast->hora_comeco, $data['hora_comeco']);
                $case2 = !$this->dataFimMenorDataInicio($calendarioLast->hora_fim, $data['hora_fim']);

                if ($case1 || $case2) {
                    toastr()->warning("Conflito, o horarío escolhido já faz parte de um intervalo", "Aviso|Erro");
                    return redirect()->back();
                }
            }

            $data['updated_by'] =  $data['created_by'] =  Auth::user()->id;
            $data['updated_at'] =  $data['created_at'] = Carbon::now();
            CalendarioProva::create($data);
            toastr()->success("Operação de criação foi realizada com sucesso", "Successo");
        } catch (Exception) {
            toastr()->error("Operação de criação não foi possível a sua realização", "Erro");
        }
        return redirect()->back();
    }

    public function update(CalendarioProvaRequest $request, $id)
    {
        try {
            $data = $request->all();
            $calendario = Calendario::find($request->calendario_id);

            if ($this->dataFimMenorDataInicio($calendario->data_fim, $data['data'])) {
                $format = "(" . $calendario->data_inicio . "  à " . $calendario->data_fim . ")";
                toastr()->warning("A data de marcação ({$data['data']}) está fora do intervelo de realização das provas do calendarío {$format}, verifica a data de termino", "Aviso|Erro");
                return redirect()->back();
            }

            if ($this->dataFimMenorDataInicio($data['data'], $calendario->data_inicio)) {
                $format = "(" . $calendario->data_inicio . "  à " . $calendario->data_fim . ")";
                toastr()->warning("A data de marcação ({$data['data']}) está fora do intervelo de realização das provas do calendarío {$format}, verifica a date de início", "Aviso|Erro");
                return redirect()->back();
            }

            if ($this->dataFimMenorDataInicio($data['hora_fim'], $data['hora_comeco'])) {
                toastr()->warning("A hora de termino ({$data['hora_fim']}) não pode ser menor que a hora de começo ({$data['hora_comeco']})", "Aviso|Erro");
                return redirect()->back();
            }

            $calendarioLast = CalendarioProva::where('calendario_id', $request->calendario_id)
                ->orderBy('created_at', 'DESC')
                ->first();

            $calendarioProva = CalendarioProva::find($id);
            if (isset($calendarioLast->id) && $calendarioProva->id != $calendarioLast->id) {
                $case1 = !$this->dataFimMenorDataInicio($calendarioLast->hora_comeco, $data['hora_comeco']);
                $case2 = !$this->dataFimMenorDataInicio($calendarioLast->hora_fim, $data['hora_fim']);
                if ($case1 || $case2) {
                    toastr()->warning("Conflito, o horarío escolhido já faz parte de um intervalo", "Aviso|Erro");
                    return redirect()->back();
                }
            }

            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = Carbon::now();
            $calendarioProva->update($data);
            toastr()->success("Operação de actualização foi realizada com sucesso", "Successo");
        } catch (Exception) {
            toastr()->error("Operação de actualização não foi possível a sua realização", "Erro");
        }
        return redirect()->back();
    }

    public function destroy($id){
        try{
            $calendario = CalendarioProva::find($id);
            $calendario->delete();
            toastr()->success("Operação de eliminação foi realizada com sucesso","Successo");
        }catch(Exception){
            toastr()->error("Operação de eliminação não foi possível a sua realização","Erro");
        }
        return redirect()->back(); 
    }  

    private function dataFimMenorDataInicio($fim, $inicio): bool
    {
        return strtotime($fim) < strtotime($inicio);
    }

    public function list($id)
    {
        $calendario = Calendario::find($id);
        $calendarioProvas = CalendarioProva::with('prova')
            ->where('calendario_id', $id)
            ->paginate();
        return view('pages.agendar', [
            'auth' => Auth::user(),
            'calendario' => $calendario,
            'hidden_action' => true,
            'calendarioProvas' => $calendarioProvas
        ]);
    }    

}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivo;
use App\Models\Matricula;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatriculaController extends Controller
{
    public function operaction($action, $aluno_id)
    {
        try {
            $anolectivo = AnoLectivo::actual();
            switch ($action) {
                case "create":
                    $auth = Auth::user()->id;
                    $carbon = Carbon::now();
                    Matricula::create([
                        'aluno_id' => $aluno_id,
                        'ano_lectivo_id' => $anolectivo->id,
                        'created_by' => $auth,
                        'updated_by' => $auth,
                        'created_at' => $carbon,
                        'updated_at' => $carbon,
                    ]);
                    break;
                case "remove":
                    $matricula = Matricula::where([
                        'aluno_id' => $aluno_id,
                        'ano_lectivo_id' => $anolectivo->id
                    ])->first();
                    $matricula->delete();
                    break;
                default:
                    toastr()->warning('Operação não encontrada', 'Aviso!');
                    return redirect()->back();
            }
            toastr()->success('Operação realizada com successo', 'Matricula');
            return redirect()->back();
        } catch (Exception) {
            toastr()->error('Erro na operação', 'Erro!');
            return redirect()->back();
        }
    }
}

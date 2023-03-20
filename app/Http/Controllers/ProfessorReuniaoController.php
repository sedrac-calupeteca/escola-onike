<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reuniao;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessorReuniaoController extends Controller
{
    public function store(Request $request)
    {
        try {
            $array = [];
            $reuniao = Reuniao::find($request->reuniao_id);
            foreach ($request->professor_id as $prof) {
                $array[$prof] = [
                    'created_by' => Auth::user()->id, 'updated_by' => Auth::user()->id,
                    'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
                ];
            }
            $reuniao->professors()->attach($array);
            toastr()->success("Operação de criação foi realizada com sucesso","Successo");
        } catch (Exception) {
            toastr()->error("Operação de criação não foi possível a sua realização","Erro");
        }
        return redirect()->back();
    }
}

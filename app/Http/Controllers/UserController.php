<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\AnoLectivo;
use App\Models\Funcionario;
use App\Models\Professor;
use App\Models\Reuniao;
use App\Models\Turma;
use App\Models\User;
use App\Util\SearchField;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller{
    private $parse_table = [
        'alunos' => 'alunos',
        'professores' => 'professors',
        'funcionarios' => 'funcionarios'
    ];

    private $parse_titulos = [
        'alunos' => 'Alunos',
        'professores' => 'Professores',
        'funcionarios' => 'Funcionários'
    ];

    private function usersType($user, $data)
    {
        $acho = $tam = sizeof($this->parse_table);
        foreach ($this->parse_table as $key => $value)
            if ($key == $user) $acho--;

        if ($acho == $tam) return null;

        $join = $this->parse_table[$user];
        if ($user == "alunos" || $user == "funcionarios") {
            $users = User::with('user_detalhe',$join)
                            ->join($join, 'user_id', '=', 'users.id')
                            ->orderBy('users.created_at','DESC')
                            ->select('users.*');
        }

        if ($users = "professores") {
            if (isset($data['turma'])) {
                $users = User::with('user_detalhe',$join)->join($join, 'user_id', '=', 'users.id')
                    ->join('professor_turma', 'professors.id', '=', 'professor_id')
                    ->where('turma_id', $data['turma'])
                    ->orderBy('users.created_at','DESC')
                    ->select('users.*');
            }else if(isset($data['reuniao'])) {
                $users = User::with('user_detalhe',$join)->join($join, 'user_id', '=', 'users.id')
                    ->join('professor_reuniao', 'professors.id', '=', 'professor_id')
                    ->where('reuniao_id', $data['reuniao'])
                    ->orderBy('users.created_at','DESC')
                    ->select('users.*');
            }else {
                $users = User::with('user_detalhe',$join)
                ->join($join, 'user_id', '=', 'users.id')
                ->orderBy('users.created_at','DESC')
                ->select('users.*');
            }
        }

        if(isset($data['query']) && isset($data['arg'])){
            return $users->where('users.'.$data['arg'],'like', '%'.$data['query'].'%')
                         ->orderBy('users.created_at','DESC')->paginate();
        }

        return  $users->paginate();
    }

    private function anolectivos($user)
    {
        switch ($user) {
            case "alunos":
            case "professores":
                return AnoLectivo::orderBy('data_inicio', 'DESC')->limit(50)->get();
            default:
                return null;
        }
    }

    public function index(Request $request, $user)
    {
        try {
            switch ($user) {
                case "alunos":
                case "funcionarios":
                case "professores":
                    $users = $this->usersType($user, $request->all());
                    $anolectivos = $this->anolectivos($user);
                    $datas = [
                        'auth' => Auth::user(),
                        'usuarios' => $users,
                        'userType' => $user,
                        'titleUser' => $this->parse_titulos[$user],
                        'anolectivos' => $anolectivos,
                    ];
                    if (isset($request->turma) && $user = "professores")
                        $datas['turma'] = Turma::find($request->turma);
                    if (isset($request->reuniao) && $user = "professores")
                        $datas['reuniao'] = Reuniao::find($request->reuniao);
                    
                    $datas['search'] = SearchField::user();
                    return view('pages.user', $datas);
                default:
                    toastr()->warning("Painel não encontrado","Aviso!");
                    return redirect()->back();
            }
        } catch (Exception) {
            toastr()->error("Erro ao encontrar o painel","Erro");
            return redirect()->back();
        }
    }

    public function store(Request $request, $userType)
    {
        try {
            $request->validate([]);
            $data = $request->all();
            $user = User::newUserWithDetailsRequired($data);
            switch ($userType) {
                case "alunos":
                    Aluno::newAluno($request, $user);
                    toastr()->success("Operação de criação[Aluno] foi realizada com sucesso", "Successo");
                    return redirect()->back();
                case "professores":
                    Professor::newProfessorWithTurma($request, $user);
                    toastr()->success("Operação de criação[Professor] foi realizada com sucesso", "Successo");
                    return redirect()->back();
                case "funcionarios":
                    Funcionario::newFuncionario($request, $user);
                    toastr()->success("Operação de criação[Funcionário] foi realizada com sucesso", "Successo");
                    return redirect()->back();
                default:
                    toastr()->warning("O painel não foi encontrado", "Aviso!");
                    return redirect()->back();
            }
        } catch (Exception) {
            return redirect()->back();
        }
    }

    public function update(Request $request, $userType){
        try {
            $request->validate([
                'user_id' => 'required',
                'turma_id' => 'required'
            ]);
            $user = User::find($request->user_id);
            $user->update($request->all());
            switch ($userType) {
                case "alunos":
                    Aluno::upAluno($request, $user);
                    toastr()->success("Operação de actualização[Aluno] foi realizada com sucesso", "Successo");
                    return redirect()->back();
                case "professores":
                    Professor::upProfessorWithTurma($request, $user);
                    toastr()->success("Operação de actualização[Professor] foi realizada com sucesso", "Successo");
                    return redirect()->back();
                case "funcionarios":
                    Funcionario::upFuncionario($request, $user);
                    toastr()->success("Operação de actualização[Funcionário] foi realizada com sucesso", "Successo");
                    return redirect()->back();
                default:
                    toastr()->warning("O painel não foi encontrado", "Aviso!");
                    return redirect()->back();
            }
        } catch (Exception) {
            return redirect()->back();
        }            
    }

    public function destroy(Request $request, $userType){

    }

    
}

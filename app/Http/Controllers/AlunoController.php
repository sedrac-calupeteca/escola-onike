<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlunoController extends Controller
{
    private function openAluno($user)
    {
        return redirect()->route('provas.index',['aluno-view' => $user->alunos->id]);
    }

    private function openProfessor($user)
    {
       
    }


    public function pauta(){
        $user = userPerfilAuth();
        $alunoCont = isset($user->alunos->id) ? 1  : 0;
        $profeCont = isset($user->professors->id) ? 1 : 0;
        $funcCont = isset($user->funcionarios->id) ? 1 : 0;
        $cont = $alunoCont + $profeCont + $funcCont;
        if($cont > 1){
            if ($user->perfil == "alunos") return $this->openAluno($user);
            if ($user->perfil == "professors")  return $this->openProfessor($user);
            toastr()->info("Escolha um perfil para ter accesso", "Informação");
            return redirect()->route('home');
        }else{
            if ($alunoCont) return $this->openAluno($user);
            if ($profeCont)  return $this->openProfessor($user);
        }
        toastr()->warning("Sem permissão de visualização", "Aviso");
        return redirect()->back();        
    }

}

<?php

use App\Models\Aluno;
use App\Models\AnoLectivo;
use App\Models\Curso;
use App\Models\Matricula;
use App\Models\Nota;
use App\Models\Prova;
use App\Models\TurmaProfessor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (! function_exists('funcao')) {
    function funcao(User $user) : string{
        return "Professor";
    }
}

if (! function_exists('funcaoAuth')) {
    function funcaoAuth() : string{

        return "Professor";
    }
}

if (! function_exists('genero')) {
    function genero(User $user) : string{
        switch($user->genero){
            case 'M': return 'MASCULINO';
            case 'F': return 'FEMENINO';
            return '';
        }
    }
}

if (! function_exists('abreviarNome')) {
    function abreviarNome(User $user) : string{
        $name = $user->name;
        $array = explode(" ",$name);
        $tam = sizeof($array);

        return $array[0][0].'.'.$array[$tam-1];
    }
}

if (! function_exists('cursoEstado')) {
    function cursoEstado(Curso $curso) : string{
        return $curso->is_fechado ? "aberto" : "fechado";
    }
}

if (! function_exists('anolectivo')) {
    function anolectivo(): AnoLectivo{
        return AnoLectivo::actual();
    }
}

if (! function_exists('join_rules')) {
    function join_rules(User $user): string{
        return $user->funcionarios->funcao;
    }
}

if (! function_exists('join_cursos')) {
    function join_cursos(User $user): string{
        return $user->professors->turmas->map(function($item){
            return $item->curso->nome;
        })->implode(',');
    }
}


if (! function_exists('join_turmas')) {
    function join_turmas(User $user): string{
        return "";
    }
}

if(! function_exists('simestres')){
    function simestres(): array{
        return [ '1' => 'Primeiro', '2' => 'Segundo', '3' => 'Terceiro'];
    }
}

if(! function_exists('tipoProvas')){
    function tipoProvas(): array{
        return [
            'EPOCA_1' => 'Primeiro época',
            'EPOCA_2' => 'Segundo época',
            'EPOCA_3' => 'Terceira época',
            'EXAME' => 'Exame',
            'RECURSO' => 'Recurso',
        ];
    }
}

if(! function_exists('cargos')){
    function cargos(): array{
        return [
            'DIRECTOR_GERAL' => 'Director Geral',
            'DIRECTOR_PEDAGOGICO' => 'Director Pedagógico',
            'DIRECTOR_ADMINISTRATIVO' => 'Director Administrativo',
            'TESOUREIRO' => 'Tesoureiro',
            'COORDENADOR_TURNO' => 'Coordenador de turno',
            'SECRETARIO' => 'Secretario',
            'AUXILIAR_LIMPEZA' => 'Auxiliar de limpeza',
            'PROTECAO_FISICA' => 'Proteção física',
        ];
    }
}

if(! function_exists('nota')){
    function nota(Prova $prova, Aluno $aluno){
        $nota = Nota::where('prova_id',$prova->id)
                    ->where('aluno_id',$aluno->id)
                    ->first();
        return $nota->valor ?? null;
    }
}

if (! function_exists('format_aluno_turma')) {
    function format_aluno_turma(User $user) : string{
        $curso = $user->alunos->turma->curso;
        return $user->alunos->turma->periodo.','.$curso->nome.','.$curso->nivel;
    }
}

if (! function_exists('exist_matricula')) {
    function exist_matricula($user) : bool{
        $anolective = AnoLectivo::actual();
        $matricula = Matricula::join('alunos','aluno_id','alunos.id')
                ->join('users','user_id','users.id')
                ->where('users.id',$user->id)
                ->where('matriculas.ano_lectivo_id',$anolective->id)
                ->first();
        return isset($matricula->id);
    }
}

if (! function_exists('leciona_discipiplina')) {
    function leciona_discipiplina($d, $p) : bool{
        $profTurma = TurmaProfessor::where('professor_id',$p)->where('disciplina_id',$d)->first();
        return isset($profTurma->id);
    }
}

if(! function_exists('existsPerfil')){
    function userPerfilAuth() : User{
        return User::with('alunos', 'professors','funcionarios')->find(Auth::user()->id);
    }
}

if(! function_exists('existsPerfil')){
    function existsPerfil($userPerfil = null) : bool{
        $user = $userPerfil ?? userPerfilAuth();
        $alunoCont = isset($user->alunos) ? 1  : 0;
        $profeCont = isset($user->professors) ? 1 : 0;
        $funcCont = isset($user->funcionarios) ? 1 : 0;
        $cont = $alunoCont + $profeCont + $funcCont;
        return $cont > 1;
    }
}

if(! function_exists('ruleNav')){
    function ruleNav($code) : bool{
        $userPerfil = userPerfilAuth();
        switch($code){
            case "usuario":
                $cargosPermit = ['SECRETARIO','DIRECTOR_GERAL'];
                if(!isset($userPerfil->funcionarios->id)) return false;
                if(existsPerfil($userPerfil))
                    return $userPerfil->perfil == "funcionarios" &&  in_array($userPerfil->funcionarios->funcao,$cargosPermit);
                else
                    return in_array($userPerfil->funcionarios->funcao,$cargosPermit);
            case "secretario":
                $cargosPermit = ['SECRETARIO'];
                return in_array($userPerfil->funcionarios->funcao,$cargosPermit);
                case "professor":
                    return isset($user->professors->id);
            default:
                return false;
        }
    }
}


if(! function_exists('permitDirectorGeralSecretario')){
    function permitDirectorGeralSecretario(){
        return ruleNav("usuario");
    }
}


if(! function_exists('permitSecretario')){
    function permitSecretario(){
        return ruleNav("secretario");
    }
}

if(! function_exists('permitProfessor')){
    function permitProfessor(){
        return ruleNav("professor");
    }
}

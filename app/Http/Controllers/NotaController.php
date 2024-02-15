<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\AnoLectivo;
use App\Models\Nota;
use App\Models\Prova;
use App\Models\Turma;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class NotaController extends Controller
{
    public function edit(Request $request, $prova_id)
    {
        $prova = Prova::with('professor_turma')->find($prova_id);
        $alunos = Aluno::with('user')->where('alunos.turma_id', $prova->professor_turma->turma_id);
        $data['auth'] = Auth::user();
        $data['prova'] = $prova;
        $data['alunos'] = $alunos->paginate();
        return view('pages.notas', $data);
    }

    public function store(Request $request)
    {
        try {
            $array = [];
            $data = $request->notas;
            $size = sizeof($data);
            $prova = Prova::find($request->prova_id);
            if ($prova->is_fechado) {
                toastr()->warning('O lançamento de notas sé encontra fechado.', 'Aviso');
                return redirect()->back();
            }
            $status = !isset($request->is_fechado) ? 0 : $request == 'on';
            $prova->update(['is_fechado' => $status]);
            for ($i = 0; $i < $size; $i++) {
                $row = explode('++', $data[$i]);
                $array[$i]['aluno_id'] = $row[0];
                $array[$i]['valor'] = $row[1];
                $array[$i]['prova_id'] = $prova->id;
                $array[$i]['created_by'] = $array[$i]['updated_by'] = Auth::user()->id;
                $array[$i]['created_at'] = $array[$i]['updated_at'] = Carbon::now();
            }
            foreach ($array as $nota) {
                Nota::updateOrCreate(['aluno_id' => $nota['aluno_id'], 'prova_id' => $nota['prova_id']], $nota);
            }
            toastr()->success('Operação de criação foi realizada com sucesso', 'Successo');
        } catch (Exception) {
            toastr()->error('Operação de criação não foi possível a sua realização', 'Erro');
        }
        return redirect()->back();
    }

    private function getNotaByTurma($turma, $notas)
    {
        $array = [];
        foreach ($notas as $nota) {
            if ($nota->prova->professor_turma->turma->id == $turma) {
                array_push($array, $nota);
            }
        }
        return $array;
    }

    private function openAluno($user)
    {
        $notas = $user->alunos->notas;
        $turmas = $notas
            ->map(function ($item) {
                return $item->prova->professor_turma->turma->id;
            })
            ->unique();
        $array = [];
        foreach ($turmas as $turma) {
            array_push(
                $array,
                (object) [
                    'turma' => Turma::with('ano_lectivo', 'curso')->find($turma),
                    'notas' => $this->getNotaByTurma($turma, $notas),
                ],
            );
        }
        return view('pages.visualizacao.notas.aluno', [
            'userType' => 'Aluno',
            'auth' => $user,
            'mapTurmaWithNotas' => $array,
        ]);
    }

    private function openProfessor($user)
    {
        $provas = Prova::with('professor_turma')
            ->join('professor_turma', 'professor_turma.id', '=', 'professor_turma_id')
            ->where('professor_id', $user->professors->id)
            ->select('provas.*')
            ->paginate();
        $anolectivos = AnoLectivo::orderBy('data_inicio', 'DESC')->limit(50)->get();
        return view('pages.prova', [
            'auth' => Auth::user(),
            'provas' => $provas,
            'anolectivos' => $anolectivos,
        ]);
    }

    public function index()
    {
        $user = userPerfilAuth();
        $alunoCont = isset($user->alunos->id) ? 1 : 0;
        $profeCont = isset($user->professors->id) ? 1 : 0;
        $funcCont = isset($user->funcionarios->id) ? 1 : 0;
        $cont = $alunoCont + $profeCont + $funcCont;
        if ($cont > 1) {
            if ($user->perfil == 'alunos') {
                return $this->openAluno($user);
            }
            if ($user->perfil == 'professors') {
                return $this->openProfessor($user);
            }
            toastr()->info('Escolha um perfil para ter accesso', 'Informação');
            return redirect()->route('home');
        } else {
            if ($alunoCont) {
                return $this->openAluno($user);
            }
            if ($profeCont) {
                return $this->openProfessor($user);
            }
        }
        toastr()->warning('Sem permissão de visualização', 'Aviso');
        return redirect()->back();
    }

    public function print($id)
    {
        $prova = Prova::with('professor_turma.turma.curso', 'professor_turma.disciplina')->find($id);
        $alunos = Aluno::with('user')->where('turma_id', $prova->professor_turma->turma->id)->get();
        $pdf = Pdf::loadView('doc.pdf.note', [
            'prova' => $prova,
            'alunos' => $alunos,
        ]);
        return $pdf->stream();
    }

    public static function getNote($simestre, $tipo, $disciplina, $aluno, $teacher)
    {
        return Nota::join('provas', 'notas.prova_id', 'provas.id')
            ->join('alunos', 'notas.aluno_id', 'alunos.id')
            ->join('professor_turma', 'provas.professor_turma_id', 'professor_turma.id')
            ->where([
                'simestre' => $simestre,
                'tipo' => $tipo,
                'disciplina_id' => $disciplina,
                'aluno_id' => $aluno,
                'professor_turma.professor_id' => $teacher
            ])
            ->first();
    }

    public static function media($notfound, $MAC, $NCPP, $NCPT)
    {
        $data = ['media' => 0, 'total' => 0];
        if ($MAC != $notfound) {
            $data['media'] += $MAC;
            $data['total'] += 1;
        }

        if ($NCPP != $notfound) {
            $data['media'] += $NCPP;
            $data['total'] += 1;
        }

        if ($NCPT != $notfound) {
            $data['media'] += $NCPT;
            $data['total'] += 1;
        }

        return [ "media" => round($data["media"] / 3) , "allprova" => $data['total'] == 3 ];

    }
}

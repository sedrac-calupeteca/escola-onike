<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    HomeController,
    NotaController,
    TurmaController,
    AlunoController,
    ProvaController,
    CursoController,
    ReuniaoController,
    ProfessorController,
    MatriculaController,
    CalendarioController,
    AnoLectivoController,
    DisciplinaController,
    UserDetalheController,
    CursoDisciplinaController,
    CalendarioProvaController,
    FuncionarioController,
    ProfessorReuniaoController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {

    Route::post('perfil-user-foto',[FuncionarioController::class,'foto'])->name('user.foto');
    Route::post('perfil-user',[FuncionarioController::class,'perfil'])->name('user.perfil');

    Route::get('pauta',[AlunoController::class,'pauta'])->name('pauta.index');


    Route::put('usuarios/{id}',[HomeController::class,'update'])->name('usuarios.update');
    Route::put('actualizar-senha/{id}',[HomeController::class,'password'])->name('senha.update');
    Route::put('usuario-detalhe/{id}',[UserDetalheController::class,'update'])->name('usuario-detalhe.update');

    Route::get('usuario/{user}',[UserController::class,'index'])->name('usuario.index');
    Route::post('usuario/{userType}',[UserController::class,'store'])->name('usuario.store');
    Route::put('usuario/{userType}',[UserController::class,'update'])->name('usuario.update');
    Route::delete('usuario/{userType}',[UserController::class,'destroy'])->name('usuario.destroy');

    Route::get('calendarios/list',[CalendarioController::class,'list'])->name('calendarios.list');
    Route::get('calendario-prova/list/{id}',[CalendarioProvaController::class,'list'])->name('calendario-prova.list');

    Route::resource('notas',NotaController::class);
    Route::resource('provas',ProvaController::class);
    Route::resource('turmas',TurmaController::class);
    Route::resource('cursos',CursoController::class);
    Route::resource('reunioes',ReuniaoController::class);
    Route::resource('disciplinas',DisciplinaController::class);
    Route::resource('calendarios',CalendarioController::class);
    Route::resource('ano-lectivos',AnoLectivoController::class);
    Route::resource('calendario-prova',CalendarioProvaController::class);

    Route::get('matricula/{action}/{aluno_id}',[MatriculaController::class,'operaction'])->name('matricula.action');

    Route::get('professor/{id}/disciplina',[ProfessorController::class,'leciona_disciplina'])->name('professor.disciplina.leciona');
    Route::get('professor/{prof_id}/disciplina/{disc_id}/{$action}',[ProfessorController::class,'disciplina_by_action'])->name('professor.disciplina.action');

    Route::get('disciplina/{id}/curso',[CursoDisciplinaController::class,'curso_by'])->name('disciplina.curso');
    Route::get('curso/{id}/disciplina',[CursoDisciplinaController::class,'disciplina_by'])->name('curso.disciplina');
    Route::get('anolectivo/{id}/turma',[AnoLectivoController::class,'turma_anolectivo_by'])->name('ano-lectivos.turmas');
    Route::get('curso/{id}/turma',[CursoController::class,'turma_curso_by'])->name('cursos.turmas');

    Route::get('add/disciplina/{id}/curso',[CursoDisciplinaController::class,'curso_add'])->name('disciplina.curso.add');
    Route::get('add/curso/{id}/disciplina',[CursoDisciplinaController::class,'disciplina_add'])->name('curso.disciplina.add');

    Route::post('disciplina/{id}/curso',[CursoDisciplinaController::class,'curso_store'])->name('disciplina.curso.store');
    Route::post('curso/{id}/disciplina',[CursoDisciplinaController::class,'disciplina_store'])->name('curso.disciplina.store');
    Route::post('reuniao/convidar/professores',[ProfessorReuniaoController::class,'store'])->name('professor.reuniao');

    Route::get('json/provas',[ProvaController::class,'list'])->name('provas.json');
    Route::get('json/cursos',[CursoController::class,'list'])->name('cursos.json');
    Route::get('json/turmas',[TurmaController::class,'list'])->name('turmas.json');
    Route::get('json/disciplinas',[DisciplinaController::class,'list'])->name('disciplina.json');
    Route::get('json/anolectivos',[AnoLectivoController::class,'list'])->name('anolectivos.json');
    Route::get('json/list/professors',[ProfessorController::class,'list_by'])->name('professors.list.json');


    Route::get('nota-print/{id}',[NotaController::class,'print'])->name('nota.print');

});

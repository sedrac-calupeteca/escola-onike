@extends('layouts.dash')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}" />
@endsection
@section('content')
    <div class="card">
        <div class="pagetitle m-2">
            <h1>Notas</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Perfil</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{  isset($aluno_view) ? url()->previous() : route('provas.index') }}">Provas</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="#">Notas</a>
                    </li>
                </ol>
            </nav>
        </div>
        <span id="formadd" class="d-none fr" data-url="{{ route('disciplinas.store') }}">
            <i class="bi bi-plus h2"></i>
        </span>
        <div class="card-body">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            <i class="bi bi-card-checklist"></i>
                            <span>Prova</span>
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample" style="">
                        <div class="row">
                            <div class="col-md-6 inline">
                                <label for="nome" class="form-label">
                                    <i class="bi bi-file-earmark-person-fill"></i>
                                    <span>Professor</span>
                                </label>
                                <input class="form-control"  disabled value="{{$prova->professor_turma->professor->user->name}}"/>
                            </div>
                            <div class="col-md-6 inline">
                                <label for="nome" class="form-label">
                                    <i class="bi bi-book"></i>
                                    <span>Disciplina</span>
                                </label>
                                <input class="form-control"  disabled value="{{$prova->professor_turma->disciplina->nome}}"/>
                            </div>                            
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 inline">
                                <label for="nome" class="form-label">
                                    <i class="bi bi-easel"></i>
                                    <span>Curso</span>
                                </label>
                                <input class="form-control"  disabled value="{{$prova->professor_turma->turma->curso->nome}}"/>
                            </div>
                            <div class="col-md-4 inline">
                                <label for="nome" class="form-label">
                                    <i class="bi bi-brightness-high"></i>
                                    <span>Periodo</span>
                                </label>
                                <input class="form-control"  disabled value="{{$prova->professor_turma->turma->periodo}}"/>
                            </div>    
                            <div class="col-md-4 inline">
                                <label for="nome" class="form-label">
                                    <i class="bi bi-1-circle"></i>
                                    <span>Classe</span>
                                </label>
                                <input class="form-control"  disabled value="{{$prova->professor_turma->turma->curso->num_classe}}"/>
                            </div>                                                    
                        </div>     
                    
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="true" aria-controls="flush-collapseTwo">
                            <i class="bi bi-list-check"></i>
                            <span>Lista</span>
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="flush-headingTwo"
                        data-bs-parent="#accordionFlushExample" style="">
                        @if(!isset($aluno_view)) <form action="{{ route('notas.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="prova_id" value="{{$prova->id}}"/>
                        @endif
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="is_fechado"
                                @if (!$prova->is_terminado) checked @else disabled  @endif>
                                <label class="form-check-label" for="flexSwitchCheckChecked">Aberto</label>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="th-icone">
                                                    <i class="bi bi-file-word"></i>
                                                    <span>Nome</span>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="th-icone">
                                                    <i class="bi bi-calendar-check"></i>
                                                    <span>Email</span>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="th-icone">
                                                    <i class="bi bi-calendar-x"></i>
                                                    <span>Gênero</span>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="th-icone">
                                                    <i class="bi bi-chat-left"></i>
                                                    <span>Data nascimento</span>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="th-icone">
                                                    <i class="bi bi-chat-left"></i>
                                                    <span>BI</span>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="th-icone">
                                                    <i class="bi bi-2-circle"></i>
                                                    <span>Nota</span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alunos as $aluno)
                                            <tr>
                                                <td>{{ $aluno->user->name }}</td>
                                                <td>{{ $aluno->user->email }}</td>
                                                <td>{{ genero($aluno->user) }}</td>
                                                <td>{{ $aluno->user->data_nascimento }}</td>
                                                <td>{{ $aluno->user->bilhete_identidade }}</td>
                                                <td>
                                                    @php $nota = nota($prova,$aluno); @endphp
                                                    @if(!isset($aluno_view))
                                                        <input class="form-control text-center" type="number" min="0" max="20" required data-aluno="{{ $aluno->id }}" onchange="join(event)" 
                                                        @if($nota != null) value="{{$nota}}" @endif>
                                                        <input type="hidden" name="notas[]" id="aluno_{{$aluno->id}}" 
                                                        @if($nota != null) value="{{$aluno->id.'++'.$nota}}" @endif/>                                                        
                                                    @else
                                                        {{$nota}}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(!isset($aluno_view))
                                <button class="btn btn-outline-primary rounded-pill">
                                    <i class="bi bi-send"></i>
                                    <span>Lançar</span>
                                </button>
                                
                                </form>
                            @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    @parent
    <script>
    
        function join(event) {
            let input = event.target;
            let alunoId = 'aluno_' +input.dataset.aluno;
            let aluno = document.querySelector("#"+alunoId);
            aluno.value = input.dataset.aluno + "++" + input.value;
        }

    </script>
@endsection

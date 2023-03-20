@extends('layouts.dash')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}" />
@endsection
@section('content')
    <div class="card">
        <div class="pagetitle m-2">
            <h1>Disciplinas</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Perfil</a></li>
                    @isset($curso)
                        <li class="breadcrumb-item">
                            <a href="{{ route('cursos.index') }}">Curso-Classe</a>
                        </li>
                    @endisset
                    <li class="breadcrumb-item active">
                        <a href="{{ route('disciplinas.index') }}">Disciplina</a>
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
                    <h2 class="accordion-header" id="flush-headingProfessor">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseProfessor" aria-expanded="false"
                            aria-controls="flush-collapseProfessor">
                            <i class="bi bi-person"></i>
                            <span>Professor</span>
                        </button>
                    </h2>
                    <div id="flush-collapseProfessor" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingProfessor" data-bs-parent="#accordionFlushExample" style="">
                        @include('components.form.user', [
                            'user' => $professor->user,
                            'inline' => true,
                            'require' => false,
                            'disabled' => true,
                            'hidden_password' => true,
                            'hidden_btn' => true
                        ])
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
                        @include('components.table.disciplina',[
                            'action_btn' => true
                        ])
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('components.modal.delete')
@endsection
@section('script')
    @parent
    <script>

    </script>
@endsection

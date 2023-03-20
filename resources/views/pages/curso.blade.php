@extends('layouts.dash')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}" />
@endsection
@section('content')
    <div class="card">
        <div class="pagetitle m-2">
            <h1>Cursos</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Perfil</a></li>
                    @isset($disciplina)
                        <li class="breadcrumb-item">
                            <a href="{{ route('disciplinas.index') }}">Disciplina</a>
                        </li>
                    @endisset
                    <li class="breadcrumb-item active">
                        <a href="{{ route('cursos.index') }}">Curso-Classe</a>
                    </li>
                </ol>
            </nav>
        </div>
        <span id="formadd" class="d-none fr" data-url="{{ route('cursos.store') }}">
            <i class="bi bi-plus h2"></i>
        </span>
        <div class="card-body">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @isset($disciplina)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingDisciplina">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseDisciplina" aria-expanded="false" aria-controls="flush-collapseDisciplina">
                                <i class="bi bi-easel"></i>
                                <span>Disciplina</span>
                            </button>
                        </h2>
                        <div id="flush-collapseDisciplina" class="accordion-collapse collapse" aria-labelledby="flush-headingDisciplina"
                            data-bs-parent="#accordionFlushExample" style="">
                            @include('components.form.disciplina', [
                                'disciplina' => $disciplina,
                                'inline' => true,
                                'require' => false,
                                'disabled' => true,
                            ])
                        </div>
                    </div>
                @endisset
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            <i class="bi bi-card-checklist"></i>
                            <span>Formulário</span>
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample" style="">
                        <form action="{{ route('cursos.store') }}" method="POST" id="form">
                            @csrf
                            @method('POST')
                            @include('components.form.curso')
                        </form>
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
                        @include('components.table.curso')
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
        const btnDels = document.querySelectorAll('.btn-del');
        const btnUps = document.querySelectorAll('.btn-up');

        const method = document.querySelector('[name="_method"]');
        const span = document.querySelector('#formadd');
        const form = document.querySelector('#form');

        function selectDefault(value, id) {
            let select = document.querySelector('#' + id);
            let children = select.childNodes;
            children.forEach(option => {
                if (option.value == value) {
                    option.selected = true;
                }
            });
        }

        function text(...arg) {
            document.querySelector('#nome').value = arg[0];
            selectDefault(arg[1], 'num_classe');
            selectDefault(arg[2], 'nivel');
            selectDefault(arg[3], 'is_fechado');
            document.querySelector('#descricao').innerHTML = arg[4];
            document.querySelector('#span-curso').innerHTML = arg[5];
        }

        span.addEventListener('click', function(e) {
            form.action = span.dataset.url;
            if (!span.classList.contains('d-none')) span.classList.add('d-none');
            text("", 7, 'SECUNDARIO', 1, "", "Cadastra");
            method.value = "POST";
        });

        btnUps.forEach(item => {
            item.addEventListener('click', function(e) {
                let row = item.parentNode.parentNode;
                let tds = row.querySelectorAll('td');
                form.action = item.dataset.up;
                if (span.classList.contains('d-none')) span.classList.remove('d-none');
                text(tds[0].innerHTML,
                    tds[1].dataset.value,
                    tds[2].dataset.value,
                    tds[3].dataset.value,
                    tds[4].innerHTML,
                    "Actualizar");
                method.value = "PUT";
            });
        });

        btnDels.forEach(item => {
            item.addEventListener('click', function(e) {
                let formDelete = document.querySelector('#formDelete');
                formDelete.action = item.dataset.del;
            });
        });
    </script>
@endsection

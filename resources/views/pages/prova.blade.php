@extends('layouts.dash')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}" />
@endsection
@section('content')
    <div class="card">
        <div class="pagetitle m-2">
            <h1>Provas</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Perfil</a></li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('provas.index') }}">Provas</a>
                    </li>
                </ol>
            </nav>
        </div>
        <span id="formadd" class="d-none fr" data-url="{{ route('provas.store') }}">
            <i class="bi bi-plus h2"></i>
        </span>
        <div class="card-body">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @if (!isset($aluno_view) && permitDirectorGeralSecretario())
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
                            <form action="{{ route('provas.store') }}" method="POST" id="form">
                                @csrf
                                @method('POST')
                                @include('components.form.prova')
                            </form>
                        </div>
                    </div>
                @endif
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
                        @include('components.table.prova')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.modal.delete')
@endsection
@section('script')
    @parent
    @if(!isset($aluno_view))
    <script>
        const searchTurma = document.querySelector("#search-turma");
        const panel = document.querySelector('#tab-turma-resp');

        const method = document.querySelector('[name="_method"]');
        const span = document.querySelector('#formadd');
        const form = document.querySelector('#form');

        const btnDels = document.querySelectorAll('.btn-del');
        const btnUps = document.querySelectorAll('.btn-up');

        function createTurmaTable(html) {
            return `<table class='table table-borderless  text-center'>
             <thead>
             <tr>
              <th> <div class="th-icone"> <i class="bi bi-check"></i> <span>#</span> </div> </th>
              <th> <div class="th-icone">  <i class="bi bi-person"></i> <span>Professor</span> </div> </th>
              <th> <div class="th-icone">  <i class="bi bi-book"></i> <span>Disciplina</span> </div> </th>
              <th> <div class="th-icone">  <i class="bi bi-brightness-high"></i> <span>Periodo</span> </div> </th>
              <th> <div class="th-icone"> <i class="bi bi-1-circle"></i> <span>Sala</span></div> </th>
              <th> <div class="th-icone"> <i class="bi bi-file-word"></i> <span>Curso/Turma</span> </div> </th>
              <th> <div class="th-icone"> <i class="bi bi-collection"></i> <span>Classe</span></div> </th>
              <th> <div class="th-icone"> <i class="bi bi-mortarboard"></i> <span>Nível</span> </div> </th>
              <th> <div class="th-icone"> <i class="bi bi-calendar-plus"></i> <span>Ano lectivo</span></div> </th>
            </tr>
          </thead>
          <tbody>${html}</tbody>
        </table>`;
        }

        function alerta() {
            return `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Nenhum registro foi encontrado.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
        }

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
            selectDefault(arg[0], 'simestre');
            selectDefault(arg[1], 'tipo');
            document.querySelector('#span-prova').innerHTML = arg[2];
        }

        span.addEventListener('click', function(e) {
            form.action = span.dataset.url;
            if (!span.classList.contains('d-none')) span.classList.add('d-none');
            text("", "", "Cadastra");
            method.value = "POST";
            panel.innerHTML = '';
        });

        btnUps.forEach(item => {
            item.addEventListener('click', function(e) {
                let row = item.parentNode.parentNode;
                let tds = row.querySelectorAll('td');
                form.action = item.dataset.up;
                if (span.classList.contains('d-none')) span.classList.remove('d-none');
                text(tds[0].dataset.simestre, tds[1].dataset.tipo, "Actualizar");
                method.value = "PUT";
                panel.innerHTML = createTurmaTable(`<tr>
                              <td>
                                <input class='form-check-input' type="radio" name="professor_turma_id" value="${tds[2].dataset.prov_turm}" checked/>
                              </td>
                              <td>${tds[2].innerHTML}</td>
                              <td>${tds[3].innerHTML}</td>
                              <td>${tds[5].innerHTML}</td>
                              <td>${tds[4].dataset.sala}</td>
                              <td>${tds[4].innerHTML}</td>
                              <td>${tds[6].innerHTML}</td>
                              <td>${tds[7].innerHTML}</td>
                              <td>${tds[8].innerHTML}</td>
                          </tr>`);
            });
        });

        btnDels.forEach(item => {
            item.addEventListener('click', function(e) {
                let formDelete = document.querySelector('#formDelete');
                formDelete.action = item.dataset.del;
            });
        });

        searchTurma.addEventListener('blur', function(e) {
            let anolectivo = document.querySelector('#choose-anolectivo');
            let url = '{{ route('turmas.json') }}?search=' + e.target.value + '&anolectivo=' + anolectivo.value +
                '&code=2';
            fetch(url)
                .then(resp => resp.json())
                .then(resp => {
                    let html = '';
                    let turmas = resp.turmas;
                    turmas.forEach(item => {
                        html += `<tr>
                              <td>
                                <input class='form-check-input' type="radio" name="professor_turma_id" value="${item.id}" />
                              </td>
                              <td>${item.professor}</td>
                              <td>${item.disciplina}</td>
                              <td>${item.periodo}</td>
                              <td>${item.sala}</td>
                              <td>${item.nome}</td>
                              <td>${item.num_classe}</td>
                              <td>${item.nivel}</td>
                              <td>${item.codigo}</td>
                          </tr>`;
                    });
                    panel.innerHTML = html == '' ? alerta() : createTurmaTable(html);
                })
        });
    </script>
    @endif
@endsection

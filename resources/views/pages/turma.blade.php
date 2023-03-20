@extends('layouts.dash')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}" />
@endsection
@section('content')
    <div class="card">
        <div class="pagetitle m-2">
            <h1>Turma</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Perfil</a></li>
                    @isset($anolectivo)
                        <li class="breadcrumb-item">
                            <a href="{{ route('ano-lectivos.index') }}">Anolectivo</a>
                        </li>
                    @endisset
                    @isset($curso)
                        <li class="breadcrumb-item">
                            <a href="{{ route('cursos.index') }}">Curso</a>
                        </li>
                    @endisset
                    <li class="breadcrumb-item active">
                        <a href="{{ route('turmas.index') }}">Turmas</a>
                    </li>
                </ol>
            </nav>
        </div>
        <span id="formadd" class="d-none fr" data-url="{{ route('turmas.store') }}">
            <i class="bi bi-plus h2"></i>
        </span>
        <div class="card-body">
            <div class="accordion accordion-flush" id="accordionFlushExample">
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
                        <form action="{{ route('turmas.store') }}" method="POST" id="form">
                            @csrf
                            @method('POST')
                            @include('components.form.turma')
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
                        @include('components.table.turma')
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

        const panelAnolectivo = document.querySelector('#tab-anolectivo-resp');
        const panelCurso = document.querySelector('#tab-curso-resp');

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
            selectDefault(arg[0], 'periodo');
            document.querySelector('#sala').value = arg[1];
            document.querySelector('#span-turma').innerHTML = arg[2];
        }

        span.addEventListener('click', function(e) {
            form.action = span.dataset.url;
            if (!span.classList.contains('d-none')) span.classList.add('d-none');
            text("", "", "Cadastra");
            method.value = "POST";
            panelAnolectivo.innerHTML = panelCurso.innerHTML = '';
        });

        btnUps.forEach(item => {
            item.addEventListener('click', function(e) {
                let row = item.parentNode.parentNode;
                let tds = row.querySelectorAll('td');
                form.action = item.dataset.up;
                if (span.classList.contains('d-none')) span.classList.remove('d-none');
                text(tds[2].innerHTML, tds[3].innerHTML, "Actualizar");
                panelAnolectivo.innerHTML = createAnolectivoTable(`<tr>
                  <td>
                    <input class='form-check-input' type="radio" name="ano_lectivo_id" value="${tds[0].dataset.ano}" checked/>
                  </td>
                  <td>${tds[0].innerHTML}</td>
                  <td>${tds[0].dataset.inicio}</td>
                  <td>${tds[0].dataset.fim}</td>
                </tr>`);
                panelCurso.innerHTML = createCursoTable(`<tr>
                   <td>
                      <input class='form-check-input' type="radio" name="curso_id" value="${tds[1].dataset.curso}" checked/>
                    </td>
                    <td>${tds[1].innerHTML}</td>
                    <td>${tds[4].innerHTML}</td>
                    <td>${tds[5].innerHTML}</td>
                </tr>`);
                method.value = "PUT";
            });
        });

        btnDels.forEach(item => {
            item.addEventListener('click', function(e) {
                let formDelete = document.querySelector('#formDelete');
                formDelete.action = item.dataset.del;
            });
        });

        function alerta() {
            return `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Nenhum registro foi encontrado.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
        }

    </script>

    @if (!isset($anolectivo))
        <script>
            const searchAnolectivo = document.querySelector("#search-anolectivo");

            function createAnolectivoTable(html) {
                return `
              <table class='table table-borderless  text-center'>
                <thead>
                   <tr>
                    <th> <div class="th-icone"> <i class="bi bi-check"></i> <span>#</span> </div> </th>                        
                    <th> <div class="th-icone"> <i class="bi bi-file-word"></i> <span>Código</span> </div> </th>
                    <th> <div class="th-icone"> <i class="bi bi-calendar-check"></i> <span>Data inicio</span> </div> </th>
                    <th> <div class="th-icone"> <i class="bi bi-calendar-x"></i> <span>Data fim</span> </div> </th>
                  </tr>
                </thead>  
                <tbody>${html}</tbody>
              </table>`;
            }

            searchAnolectivo.addEventListener('blur', (e) => {
                let url = '{{ route('anolectivos.json') }}?search=' + e.target.value;
                fetch(url)
                    .then(resp => resp.json())
                    .then(resp => {
                        let html = '';
                        let anolectivos = resp.anolectivos;
                        anolectivos.forEach(item => {
                            html += `<tr>
                                        <td>
                                            <input class='form-check-input' type="radio" name="ano_lectivo_id" value="${item.id}"/>
                                        </td>
                                        <td>${item.codigo}</td>
                                        <td>${item.data_inicio}</td>
                                        <td>${item.data_fim}</td>
                                    </tr>`;
                        });
                        panelAnolectivo.innerHTML = html == '' ? alerta() : createAnolectivoTable(html);
                    })
            });
        </script>
    @endif

    @if (!isset($curso))
        <script>
            const searchCursos = document.querySelector("#search-curso");

            function createCursoTable(html) {
                return `<table class='table table-borderless  text-center'>
                    <thead>
                       <tr>
                        <th>
                          <div class="th-icone"> <i class="bi bi-check"></i> <span>#</span> </div>
                        </th>                        
                        <th>
                          <div class="th-icone"> <i class="bi bi-file-word"></i> <span>Nome</span> </div>
                        </th>
                        <th>
                          <div class="th-icone"><i class="bi bi-collection"></i><span>Classe</span></div>
                        </th>
                        <th>
                          <div class="th-icone"><i class="bi bi-mortarboard"></i><span>Nível</span> </div>
                        </th>
                      </tr>
                    </thead>  
                    <tbody>${html}</tbody>
                  </table>`;
            }

            searchCursos.addEventListener('blur', (e) => {
                let url = '{{ route('cursos.json') }}?search=' + e.target.value;
                fetch(url)
                    .then(resp => resp.json())
                    .then(resp => {
                        let html = '';
                        let cursos = resp.cursos;
                        cursos.forEach(item => {
                            html += `<tr>
                                        <td>
                                            <input class='form-check-input' type="radio" name="curso_id" value="${item.id}"/>
                                        </td>
                                        <td>${item.nome}</td>
                                        <td>${item.num_classe}</td>
                                        <td>${item.nivel}</td>
                                    </tr>`;
                        });
                        panelCurso.innerHTML = html == '' ? alerta() : createCursoTable(html);
                    });
            });
        </script>
    @endif
@endsection

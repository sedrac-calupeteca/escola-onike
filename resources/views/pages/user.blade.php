@extends('layouts.dash')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}" />
@endsection
@section('content')
    <div class="card">
        <div class="pagetitle m-2">
            <h1>{{ $titleUser }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Perfil</a></li>
                    @isset($turma)
                        <li class="breadcrumb-item">
                            <a href="{{ route('turmas.index') }}">Turma</a>
                        </li>
                    @endisset
                    @isset($reuniao)
                        <li class="breadcrumb-item">
                            <a href="{{ route('reunioes.index') }}">Reunião</a>
                        </li>
                    @endisset
                    <li class="breadcrumb-item active">
                        <a href="{{ route('usuario.index', $userType) }}">
                            {{ $titleUser }}
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
        <span id="formadd" class="d-none fr" data-url="{{ route('reunioes.store') }}">
            <i class="bi bi-plus h2"></i>
        </span>
        <div class="card-body">
            @php $viewTurmas = $userType == 'alunos' || $userType == 'professores'; @endphp
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @isset($reuniao)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingReuniao">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseReuniao" aria-expanded="false"
                                aria-controls="flush-collapseReuniao">
                                <i class="bi bi-person-lines-fill"></i>
                                <span>Reunião</span>
                            </button>
                        </h2>
                        <div id="flush-collapseReuniao" class="accordion-collapse collapse" aria-labelledby="flush-headingReuniao" data-bs-parent="#accordionFlushExample">
                            @include('components.form.reuniao', [
                                'reuniao' => $reuniao,
                                'inline' => true,
                                'require' => false,
                                'disabled' => true,
                            ])
                        </div>
                    </div>
                @endisset
                @if (!isset($reuniao))
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
                            <form action="{{ route('usuario.store', $userType) }}" method="POST" id="form">
                                @csrf
                                @method('POST')
                                @include('components.form.user', [
                                    'user_type' => $userType,
                                    'detalhe_required' => true,
                                ])
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
                        @include('components.table.user')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.modal.delete')
@endsection
@section('script')
    @parent
    @if (!isset($reuniao))
        <script>
            const btnDels = document.querySelectorAll('.btn-del');
            const btnUps = document.querySelectorAll('.btn-up');

            const method = document.querySelector('[name="_method"]');
            const span = document.querySelector('#formadd');
            const form = document.querySelector('#form');

            const panelTurma = document.querySelector('#tab-turma-resp');
            const panelDisciplina = document.querySelector('#tab-disciplina-resp');

            const uerType = document.querySelector("#user_type");

            function hiddenComponentPassword(action) {
                const divPass = document.querySelectorAll('.item-password');
                if (divPass) {
                    switch (action) {
                        case "up":
                            divPass.forEach(item => {
                                if (!item.classList.contains('d-none'))
                                    item.classList.add('d-none');
                                item.querySelectorAll('input').forEach(input => {
                                    if (!input.hasAttribute('disabled'))
                                        input.setAttribute('disabled', '');
                                })
                            });
                            break
                        case "add":
                            divPass.forEach(item => {
                                if (item.classList.contains('d-none'))
                                    item.classList.remove('d-none');
                                item.querySelectorAll('input').forEach(input => {
                                    if (input.hasAttribute('disabled'))
                                        input.removeAttribute('disabled');
                                })
                            });
                            break
                    }
                }
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
                document.querySelector('#nome').value = arg[0];
                document.querySelector('#email').value = arg[1];
                selectDefault(arg[2], 'genero');
                document.querySelector('#data_nascimento').value = arg[3];
                document.querySelector('#bilhete_identidade').value = arg[4];
                document.querySelector('#contacto').value = arg[5];
                document.querySelector('#email_opt').value = arg[6];
                document.querySelector('#span-user').innerHTML = arg[7];
            }

            span.addEventListener('click', function(e) {
                hiddenComponentPassword("add");
                form.action = span.dataset.url;
                if (!span.classList.contains('d-none')) span.classList.add('d-none');
                if (userType.value == "alunos") {
                    text("", "", "", "", "", "", "", "Cadastra");
                }
                method.value = "POST";
                panelTurma.innerHTML = '';
            });

            btnUps.forEach(item => {
                item.addEventListener('click', function(e) {
                    hiddenComponentPassword("up");
                    let row = item.parentNode.parentNode;
                    let tds = row.querySelectorAll('td');
                    let userInput = document.querySelector('#user_id');
                    form.action = item.dataset.up;
                    if (span.classList.contains('d-none')) span.classList.remove('d-none');
                    text(
                        tds[0].innerHTML, tds[1].innerHTML, tds[2].dataset.genero,
                        tds[3].innerHTML, tds[4].innerHTML, tds[5].innerHTML,
                        tds[6].innerHTML, "Actualizar"
                    );
                    method.value = "PUT";
                    console.log(userType);
                    if (userType.value == "alunos") {
                        userInput.value = tds[0].dataset.user;
                        panelTurma.innerHTML = createTableTurmaHtml(`<tr>
                                        <td>
                                            <input class='form-check-input' type="radio" name="turma_id" value="${tds[7].dataset.turma}" checked/>
                                        </td>
                                        <td>${tds[7].dataset.periodo}</td>
                                        <td>${tds[7].dataset.sala}</td>                      
                                        <td>${tds[8].innerHTML}</td>
                                        <td>${tds[9].innerHTML}</td>
                                        <td>${tds[10].innerHTML}</td>
                                        <td>${tds[11].innerHTML}</td>
                                    </tr>`);
                    }else if (userType.value == "professores") {
                        panelTurma.innerHTML = createTableTurmaHtml(`<tr>
                                        <td>
                                            <input class='form-check-input' type="radio" name="turma_id" value="${tds[7].dataset.turma}" checked/>
                                        </td>
                                        <td>${tds[7].dataset.periodo}</td>
                                        <td>${tds[7].dataset.sala}</td>                      
                                        <td>${tds[8].innerHTML}</td>
                                        <td>${tds[9].innerHTML}</td>
                                        <td>${tds[10].innerHTML}</td>
                                        <td>${tds[11].innerHTML}</td>
                                    </tr>`);
                    }else if(userType.value == "funcionarios"){
                        selectDefault(tds[7].dataset.value, 'funcao');
                    }

                });
            });

            btnDels.forEach(item => {
                item.addEventListener('click', function(e) {
                    let formDelete = document.querySelector('#formDelete');
                    formDelete.action = item.dataset.del;
                });
            });
        </script>
        @if ($viewTurmas)
            @if (!isset($turma))
                <script>
                    const searchTurma = document.querySelector("#search-turma");

                    function createTableTurmaHtml(html) {
                        return `<table class='table table-borderless  text-center'>
                    <thead>
                       <tr>                        
                        <th>
                          <div class="th-icone"> <i class="bi bi-check"></i> <span>#</span> </div>
                        </th>
                        <th>
                          <div class="th-icone">  <i class="bi bi-brightness-high"></i> <span>Periodo</span> </div>
                        </th>
                        <th>
                          <div class="th-icone"> <i class="bi bi-1-circle"></i> <span>Sala</span></div>
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
                        <th>
                          <div class="th-icone"><i class="bi bi-calendar-plus"></i><span>Ano lectivo</span></div>
                        </th>                        
                      </tr>
                    </thead>  
                    <tbody>
                        ${html}
                    </tbody>
                  </table>`;
                    }

                    searchTurma.addEventListener('blur', (e) => {
                        let anolectivo = document.querySelector('#choose-anolectivo');
                        let url = `{{ route('turmas.json') }}?search=${e.target.value}&anolectivo=${anolectivo.value}`;
                        fetch(url)
                            .then(resp => resp.json())
                            .then(resp => {
                                let html = '';
                                let turmas = resp.turmas;
                                let userType = document.querySelector('#userType').value;
                                turmas.forEach(item => {
                                    html += `<tr>
                                        <td>
                                            <input class='form-check-input' type="radio" name="turma_id" value="${item.id}"/>
                                        </td>
                                         <td>${item.periodo}</td>
                                        <td>${item.sala}</td>                      
                                        <td>${item.nome}</td>
                                        <td>${item.num_classe}</td>
                                        <td>${item.nivel}</td>
                                        <td>${item.codigo}</td>
                                    </tr>`;
                                });
                                panelTurma.innerHTML = html == '' ? alerta() : createTableTurmaHtml(html);
                            })
                    });
                </script>
            @endif
        @endif

        @if ($userType == 'professores')
            <script>
                const searchDisciplina = document.querySelector("#search-disciplina");

                function createTableDisciplina(html) {
                    return `
                  <table class='table table-borderless  text-center'>
                    <thead>
                       <tr>
                        <th> <div class="th-icone"> <i class="bi bi-check"></i> <span>#</span> </div> </th>                        
                        <th> <div class="th-icone"> <i class="bi bi-file-word"></i> <span>Nome</span> </div> </th>
                      </tr>
                    </thead>  
                    <tbody>${html}</tbody>
                  </table>`;
                }

                searchDisciplina.addEventListener('blur', (e) => {
                    let url = '{{ route('disciplina.json') }}?search=' + e.target.value;
                    fetch(url)
                        .then(resp => resp.json())
                        .then(resp => {
                            let html = '';
                            let disciplinas = resp.disciplinas;
                            disciplinas.forEach(item => {
                                html += `<tr>
                            <td>
                                <input class='form-check-input' type="radio" name="disciplina_id" value="${item.id}"/>
                            </td>
                            <td>${item.nome}</td>
                            </tr>`;
                            });
                            panelDisciplina.innerHTML = html == '' ? alerta() : createTableDisciplina(html);
                        });
                });
            </script>
        @endif
    @endif
@endsection

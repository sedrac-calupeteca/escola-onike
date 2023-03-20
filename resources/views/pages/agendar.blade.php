@extends('layouts.dash')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}" />
@endsection
@section('content')
    <div class="card">
        <div class="pagetitle m-2">
            <h1>Calendário</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Agendamento</a></li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('calendarios.index') }}">Provas</a>
                    </li>
                </ol>
            </nav>
        </div>
        <span id="formadd" class="d-none fr" data-url="{{ route('calendario-prova.store') }}">
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
                        <form action="{{ route('calendario-prova.store') }}" method="POST" id="form">
                            @csrf
                            @method('POST')
                            @include('components.form.agendar')
                            <input type="hidden" name="calendario_id" value="{{ $calendario->id }}" />
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
                        @include('components.table.agendar')
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
        const searchBy = document.querySelector('#searchBy');
        const searchProva = document.querySelector("#search-prova");

        const btnDels = document.querySelectorAll('.btn-del');
        const btnUps = document.querySelectorAll('.btn-up');

        const method = document.querySelector('[name="_method"]');
        const span = document.querySelector('#formadd');
        const form = document.querySelector('#form');

        const panel = document.querySelector('#tab-prova-resp');

        function createTableProvaHtml(html) {
            return `<table class='table table-borderless  text-center'>
             <thead>
             <tr>                        
              <th> <div class="th-icone"> <i class="bi bi-check"></i> <span>#</span> </div> </th>
              <th> <div class="th-icone">  <i class="bi bi-person"></i> <span>Professor</span> </div> </th>   
              <th> <div class="th-icone">  <i class="bi bi-book"></i> <span>Disciplina</span> </div> </th>                         
              <th> <div class="th-icone">  <i class="bi bi-easel"></i> <span>Curso</span> </div> </th>   
              <th> <div class="th-icone">  <i class="bi bi-calendar"></i> <span>Ano Lectivo</span> </div> </th>                     
            </tr>
          </thead>  
          <tbody>${html}</tbody>
        </table>`;
        }

        function text(...arg) {
            document.querySelector('#data').value = arg[0];
            document.querySelector('#hora_comeco').value = arg[1];
            document.querySelector('#hora_fim').value = arg[2];
            document.querySelector('#span-calendario-prova').innerHTML = arg[3];
        }

        span.addEventListener('click', function(e) {
            form.action = span.dataset.url;
            if (!span.classList.contains('d-none')) span.classList.add('d-none');
            text("", "", "", "Cadastra");
            method.value = "POST";
            panel.innerHTML = "";
        });

        btnUps.forEach(item => {
            item.addEventListener('click', function(e) {
                let row = item.parentNode.parentNode;
                let tds = row.querySelectorAll('td');
                form.action = item.dataset.up;
                if (span.classList.contains('d-none')) span.classList.remove('d-none');
                text(tds[4].innerHTML, tds[5].innerHTML, tds[6].innerHTML, "Actualizar");
                method.value = "PUT";

                panel.innerHTML = createTableProvaHtml(`<tr>
                              <td>
                                <input class='form-check-input' type="radio" name="prova_id" value="${tds[0].dataset.value}" checked/>
                              </td>
                              <td>${tds[0].innerHTML}</td>
                              <td>${tds[1].innerHTML}</td>
                              <td>${tds[2].innerHTML}</td>
                              <td>${tds[3].innerHTML}</td>    
                          </tr>`);
            });
        });

        btnDels.forEach(item => {
            item.addEventListener('click', function(e) {
                let formDelete = document.querySelector('#formDelete');
                formDelete.action = item.dataset.del;
            });
        });

        searchProva.addEventListener('blur', function(e) {
            let url = '{{ route('provas.json') }}?search=' + e.target.value +
                '&simestre={{ $calendario->simestre }}&tipo={{ $calendario->tipo }}&searchBy=' + searchBy.value;
            fetch(url)
                .then(resp => resp.json())
                .then(resp => {
                    let html = '';
                    let provas = resp.provas;
                    provas.forEach(item => {
                        html += `<tr>
                              <td>
                                <input class='form-check-input' type="radio" name="prova_id" value="${item.id}" />
                              </td>
                              <td>${item.professor}</td>
                              <td>${item.disciplina}</td>
                              <td>${item.curso}</td>
                              <td>${item.anolectivo}</td>    
                          </tr>`;
                    });
                    panel.innerHTML = html == '' ? html : createTableProvaHtml(html);
                })

        });
    </script>
@endsection

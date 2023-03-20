@extends('layouts.dash')
@section('css')
  @parent
  <link rel="stylesheet" href="{{ asset('css/panel.css') }}"/>
@endsection
@section('content')
<div class="card">
  <div class="pagetitle m-2">
    <h1>Reuniões</h1>
    <nav>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="{{route('home')}}">Perfil</a></li>
            <li class="breadcrumb-item active">
              <a href="{{route('reunioes.index')}}">Reunião</a>
            </li>
        </ol>
    </nav>
  </div>  
  <span id="formadd" class="d-none fr" data-url="{{route('reunioes.store')}}">
    <i class="bi bi-plus h2"></i>
  </span>
    <div class="card-body">
      <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item d-none" id="profPanel">
          <h2 class="accordion-header" id="flush-headingProf">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseProf" aria-expanded="false" aria-controls="flush-collapseProf"
            > {{-- onclick="hiddenPainelProf()" --}}
              <i class="bi bi-person"></i>
              <span>Professores</span>
            </button>
          </h2>
          <div id="flush-collapseProf" class="accordion-collapse collapse" aria-labelledby="flush-headingProf" data-bs-parent="#accordionFlushExample" style="">
            <form action="{{ route('professor.reuniao') }}" method="POST" class="professors-list" id="professors-list">
              @csrf
              <input type="text" id="reuniao_desc" value="" class="form-control mb-2" disabled/>
              <input type="hidden" id="reuniao" name="reuniao_id"/>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="" id="search-professor"/>
                <span class="input-group-text">
                    <i class="bi bi-search"></i>
                </span>
              </div>
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Curso</th>
                  </tr>
                </thead>
                <tbody id="tbody-professor-list"></tbody>
              </table>
              <button class="btn btn-outline-primary" type="submit">
                <span>Confirmar</span>
              </button>
            </form>
          </div>
        </div>        
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
              <i class="bi bi-card-checklist"></i>
              <span>Formulário</span>
            </button>
          </h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
            <form action="{{route('reunioes.store')}}" method="POST" id="form">
                @csrf
                @method('POST')
                @include('components.form.reuniao')
            </form>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingTwo">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="true" aria-controls="flush-collapseTwo">
                <i class="bi bi-list-check"></i>
                <span>Lista</span>
            </button>
          </h2>
          <div id="flush-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample" style="">
            @include('components.table.reuniao')
          </div>
        </div>
      </div>

    </div>
  </div>   
  @include('components.modal.delete')
</div>
@endsection
@section('script')
  @parent
  <script>
    const btnDels = document.querySelectorAll('.btn-del');
    const btnUps = document.querySelectorAll('.btn-up');
    
    const method = document.querySelector('[name="_method"]');
    const span = document.querySelector('#formadd');
    const form = document.querySelector('#form');
    
    function text(...arg){
        document.querySelector('#nome').value = arg[0];
        document.querySelector('#data_inicio').value = arg[1];
        document.querySelector('#data_fim').value = arg[2];
        document.querySelector('#descricao').innerHTML = arg[3];
        document.querySelector('#span-reuniao').innerHTML = arg[4];
    }

    span.addEventListener('click',function(e){
      form.action = span.dataset.url;
      if(!span.classList.contains('d-none')) span.classList.add('d-none');
      text("","","","","Cadastra");
      method.value = "POST";
    });

    btnUps.forEach(item => {
      item.addEventListener('click',function(e){
        let row = item.parentNode.parentNode;
        let tds = row.querySelectorAll('td');
        form.action = item.dataset.up;
        if(span.classList.contains('d-none')) span.classList.remove('d-none');
        text(tds[0].innerHTML,tds[1].innerHTML,tds[2].innerHTML,tds[3].innerHTML,"Actualizar");
        method.value = "PUT";
      });
    });

    btnDels.forEach(item => {
      item.addEventListener('click',function(e){
        let formDelete = document.querySelector('#formDelete');
        formDelete.action = item.dataset.del;
      });
    });

    const panel = document.querySelector('#profPanel');
    const tbody = document.querySelector('#tbody-professor-list');
    const reuniaoDesc = document.querySelector("#reuniao_desc");
    const reuniao = document.querySelector("#reuniao");

    function openProfPanel(descricao, id){
      tbody.innerHTML = "";
      reuniaoDesc.value = descricao;
      if(panel.classList.contains('d-none'))
        panel.classList.remove('d-none');
      reuniao.value = id;
    }

    function hiddenPainelProf(){
      tbody.innerHTML = "";
      reuniaoDesc.value = "";
      if(!panel.classList.contains('d-none'))
        panel.classList.add('d-none');
      document.querySelector("#search-professor").value = "";
    }

    const searchProf = document.querySelector("#search-professor");
        searchProf.addEventListener('blur', function(e){
            let url = '{{ route('professors.list.json') }}?search='+e.target.value+'&reuniao='+reuniao.value;
            fetch(url)
                .then(resp => resp.json())
                .then(resp => {
                    let html = '';
                    let professores = resp.professores;
                    let panel = document.querySelector('#tbody-professor-list');
                    professores.forEach(item => {
                        html += `<tr>
                                  <td>
                                    <input class='form-check-input' type="checkbox" name="professor_id[]" value="${item.id}" 
                                    ${item.convidado ? 'checked' : ''}/>
                                  </td>
                                  <td>${item.professor}</td>
                                  <td>${item.curso}</td>
                              </tr>`;
                    });
                    panel.innerHTML = html;
                })

        });


  </script>
@endsection
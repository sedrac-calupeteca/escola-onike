@extends('layouts.dash')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}" />
@endsection
@section('content')
    <div class="card">
        <div class="pagetitle m-2">
            <h1>Nota</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('home') }}">{{ $userType }}</a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="card-body">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($mapTurmaWithNotas as $obj)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-heading{{$loop->index}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse{{$loop->index}}" aria-expanded="false" aria-controls="flush-collapse{{$loop->index}}">
                                <i class="bi bi-card-checklist"></i>
                                <span class="pl-2">
                                    Curso: {{ $obj->turma->curso->nome }} -
                                    Periodo: {{ $obj->turma->periodo }} -
                                    Sala: {{ $obj->turma->sala }} -
                                    Ano lective: {{ $obj->turma->ano_lectivo->codigo }}
                                </span>
                            </button>
                        </h2>
                        <div id="flush-collapse{{$loop->index}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$loop->index}}"
                            data-bs-parent="#accordionFlushExample" style="">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bi bi-calendar-event"></i>
                                            <span>Simestre</span>
                                        </th>
                                        <th>
                                            <i class="bi bi-file-earmark-ruled"></i>
                                            <span>Tipo</span>
                                        </th>
                                        <th>
                                            <i class="bi bi-book"></i>
                                            <span>Disciplina</span>
                                        </th>                                        
                                        <th>
                                            <i class="bi bi-person"></i>
                                            <span>Valor</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($obj->notas as $nota)
                                        <tr>
                                            <td>{{ simestres()[$nota->prova->simestre] }}</td>
                                            <td>{{ tipoProvas()[$nota->prova->tipo] }}</td>
                                            <td>{{ $nota->prova->professor_turma->disciplina->nome}}</td>
                                            <td>{{ $nota->valor ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('script')
    @parent
@endsection

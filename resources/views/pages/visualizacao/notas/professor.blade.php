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
            @foreach ($turmas as $obj)
                <div class="accordion accordion-flush" id="accordionFlushExample{{ $loop->index }}">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-heading{{ $loop->index }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse{{ $loop->index }}" aria-expanded="false"
                                aria-controls="flush-collapse{{ $loop->index }}">
                                <i class="bi bi-card-checklist"></i>
                                <span class="pl-2">
                                    Disciplina: {{ $obj->disciplina->nome }} -
                                    Curso: {{ $obj->turma->curso->nome }} -
                                    Periodo: {{ $obj->turma->periodo }} -
                                    Ano lectivo: {{ $obj->turma->ano_lectivo->codigo }}
                                </span>
                            </button>
                        </h2>
                        <div id="flush-collapse{{ $loop->index }}" class="accordion-collapse collapse"
                            aria-labelledby="flush-heading{{ $loop->index }}"
                            data-bs-parent="#accordionFlushExample{{ $loop->index }}" style="">
                            <table>
                                <thead>
                                    <tr>
                                        <th>

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($obj->provas as $prova)
                                        <tr>
                                            <td>{{$prova}}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('script')
    @parent
@endsection

@extends('layouts.dash')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}" />
@endsection
@section('content')
    <div class="card">
        <div class="pagetitle m-2">
            <h1>Acesso negado</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">
                        <a href="{{ url()->previus() }}">voltar</a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="card-body">
            <p class="t-j">
                Caro utilizador {{Auth::user()->name}}, não tens permissão para fazer esta operação, sé por acaso 
                tens multiplos perfil como funcionário, aluno e professor, deves activar um dos perfil
            </p>
            @isset($message)
                <p>
                    {{ $message }}
                </p>
            @endisset
        </div>
    </div>
@endsection

@extends('layouts.doc')
@section('body')
    @php $page = isset($painel) ? $painel : "" ; @endphp
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="{{ asset('img/logo.png') }}" alt="">
                <span class="d-none d-lg-block">EscolaOnilka</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

        @isset($search)
            <div class="search-bar">
                <form class="search-form d-flex align-items-center" style="width: 450px;" method="GET"
                    action="{{ url()->current() }}">
                    @isset($search->fields)
                        <a href="{{ url()->current() }}" class="btn btn-secondary btn-lg" title="recarregar">
                            <i class="bi bi-arrow-repeat"></i>
                        </a>
                        <select name="arg" id="arg" class="form-control w-50">
                            @foreach ($search->fields as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    @endisset
                    <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                </form>
            </div>
        @endisset

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="{{ $auth->image ? url('storage/'.$auth->image) : asset('img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ abreviarNome($auth) }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ $auth->name }}</h6>
                            <span>utilizador</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('home') }}">
                                <i class="bi bi-person"></i>
                                <span>Perfil</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                <i class="bi bi-question-circle"></i>
                                <span>Ajuda?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item d-flex align-items-center text-danger" type="submit">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sair</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

    </header>

    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed @if ($page == 'home') active @endif" href="{{ route('home') }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Perfil</span>
                </a>
            </li>
            @if (ruleNav('usuario'))
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#forms-user" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-people"></i>
                        <span>Usuarios</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="forms-user" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('usuario.index', 'alunos') }}">
                                <i class="bi bi-circle"></i><span>Alunos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('usuario.index', 'professores') }}">
                                <i class="bi bi-circle"></i><span>Professores</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('usuario.index', 'funcionarios') }}">
                                <i class="bi bi-circle"></i><span>Funcionário</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-eye"></i>
                    <span>Visualizar</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('notas.index') }}">
                            <i class="bi bi-circle"></i><span>Notas</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pauta.index') }}">
                            <i class="bi bi-circle"></i><span>Pauta</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('calendarios.list') }}">
                            <i class="bi bi-circle"></i><span>Calendário de prova</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-heading">Panel</li>

            <li class="nav-item">
                <a class="nav-link collapsed @if ($page == 'ano-lectivo') active @endif"
                    href="{{ route('ano-lectivos.index') }}">
                    <i class="bi bi-calendar-plus"></i>
                    <span>Ano lectivo</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed @if ($page == 'prova') active @endif"
                    href="{{ route('provas.index') }}">
                    <i class="bi bi-tags"></i>
                    <span>Prova</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed @if ($page == 'calendario') active @endif"
                    href="{{ route('calendarios.index') }}">
                    <i class="bi bi-calendar"></i>
                    <span>Calendário</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed @if ($page == 'reuniao') active @endif"
                    href="{{ route('reunioes.index') }}">
                    <i class="bi bi-person-lines-fill"></i>
                    <span>Reunião</span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed @if ($page == 'curso-classe') active @endif"
                    href="{{ route('cursos.index') }}">
                    <i class="bi bi-easel"></i>
                    <span>Cursos e Classes</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed @if ($page == 'disciplina') active @endif"
                    href="{{ route('disciplinas.index') }}">
                    <i class="bi bi-book"></i>
                    <span>Disciplinas</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed @if ($page == 'turma') active @endif"
                    href="{{ route('turmas.index') }}">
                    <i class="bi bi-archive"></i>
                    <span>Turmas</span>
                </a>
            </li>

        </ul>

    </aside>

    <main id="main" class="main">
        @include('components.erros')

        @yield('content')

    </main>

    @if (isset($footer) && $footer)
        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed by
                <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </footer>
    @endif

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>
@endsection

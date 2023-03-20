@extends('layouts.doc')
@section('body')
    <div hidden>
        <h1>Escola Onike</h1>
    </div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">EscolaOnike</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">
                            <i class="bi bi-house"></i>
                            <span>Página inicial</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-card-checklist"></i>
                            <span>Painel</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">pesquisar</button>
                </form>
            </div>
        </div>
    </nav>
    <header class="bg-info ">
        <div class="p-2">
            <div class="row">
                <div class="col-md-7 text-center text-light">
                    <div class="m-2">
                        <hgroup class="mt-3 mb-3">
                            <h2>Seja bem vindo!</h2>
                            <h3>ao website da escola Onika</h3>
                        </hgroup>
                        <p class="border-top pt-3 h5">
                            Neste website irás encontra informações relacionada com a escola privada Onike.
                        </p>
                        <p class="text-justify pt-3 h4">
                            A instituição ofereçe serviços de qualidade para a educação de criança e adolescente,
                            é uma escola de ensino primário e secundário (com cursos técncos) com uma mensalidade
                            accessível.
                        </p>

                        @if (Route::has('login'))
                            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                                @auth
                                    <a href="{{ url('/home') }}" class="btn btn-success btn-lg rounded-pill">
                                        <i class="bil bi-house"></i>
                                        <span>Painel de control</span>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-light btn-lg rounded-pill">
                                        <i class="bil bi-key"></i>
                                        <span>Autenticação</span>
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-warning btn-lg rounded-pill">
                                            <i class="bi bi-person-badge-fill"></i>
                                            <span>Cadastramento</span>
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif

                    </div>
                </div>
                <div class="col-md-5">
                    <img src="{{ asset('img/online-graduation.svg') }}" alt="" width="500" height="500">
                </div>
            </div>
        </div>
    </header>
    <section class="m-3">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                    type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                    <i class="bi bi-building-fill-check"></i>
                    <span>Sobre nós</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                    type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Localização</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane"
                    type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
                    <i class="bi bi-telephone"></i>
                    <span>Contacto</span>
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active bg-white p-1" id="home-tab-pane" role="tabpanel"
                aria-labelledby="home-tab" tabindex="0">
                <p class="text-justify">Somos uma instituição de ensino primário e secundário, lecionamos as seguintes
                    classes e cursos.</p>
                <p class="text-justify">Ensino primário:</p>
                <ul>
                    <li>7ª classe</li>
                    <li>8ª classe</li>
                    <li>9ª classe</li>
                </ul>
                <p class="text-justify">Ensino Secundário:</p>
                <ul>
                    <li>10ª classe</li>
                    <li>11ª classe</li>
                    <li>12ª classe</li>
                    <li>13ª classe</li>
                </ul>
            </div>
            <div class="tab-pane fade bg-white p-1" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                tabindex="0">
                <p class="text-justify">Caso desejas encontrar a nossas instalações este é nossa localização.</p>
                <ul>
                    <li>
                        <i class="bi bi-globe-europe-africa"></i>
                        <span> <strong>Continente:</strong> África </span>
                    </li>
                    <li>
                        <i class="bi bi-flag"></i>
                        <span> <strong>Páis:</strong> Angola </span>
                    </li>
                    <li>
                        <i class="bi bi-globe"></i>
                        <span> <strong>Província:</strong> Benguela </span>
                    </li>
                    <li>
                        <i class="bi bi-buildings"></i>
                        <span> <strong>Município:</strong> Lobito </span>
                    </li>
                </ul>
                <p class="text-justify">
                    Apenas faça o deslocamento para a nossa instituição quando o assunto é necessário, para todo
                    esclarecimento utiliza os nossos contacto para apoio.
                </p>
            </div>
            <div class="tab-pane fade bg-white" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                tabindex="0">
                <p class="text-justify">Caso desejas encontrar a nossas instalações este é nossa localização.</p>
                <ul>
                    <li>
                        <i class="bi bi-enveloped"></i>
                        <span> <strong>Email:</strong> onika@gmail.com </span>
                    </li>
                    <li>
                        <i class="bi bi-telephone"></i>
                        <span> <strong>Contacto:</strong> 998232123 </span>
                    </li>
                    <li>
                        <i class="bi bi-box"></i>
                        <span> <strong>Correio:</strong> onika@onika.com </span>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <footer class="text-center bg-info text-white">
        <div class="container p-4 pb-0">
            <section class="">
                <p class="d-flex justify-content-center align-items-center">
                    <span class="me-3">Faça o seu cadastramento!</span>
                    <button type="button" class="btn btn-outline-light btn-rounded">
                        Cadastra!
                    </button>
                </p>
            </section>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © {{ date('Y') }} Copyright:
            <a class="text-white" href="https://mdbootstrap.com/">MDBootstrap.com</a>
        </div>
    </footer>
@endsection

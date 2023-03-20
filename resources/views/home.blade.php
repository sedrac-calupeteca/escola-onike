@extends('layouts.dash')
@section('content')
    @php $funcao = funcao($auth); @endphp
    <div class="pagetitle">
        <h1>Bem vindo!</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Usuário</li>
                <li class="breadcrumb-item active">Perfil</li>
            </ol>
        </nav>
    </div>

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="{{ $auth->image ? url('storage/'.$auth->image) : asset('img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                        <a href="#" class="text-info text-sm" data-bs-toggle="modal" data-bs-target="#modalFoto">
                            Alterar foto de perfil
                        </a>
                        <h2>{{ $auth->name }}</h2>
                        <h3>{{ $funcao }}</h3>

                        <div class="social-links mt-2">
                            @isset($auth->user_detalhe->twitter)
                                <a href="{{ $auth->user_detalhe->twitter }}" class="twitter" target="_blank">
                                    <i class="bi bi-twitter"></i>
                                </a>
                            @endisset
                            @isset($auth->user_detalhe->facebook)
                                <a href="{{ $auth->user_detalhe->facebook }}" class="facebook" target="_blank">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            @endisset
                            @isset($auth->user_detalhe->instagram)
                                <a href="{{ $auth->user_detalhe->instagram }}" class="instagram" target="_blank">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            @endisset
                            @isset($auth->user_detalhe->linkedin)
                                <a href="{{ $auth->user_detalhe->linkedin }}" class="linkedin" target="_blank">
                                    <i class="bi bi-linkedin"></i>
                                </a>
                            @endisset
                        </div>
                    </div>
                </div>
                @if (existsPerfil())
                    <div class="card">
                        <div class="card-title p-2 bg-primary rounded">
                            <span class="text-white">Perfil</span>
                        </div>
                        <div class="card-body">
                            @php $userPerfil = userPerfilAuth(); @endphp
                            <p class="border-bottom pb-1">
                                Deves escolher um perfil, para trabalhar
                            </p>
                            <form action="{{ route('user.perfil') }}" method="post">
                                @csrf
                                @isset($userPerfil->alunos->id)
                                    <div class="form-group">
                                        <input type="radio" name="perfil" id="alunos" value="alunos"
                                            class="form-input-control" @if ($userPerfil->perfil == "alunos") checked @endif>
                                        <label for="alunos" class="form-label">
                                            aluno
                                        </label>
                                    </div>
                                @endisset
                                @isset($userPerfil->professors->id)
                                    <div class="form-group">
                                        <input type="radio" name="perfil" id="professors" value="professors"
                                            class="form-input-control" @if ($userPerfil->perfil == "professors") checked @endif/>
                                        <label for="alunos" class="form-label">
                                            professor
                                        </label>
                                    </div>
                                @endisset
                                @isset($userPerfil->funcionarios->id)
                                    <div class="form-group">
                                        <input type="radio" name="perfil" id="funcionarios" value="funcionarios"
                                            class="form-input-control" @if ($userPerfil->perfil == "funcionarios") checked @endif/>
                                        <label for="funcionarios" class="form-label">
                                            funcionário
                                        </label>
                                    </div>
                                @endisset
                                <button class="btn btn-primary" type="submit">
                                    <span>salvar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">

                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">
                                    <i class="bi bi-person"></i>
                                    <span>Dados pessoas</span>
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Editar</span>
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">
                                    <i class="bi bi-info-circle"></i>
                                    <span>Informações</span>
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">
                                    <i class="bi bi-key"></i>
                                    <span>Palavra-passe</span>
                                </button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                @isset($auth->user_detalhe->descricao)
                                    <h5 class="card-title">Sobre</h5>
                                    <p class="small fst-italic">{{ $auth->user_detalhe->descricao }}</p>
                                @endisset

                                <h5 class="card-title">Seus dados</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">
                                        <i class="bi bi-person"></i>
                                        <span>Nome</span>
                                    </div>
                                    <div class="col-lg-9 col-md-8">{{ $auth->name }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">
                                        <i class="bi bi-building"></i>
                                        <span>Companhia</span>
                                    </div>
                                    <div class="col-lg-9 col-md-8">Escola Onike, Lobito</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">
                                        <i class="bi bi-person-lines-fill"></i>
                                        <span>Ocupação</span>
                                    </div>
                                    <div class="col-lg-9 col-md-8">{{ $funcao }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">
                                        <i class="bi bi-gender-ambiguous"></i>
                                        <span>Gênero</span>
                                    </div>
                                    <div class="col-lg-9 col-md-8">{{ genero($auth) }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">
                                        <i class="bi bi-calendar"></i>
                                        <span>Data nascimento</span>
                                    </div>
                                    <div class="col-lg-9 col-md-8">{{ $auth->data_nascimento }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">
                                        <i class="bi bi-envelope"></i>
                                        <span>Email</span>
                                    </div>
                                    <div class="col-lg-9 col-md-8">{{ $auth->email }}</div>
                                </div>

                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <div class="row mb-3">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">
                                        <span>Foto de perfil</span>
                                    </label>
                                    <div class="col-md-8 col-lg-9">
                                        <img src="{{ asset('img/profile-img.jpg') }}" alt="Profile">
                                        <div class="pt-2">
                                            <a href="#" class="btn btn-primary btn-sm"
                                                title="Upload new profile image">
                                                <i class="bi bi-upload"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm"
                                                title="Remove my profile image">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('usuarios.update', $auth->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="">
                                        <label for="password_up" class="form-label">
                                            <i class="bi bi-shield-lock"></i>
                                            <span>Digita a sua senha:</span>
                                            <small class="text-danger">*</small>
                                        </label>
                                        <input type="password" name="password_up" id="password_up" class="form-control"
                                            required>
                                    </div>
                                    <hr />
                                    @include('components.form.user', [
                                        'hidden_password' => true,
                                        'user' => $auth,
                                    ])
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                    </div>
                                </form>

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-settings">
                                <form action="{{ route('usuario-detalhe.update', $auth->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="">
                                        <label for="descricao" class="form-label">
                                            <i class="bi bi-chat-left-text"></i>
                                            <span>Descrição</span>
                                        </label>
                                        <input name="descricao" id="descricao" class="form-control"
                                            value="{{ $auth->user_detalhe->descricao ?? old('descricao') }}" />
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label for="contacto" class="form-label">
                                                <i class="bi bi-telephone"></i>
                                                <span>Contacto</span>
                                                <small class="text-danger">*</small>
                                            </label>
                                            <input name="contacto" id="contacto" class="form-control" required
                                                value="{{ $auth->user_detalhe->contacto ?? old('contacto') }}" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email_opt" class="form-label">
                                                <i class="bi bi-envelope"></i>
                                                <span>Email de recuperação</span>
                                                <small class="text-danger">*</small>
                                            </label>
                                            <input name="email_opt" id="email_opt" class="form-control" required
                                                value="{{ $auth->user_detalhe->email_opt ?? old('email_opt') }}" />
                                        </div>
                                    </div>
                                    <hr class="bg-primary" />

                                    <p class="text-center text-primary">
                                        Os links, para as suas redes socias:
                                    </p>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label for="facebook" class="form-label">
                                                <i class="bi bi-facebook"></i>
                                                <span>facebook</span>
                                                <small>(opcional)</small>
                                            </label>
                                            <input name="facebook" id="facebook" class="form-control"
                                                value="{{ $auth->user_detalhe->facebook ?? old('facebook') }}" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="twitter" class="form-label">
                                                <i class="bi bi-twitter"></i>
                                                <span>twitter</span>
                                                <small>(opcional)</small>
                                            </label>
                                            <input name="twitter" id="twitter" class="form-control"
                                                value="{{ $auth->user_detalhe->twitter ?? old('twitter') }}" />
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label for="instagram" class="form-label">
                                                <i class="bi bi-instagram"></i>
                                                <span>instagram</span>
                                                <small>(opcional)</small>
                                            </label>
                                            <input name="instagram" id="instagram" class="form-control"
                                                value="{{ $auth->user_detalhe->instagram ?? old('instagram') }}" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="linkedin" class="form-label">
                                                <i class="bi bi-linkedin"></i>
                                                <span>linkedin</span>
                                                <small>(opcional)</small>
                                            </label>
                                            <input name="linkedin" id="linkedin" class="form-control"
                                                value="{{ $auth->user_detalhe->linkedin ?? old('linkedin') }}" />
                                        </div>
                                    </div>

                                    <div class="text-center mt-2">
                                        <button type="submit" class="btn btn-primary">
                                            salvar
                                        </button>
                                    </div>
                                </form>

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <span>
                                        Atenção, efectuando a troca de palavra passe, será necessário fazer o processo
                                        de autenticação com a novas credências.
                                    </span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('senha.update', $auth->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row mb-3">
                                        <label for="currentPassword" class="form-label">
                                            <i class="bi bi-person-lock"></i>
                                            <span>Senha corrente</span>
                                            <small class="text-danger">*</small>
                                        </label>
                                        <input name="password" type="password" class="form-control" id="currentPassword"
                                            required>
                                    </div>
                                    <hr />
                                    <div class="row mb-3">
                                        <label for="newPassword" class="form-label">
                                            <i class="bi bi-lock"></i>
                                            <span>Senha nova</span>
                                            <small class="text-danger">*</small>
                                        </label>
                                        <input name="newpassword" type="password" class="form-control" id="newPassword"
                                            required>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-form-label">
                                            <i class="bi bi-shield-lock"></i>
                                            <span>Confirma a senha</span>
                                            <small class="text-danger">*</small>
                                        </label>
                                        <input name="renewpassword" type="password" class="form-control"
                                            id="renewPassword" required>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">
                                            <span>alterar</span>
                                        </button>
                                    </div>
                                </form>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    @include('components.modal.foto',[
        'user_id' => Auth::user()->id
    ])
@endsection

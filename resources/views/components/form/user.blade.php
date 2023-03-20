@php $genero = $user->genero ?? old('genero'); @endphp
@if (isset($viewTurmas) && $viewTurmas && ($userType == 'alunos' || $userType == 'professores'))
    <div class="card-body">
        <div class="accordion accordion-flush" id="accordionFlushJoin">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTurma">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseTurma" aria-expanded="false" aria-controls="flush-collapseTurma">
                        <i class="bi bi-archive"></i>
                        <span>Turma</span>
                    </button>
                </h2>
                <div id="flush-collapseTurma" class="accordion-collapse collapse" aria-labelledby="flush-headingTurma"
                    data-bs-parent="#accordionFlushJoin" style="">
                    @isset($turma)
                        <div class="row mb-2">
                            <div class="col-md-4 inline">
                                <label for="tipo" class="form-label" class="form-control">
                                    <i class="bi bi-1-circle"></i>
                                    <span>Sala</span>
                                </label>
                                <input type="text" class="form-control" disabled value="{{$turma->sala}}">
                            </div>                            
                            <div class="col-md-4 inline">
                                <label for="tipo" class="form-label" class="form-control">
                                    <i class="bi bi-easel"></i>
                                    <span>Curso</span>
                                </label>
                                <input type="text" class="form-control" disabled value="{{$turma->curso->nome}}">
                            </div>
                            <div class="col-md-4 inline">
                                <label for="tipo" class="form-label" class="form-control">
                                    <i class="bi bi-brightness-high"></i>
                                    <span>Periodo</span>
                                </label>
                                <input type="text" class="form-control" disabled value="{{$turma->periodo}}">
                            </div>                            
                        </div>
                        <input type="hidden" name="turma_id" value="{{$turma->id}}"/>
                    @else
                        <div class="input-group mb-3">
                        @php $actual = anolectivo(); @endphp
                        <select class="form-control" name="anolectivo" id="choose-anolectivo" style="min-width: 25%;">
                            <option value="0">Todos</option>
                            @isset($anolectivos)
                                @foreach ($anolectivos as $anolectivo)
                                    <option value="{{ $anolectivo->id }}" @if ($anolectivo->id == $actual->id) selected @endif>
                                        {{ $anolectivo->codigo }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        <input type="hidden" id="userType" value="{{ $userType }}" disabled />
                        <input type="text" class="form-control" placeholder="nona" id="search-turma"
                            style="width: 65%;" />
                        <span class="input-group-text" style="min-width: 10%;">
                            <i class="bi bi-search"></i>
                        </span>
                        </div>
                        <div class="table-responsive" id="tab-turma-resp"></div>
                    @endisset
                </div>
            </div>
            @if ($userType == 'professores')
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingDisciplina">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseDisciplina" aria-expanded="false"
                            aria-controls="flush-collapseDisciplina">
                            <i class="bi bi-book"></i>
                            <span>Disciplinas</span>
                        </button>
                    </h2>
                    <div id="flush-collapseDisciplina" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingDisciplina" data-bs-parent="#accordionFlushJoin" style="">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder=""
                                id="search-disciplina">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                        </div>
                        <div class="table-responsive" id="tab-disciplina-resp"></div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif

<input type="hidden" name="user_id" id="user_id" value="">
<div class="row">
    <div class="col-md-6 @isset($inline) inline @endisset">
        <label for="yourUsername" class="form-label">
            <i class="bi bi-person"></i>
            <span>Nome</span>
            <small class="text-danger">*</small>
        </label>
        <div class="input-group has-validation">
            <input type="text" name="name" class="form-control" id="nome" required
                value="{{ $user->name ?? old('name') }}">
            <div class="invalid-feedback">Verifica o nome inserido!</div>
        </div>
    </div>
    <div class="col-md-6 @isset($inline) inline @endisset">
        <label for="yourEmail" class="form-label">
            <i class="bi bi-envelope"></i>
            <span>Email</span>
            <small class="text-danger">*</small>
        </label>
        <div class="input-group has-validation">
            <span class="input-group-text" id="inputGroupPrepend">@</span>
            <input type="email" name="email" class="form-control" id="email" required
                value="{{ $user->email ?? old('email') }}">
            <div class="invalid-feedback">Verifica o email inserido!</div>
        </div>
    </div>
</div>
@if (!isset($hidden_password))
    <div class="row mt-2 item-password @isset($inline) inline @endisset">
        <div class="col-md-6">
            <label for="yourPassword" class="form-label">
                <i class="bi bi-shield"></i>
                <span>Senha:</span>
            </label>
            <input type="password" name="password" class="form-control" id="yourPassword" required
                value="{{ old('password') }}">
            <div class="invalid-feedback">Verifica a senha inserido!</div>
        </div>
        <div class="col-md-6 item-password">
            <label for="yourPasswordConfirmation" class="form-label">
                <i class="bi bi-key"></i>
                <span>Confirma(senha):</span>
            </label>
            <input type="password" name="password_confirmation" class="form-control" id="yourPasswordConfirmation"
                required value="{{ old('password_confirmation') }}">
            <div class="invalid-feedback">Verifica a senha inserido!</div>
        </div>
    </div>
@endif
<div class="row mt-2 mb-2 @isset($inline) inline @endisset">
    <div class="col-md-6">
        <label for="yourGenero" class="form-label">
            <i class="bi bi-gender-ambiguous"></i>
            <span>Gênero</span>
            <small class="text-danger">*</small>
        </label>
        <select name="genero" class="form-control" id="genero">
            <option value="M" @if ($genero == 'M') selected @endif>MASCULINO</option>
            <option value="F" @if ($genero == 'F') selected @endif>FEMENINO</option>
        </select>
        <div class="invalid-feedback">Verifica o gênero inserido!</div>
    </div>
    <div class="col-md-6">
        <label for="yourBithday" class="form-label">
            <i class="bi bi-calendar"></i>
            <span>Data nascimento</span>
            <small class="text-danger">*</small>
        </label>
        <input type="date" name="data_nascimento" class="form-control" id="data_nascimento" required
            value="{{ $user->data_nascimento ?? old('data_nascimento') }}">
        <div class="invalid-feedback">Verifica a data nascimento inserido!</div>
    </div>
</div>
@if (isset($detalhe_required))
    <div class="row mt-2 @isset($inline) inline @endisset">
        <div class="col-md-6">
            <label for="contacto" class="form-label">
                <i class="bi bi-telephone"></i>
                <span>Contacto</span>
                <small class="text-danger">*</small>
            </label>
            <input name="contacto" id="contacto" class="form-control" required="" value="">
        </div>
        <div class="col-md-6">
            <label for="email_opt" class="form-label">
                <i class="bi bi-envelope"></i>
                <span>Email de recuperação</span>
                <small class="text-danger">*</small>
            </label>
            <input name="email_opt" id="email_opt" class="form-control" required="" value="">
        </div>
    </div>
@endif
@php $exists = isset($user_type); @endphp

@if ($exists)
    <div class="row">
        <input type="hidden" disabled id="user_type" value="{{$user_type}}">
@endif
<div class="col-md-6 @isset($inline) inline @endisset">
    <label for="yourBi" class="form-label">
        <i class="bi bi-person-vcard"></i>
        <span>Bilhete de identidade</span>
        <small class="text-danger">*</small>
    </label>
    <input type="text" name="bilhete_identidade" class="form-control" id="bilhete_identidade" required
        value="{{ $user->bilhete_identidade ?? old('bilhete_identidade') }}">
    <div class="invalid-feedback">Verifica o bilhete de identidade inserido!</div>
</div>
@if ($exists && $user_type == 'funcionarios')
    @php
    $cargos = cargos(); 
    @endphp
    <div class="col-md-6 @isset($inline) inline @endisset @isset($hidden_btn) pb-2 @endisset">
        <label for="funcao" class="form-label">
            <i class="bi bi-person-vcard"></i>
            <span>Cargos</span>
            <small class="text-danger">*</small>
        </label>
        <select name="funcao" id="funcao" class="form-control">
            @foreach ($cargos as $key => $value)
                <option value="{{ $key }}"> {{ $value }} </option>
            @endforeach
        </select>
        <div class="invalid-feedback">Verifica o bilhete de identidade inserido!</div>
    </div>
@endif
@if ($exists)
    </div>
@endif
@if(!isset($hidden_btn))
<button class="btn btn-outline-primary rounded-pill mt-3">
    <i class="bi bi-check-circle"></i>
    <span id="span-user">cadastra</span>
</button>
@endif
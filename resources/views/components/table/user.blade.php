@php
    $isAluno = isset($userType) && $userType == 'alunos';
    $isProfessor = isset($userType) && $userType == 'professores';
    $isFuncionario = isset($userType) && $userType == 'funcionarios';
@endphp
<div class="table-responsive">
    <table class="table text-center">
        <thead>
            <tr>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-file-word"></i>
                        <span>Nome</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-calendar-check"></i>
                        <span>Email</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-calendar-x"></i>
                        <span>Gênero</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-chat-left"></i>
                        <span>Data nascimento</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-chat-left"></i>
                        <span>BI</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-telephone"></i>
                        <span>Contacto</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-envelope"></i>
                        <span>Email Recuperação</span>
                    </div>
                </th>
                @if ($isAluno)
                    <th>
                        <div class="th-icone">
                            <i class="bi bi-easel"></i>
                            <span>Curso</span>
                        </div>
                    </th>
                    <th>
                        <div class="th-icone">
                            <i class="bi bi-collection"></i>
                            <span>Classe</span>
                        </div>
                    </th>
                    <th>
                        <div class="th-icone">
                            <i class="bi bi-mortarboard"></i>
                            <span>Nível</span>
                        </div>
                    </th>
                    <th>
                        <div class="th-icone">
                            <i class="bi bi-calendar-plus"></i>
                            <span>Ano lectivo</span>
                        </div>
                    </th>
                    <th>
                        <div class="th-icone">
                            <i class="bi bi-back"></i>
                            <span>matricula</span>
                        </div>
                    </th>
                @endif
                @if ($isFuncionario)
                    <th>
                        <div class="th-icone">
                            <i class="bi bi-person-lines-fill"></i>
                            <span>Função</span>
                        </div>
                    </th>
                @endif
                @if ($isProfessor)
                    <th>
                        <div class="th-icone">
                            <i class="bi bi-easel"></i>
                            <span>Disciplina</span>
                        </div>
                    </th>
                @endif
                @if (!isset($reuniao))
                    <th colspan="2">
                        <div class="th-icone">
                            <i class="bi bi-tools"></i>
                            <span>Acção</span>
                        </div>
                    </th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td data-user="{{ $usuario->id }}">{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td data-genero={{ $usuario->genero }}>{{ genero($usuario) }}</td>
                    <td>{{ $usuario->data_nascimento }}</td>
                    <td>{{ $usuario->bilhete_identidade }}</td>
                    <td>{{ $usuario->user_detalhe->contacto ?? '' }}</td>
                    <td>{{ $usuario->user_detalhe->email_opt ?? '' }}</td>
                    @if ($isAluno)
                        @php
                            $turmaAluno = $usuario->alunos->turma;
                            $cursoAluno = $turmaAluno->curso;
                        @endphp
                        <td hidden data-user="aluno" data-sala={{ $turmaAluno->sala }}
                            data-periodo={{ $turmaAluno->periodo }} data-turma={{ $turmaAluno->id }}></td>
                        <td>{{ $cursoAluno->nome }}</td>
                        <td>{{ $cursoAluno->num_classe }}</td>
                        <td>{{ $cursoAluno->nivel }}</td>
                        <td>{{ $usuario->alunos->turma->ano_lectivo->codigo }}</td>
                        <td>
                            @if (exist_matricula($usuario))
                                <a class="bg-danger rounded-circle p-2 mt-2"
                                    href="{{ route('matricula.action', ['remove', $usuario->alunos->id]) }}"
                                    title="eliminar matricula">
                                    <i class="bi bi-trash text-white"></i>
                                </a>
                            @else
                                <a class="bg-success rounded-circle p-2 mt-2"
                                    href="{{ route('matricula.action', ['create', $usuario->alunos->id]) }}"
                                    title="adicionar matricula">
                                    <i class="bi bi-plus text-white"></i>
                                </a>
                            @endif
                        </td>
                    @endif
                    @if ($isFuncionario)
                        <td data-value="{{$usuario->funcionarios->funcao}}">
                            {{  cargos()[$usuario->funcionarios->funcao] }}
                        </td>
                    @endif
                    @if ($isProfessor)
                        <td>
                            <a href="{{ route('professor.disciplina.leciona', $usuario->professors->id) }}"
                                class="btn btn-outline-success rounded-pill">
                                <div class="th-icone">
                                    <i class="bi bi-list"></i>
                                    <span>leciona</span>
                                </div>
                            </a>
                        </td>
                    @endif
                    @if (!isset($reuniao))
                        <td>
                            <button class="btn btn-outline-danger rounded-pill btn-del" data-bs-toggle="modal"
                                data-bs-target="#modalDelete" data-del="{{ route('usuario.destroy', $userType) }}">
                                <div class="th-icone">
                                    <i class="bi bi-trash"></i>
                                    <span>eliminar</span>
                                </div>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-outline-warning rounded-pill btn-up" type="button"
                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne" data-up="{{ route('usuario.update', $userType) }}">
                                <div class="th-icone">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>editar</span>
                                </div>
                            </button>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pagination mt-3">
    {{ $usuarios->links() }}
</div>

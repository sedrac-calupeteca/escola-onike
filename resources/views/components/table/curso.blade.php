@php $choose = isset($action) && $action == "choose"; @endphp
@if ($choose)
    <form action="{{ route('disciplina.curso.store', $disciplina->id) }}" method="POST" class="position-relative">
        @csrf
        <div class="w-25">
            <div class="input-group mb-3">
                <select class="form-control" placeholder="Ano lectivo" name="anolectivo" required>
                    @foreach ($anolectivos as $anolectivo)
                        <option value="{{ $anolectivo->id }}">{{ $anolectivo->codigo }}</option>
                    @endforeach
                </select>
                <button class="input-group-text btn btn-outline-info" id="basic-addon2" type="submit">
                    <span>inserir</span>
                </button>
            </div>
        </div>
@endif
<div class="table-responsive">
    <table class="table text-center">
        <thead>
            <tr>
                @if ($choose)
                    <th>#</th>
                @endif
                <th>
                    <div class="th-icone">
                        <i class="bi bi-file-word"></i>
                        <span>Nome</span>
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
                        <i class="bi bi-check"></i>
                        <span>Estado</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-chat-left"></i>
                        <span>Descrição</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-archive"></i>
                        <span>Turma</span>
                    </div>
                </th>
                <th colspan="2">
                    <div class="th-icone">
                        <i class="bi bi-book"></i>
                        <span>Disciplina</span>
                    </div>
                </th>
                <th colspan="2">
                    <div class="th-icone">
                        <i class="bi bi-tools"></i>
                        <span>Acção</span>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
                <tr>
                    @if ($choose)
                        <th>
                            <input class="form-check-input" type="checkbox" name="cursos[]"
                                value="{{ $curso->id }}" />
                        </th>
                    @endif
                    <td>{{ $curso->nome }}</td>
                    <td data-value={{ $curso->num_classe }}>{{ $curso->num_classe }}</td>
                    <td data-value={{ $curso->nivel }}>{{ $curso->nivel }}</td>
                    <td data-value={{ $curso->is_fechado }}>{{ cursoEstado($curso) }}</td>
                    <td @isset($curso->descricao) class="tj" @endisset>{{ $curso->descricao ?? '---' }}</td>
                    <td>
                        <a class="btn btn-outline-info rounded-pill"
                            href="{{ route('cursos.turmas', $curso->id) }}">
                            <div class="th-icone">
                                <i class="bi bi-plus"></i>
                                <span>adicionar</span>
                                (<span class="badge badge-primary text-dark">{{ sizeof($curso->turmas) }}</span>)
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-outline-success rounded-pill"
                            href="{{ route('curso.disciplina', $curso->id) }}">
                            <div class="th-icone">
                                <i class="bi bi-list"></i>
                                <span>listar</span>
                                <span class="badge badge-primary text-dark">{{ sizeof($curso->disciplinas) }}</span>
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-outline-primary rounded-pill"
                            href="{{ route('curso.disciplina.add', $curso->id) }}">
                            <div class="th-icone">
                                <i class="bi bi-plus"></i>
                                <span>adicionar</span>
                            </div>
                        </a>
                    </td>                    
                    <td>
                        <button class="btn btn-outline-danger rounded-pill btn-del" data-bs-toggle="modal"
                            data-bs-target="#modalDelete" data-del="{{ route('cursos.destroy', $curso->id) }}">
                            <div class="th-icone">
                                <i class="bi bi-trash"></i>
                                <span>eliminar</span>
                            </div>
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-outline-warning rounded-pill btn-up" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                            aria-controls="flush-collapseOne" data-up="{{ route('cursos.update', $curso->id) }}">
                            <div class="th-icone">
                                <i class="bi bi-pencil-square"></i>
                                <span>editar</span>
                            </div>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if ($choose)
    </form>
@endif

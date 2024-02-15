@php $choose = isset($action) && $action == "choose"; @endphp
@if ($choose)
    <form action="{{ route('curso.disciplina.store', $curso->id) }}" method="POST" class="position-relative">
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
                @if (isset($action_add_remove))
                    <th>
                        Acção
                    </th>
                @endif
                <th>
                    <div class="th-icone">
                        <i class="bi bi-file-word"></i>
                        <span>Nome</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-chat-left"></i>
                        <span>Descrição</span>
                    </div>
                </th>
                @if (isset($action_add_remove))
                    <th>
                        <div class="th-icone">
                            <i class="bi bi-easel"></i>
                            <span>Curso</span>
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
                            <i class="bi bi-brightness-high"></i>
                            <span>Periodo</span>
                        </div>
                    </th>
                @endisset
                @if (!isset($action_btn))
                    <th colspan="2">
                        <div class="th-icone">
                            <i class="bi bi-easel"></i>
                            <span>Curso</span>
                        </div>
                    </th>
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
        @foreach ($disciplinas as $disciplina)
            <tr>
                @if ($choose)
                    <th>
                        <input class="form-check-input" type="checkbox" name="disciplinas[]"
                            value="{{ $disciplina->id }}" />
                    </th>
                @endif
                @if (isset($action_btn) && isset($action_add_remove))
                    <td>
                        @if (in_array($disciplina->id, $disciplinasOfprofessor))
                            <a href="{{route('professor.disciplina.action',[$professor->id,$disciplina->id,"remove"])}}" class="btn btn-danger rounded-circle p-2">
                                <i class="bi bi-trash"></i>
                            </a>
                        @else
                            <a href="{{route('professor.disciplina.action',[$professor->id,$disciplina->id,"add"])}}" class="btn btn-primary rounded-circle p-2">
                                <i class="bi bi-check"></i>
                            </a>
                        @endif
                    </td>
                @endif
                <td>{{ $disciplina->nome }}</td>
                <td @isset($disciplina->descricao) class="tj" @endisset>{{ $disciplina->descricao ?? '---' }}
                </td>
                @if (isset($action_add_remove))
                    <td> {{ $disciplina->professor_turma->turma->curso->nome }} </td>
                    <td> {{ $disciplina->professor_turma->turma->curso->nivel }} </td>
                    <td> {{ $disciplina->professor_turma->turma->periodo }} </td>
                @endisset
                @if (!isset($action_btn))
                    <td>
                        <a class="btn btn-outline-primary btn-sm rounded-pill"
                            href="{{ route('disciplina.curso.add', $disciplina->id) }}">
                            <i class="bi bi-plus"></i>
                            <span>adicionar</span>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-outline-success btn-sm rounded-pill"
                            href="{{ route('disciplina.curso', $disciplina->id) }}">
                            <i class="bi bi-list"></i>
                            <span>listar</span>
                            <span
                                class="badge badge-primary text-dark">{{ sizeof($disciplina->cursos) }}</span>
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-outline-danger btn-sm rounded-pill btn-del" data-bs-toggle="modal"
                            data-bs-target="#modalDelete"
                            data-del="{{ route('disciplinas.destroy', $disciplina->id) }}">
                            <i class="bi bi-trash"></i>
                            <span>eliminar</span>
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-outline-warning btn-sm rounded-pill btn-up" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                            aria-controls="flush-collapseOne"
                            data-up="{{ route('disciplinas.update', $disciplina->id) }}">
                            <i class="bi bi-pencil-square"></i>
                            <span>editar</span>
                        </button>
                    </td>
                @endif
        </tr>
    @endforeach
</tbody>
</table>
</div>
@if ($choose)
</form>
@endif

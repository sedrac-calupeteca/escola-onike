<div class="table-responsive">
    <table class="table text-center">
        <thead>
            <tr>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-calendar-plus"></i>
                        <span>Ano lectivo</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-easel"></i>
                        <span>Curso</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-brightness-high"></i>
                        <span>Periodo</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-1-circle"></i>
                        <span>Sala</span>
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
                        <i class="bi bi-collection"></i>
                        <span>Classe</span>
                    </div>
                  </th>
                  <th>
                    <div class="th-icone">
                        <i class="bi bi-123"></i>
                        <span>Código</span>
                    </div>
                  </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-file-earmark-person-fill"></i>
                        <span>Professor</span>
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
            @foreach ($turmas as $turma)
                <tr>
                    <td data-ano={{ $turma->ano_lectivo_id }}
                        data-inicio={{ $turma->ano_lectivo->data_inicio }}
                        data-fim={{ $turma->ano_lectivo->data_fim }}>
                        {{ $turma->ano_lectivo->codigo }}
                    </td>
                    <td data-curso={{ $turma->curso_id }}>{{ $turma->curso->nome }}</td>
                    <td>{{ $turma->periodo }}</td>
                    <td>{{ $turma->sala }}</td>
                    <td>{{ $turma->curso->nivel }}</td>
                    <td>{{ $turma->curso->num_classe }}</td>
                    <td>{{ $turma->chave }}</td>
                    <td>
                        <a class="btn btn-outline-success btn-sm rounded-pill"
                            href="{{ route('usuario.index', 'professores') }}?turma={{ $turma->id }}">
                            <i class="bi bi-plus"></i>
                            <span>adicionar</span>
                            <span class="badge badge-primary text-dark">{{ sizeof($turma->professors) }}</span>
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-outline-danger btn-sm rounded-pill btn-del" data-bs-toggle="modal"
                            data-bs-target="#modalDelete" data-del="{{ route('turmas.destroy', $turma->id) }}">
                            <i class="bi bi-trash"></i>
                            <span>eliminar</span>
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-outline-warning btn-sm rounded-pill btn-up" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                            aria-controls="flush-collapseOne" data-up="{{ route('turmas.update', $turma->id) }}">
                            <i class="bi bi-pencil-square"></i>
                            <span>editar</span>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

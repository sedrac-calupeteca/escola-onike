<div class="table-responsive">
    @php $hidden = isset($hidden_action) && $hidden_action; @endphp
    <table class="table text-center">
        <thead>
            <tr>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-person"></i>
                        <span>Professor</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-book"></i>
                        <span>Disciplina</span>
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
                        <i class="bi bi-calendar-plus"></i>
                        <span>Ano lectivo</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-calendar"></i>
                        <span>Data marcação</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-calendar-check"></i>
                        <span>Hora inicio</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-calendar-x"></i>
                        <span>Hora fim</span>
                    </div>
                </th>
                @if (!$hidden)
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
            @foreach ($calendarioProvas as $calendarioProva)
                <tr>
                    <td data-value="{{ $calendarioProva->prova_id }}">
                        {{ $calendarioProva->prova->professor_turma->professor->user->name }}
                    </td>
                    <td>{{ $calendarioProva->prova->professor_turma->disciplina->nome }}</td>
                    <td>{{ $calendarioProva->prova->professor_turma->turma->curso->nome }}</td>
                    <td>{{ $calendarioProva->prova->professor_turma->turma->ano_lectivo->codigo }}</td>
                    <td>{{ $calendarioProva->data }}</td>
                    <td>{{ $calendarioProva->hora_comeco }}</td>
                    <td>{{ $calendarioProva->hora_fim }}</td>
                    @if (!$hidden)
                        <td>
                            <button class="btn btn-outline-danger btn-sm rounded-pill btn-del" data-bs-toggle="modal"
                                data-bs-target="#modalDelete"
                                data-del="{{ route('calendario-prova.destroy', $calendarioProva->id) }}">
                                <i class="bi bi-trash"></i>
                                <span>eliminar</span>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-outline-warning btn-sm rounded-pill btn-up" type="button"
                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne"
                                data-up="{{ route('calendario-prova.update', $calendarioProva->id) }}">
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

@php
 $canLanca = permitDirectorGeralSecretario() || permitProfessor();
@endphp
<div class="table-responsive">
    <table class="table text-center">
        <thead>
            <tr>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-calendar-event"></i>
                        <span>Simestre</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-file-earmark-ruled"></i>
                        <span>Tipo</span>
                    </div>
                </th>

                <th>
                    <div class="th-icone">
                        <i class="bi bi-file-earmark-person-fill"></i>
                        <span>Professores</span>
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
                        <i class="bi bi-brightness-high"></i>
                        <span>Periodo</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-1-circle"></i>
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
                        <i class="bi bi-stars"></i>
                        <span>Estado</span>
                    </div>
                </th>
                <th colspan="{{ $canLanca ? '2' : '1' }}">
                    <div class="th-icone">
                        <i class="bi bi-file-text"></i>
                        <span>Notas</span>
                    </div>
                </th>
                @if (!isset($aluno_view) && permitDirectorGeralSecretario())
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
            @foreach ($provas as $prova)
                <tr>
                    <td data-simestre="{{ $prova->simestre }}">{{ simestres()[$prova->simestre] }}</td>
                    <td data-tipo="{{ $prova->tipo }}">{{ tipoProvas()[$prova->tipo] }}</td>
                    <td data-prov_turm="{{ $prova->professor_turma->id }}">
                        {{ $prova->professor_turma->professor->user->name }}</td>
                    <td>{{ $prova->professor_turma->disciplina->nome }}</td>
                    <td data-sala="{{ $prova->professor_turma->turma->sala }}">
                        {{ $prova->professor_turma->turma->curso->nome }}</td>
                    <td>{{ $prova->professor_turma->turma->periodo }}</td>
                    <td>{{ $prova->professor_turma->turma->curso->num_classe }}</td>
                    <td>{{ $prova->professor_turma->turma->curso->nivel }}</td>
                    <td>{{ $prova->professor_turma->turma->ano_lectivo->codigo }}</td>
                    <td class="tj">
                        <div class="th-icone">
                            @if (!$prova->is_terminado)
                                <input class="form-check-input" type="checkbox" name="is_terminado"
                                    id="is_terminado_{{ $loop->index }}" checked disabled>
                                <label for="is_terminado_{{ $loop->index }}">aberto</label>
                            @else
                                <input class="form-check-input" type="checkbox" name="is_terminado"
                                    id="is_terminado_{{ $loop->index }}" disabled>
                                <label for="is_terminado_{{ $loop->index }}">fechado</label>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if (isset($aluno_view) && $canLanca )
                            @php $nota = nota($prova,$aluno); @endphp
                            <span> {{$nota ?? "---"}}</span>
                        @else
                           <a class="btn btn-outline-primary btn-sm rounded-pill" href="{{ route('notas.edit', $prova->id) }}?turma_id={{ $prova->professor_turma->turma_id }}">
                                <div class="th-icone">
                                    <i class="bi bi-send"></i>
                                    <span>lançar</span>
                                </div>
                            </a>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-outline-info btn-sm rounded-pill" href="{{ route('nota.print', $prova->id) }}?turma_id={{ $prova->professor_turma->turma_id }}">
                            <div class="th-icone">
                                <i class="bi bi-printer"></i>
                                <span>pauta</span>
                            </div>
                        </a>
                    </td>
                    @if (!isset($aluno_view) && permitDirectorGeralSecretario())
                        <td>
                            <button class="btn btn-outline-danger btn-sm rounded-pill btn-del" data-bs-toggle="modal"
                                data-bs-target="#modalDelete" data-del="{{ route('provas.destroy', $prova->id) }}">
                                <div class="th-icone">
                                    <i class="bi bi-trash"></i>
                                    <span>eliminar</span>
                                </div>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-outline-warning btn-sm rounded-pill btn-up" type="button"
                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne" data-up="{{ route('provas.update', $prova->id) }}">
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

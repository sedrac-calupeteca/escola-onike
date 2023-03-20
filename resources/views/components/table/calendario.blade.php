<div class="table-responsive">
    @php $hidden = isset($hidden_action) && $hidden_action; @endphp
    <table class="table text-center">
        <thead>
            <tr>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-file-word"></i>
                        <span>Código</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-calendar-check"></i>
                        <span>Data inicio</span>
                    </div>
                </th>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-calendar-x"></i>
                        <span>Data fim</span>
                    </div>
                </th>
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
                        <i class="bi bi-chat-left"></i>
                        <span>Descrição</span>
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
                <th>
                    <div class="th-icone">
                        <i class="bi bi-tags"></i>
                        <span>Provas</span>
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
            @foreach ($calendarios as $calendario)
                <tr>
                    <td data-value="{{ $calendario->ano_lectivo_id }}">{{ $calendario->codigo }}</td>
                    <td>{{ $calendario->data_inicio }}</td>
                    <td>{{ $calendario->data_fim }}</td>
                    <td data-value="{{ $calendario->simestre }}">
                        {{ simestres()[$calendario->simestre] }}
                    </td>
                    <td data-value="{{ $calendario->tipo }}">
                        {{ tipoProvas()[$calendario->tipo] }}
                    </td>
                    <td @isset($calendario->descricao) class="tj" @endisset>{{ $calendario->descricao ?? '---' }}
                    </td>
                    <td>{{ $calendario->ano_lectivo->codigo }}</td>
                    <td class="tj">
                        <div class="th-icone">
                            @if (!$calendario->is_terminado)
                                <input class="form-check-input" type="radio" name="is_terminado"
                                    id="is_terminado_{{ $calendario->id }}" value="1" checked disabled>
                                <label for="is_terminado_{{ $calendario->id }}">aberto</label>
                            @else
                                <input class="form-check-input" type="radio" name="is_terminado"
                                    id="is_terminado_{{ $calendario->id }}" value="0" disabled>
                                <label for="is_terminado_{{ $calendario->id }}">fechado</label>
                            @endif
                        </div>
                    </td>
                    <td>
                        <a class="btn btn-outline-primary rounded-pill"
                            @if (!$hidden)
                                href="{{ route('calendario-prova.show', $calendario->id) }}"
                            @else
                                href="{{ route('calendario-prova.list', $calendario->id) }}"
                            @endif>
                            <div class="th-icone">
                                <i class="bi bi-plus"></i>
                                <span>{{!$hidden ? 'agendar' : 'listar' }}</span>
                                <span>({{ sizeof($calendario->calendario_prova) }})</span>
                            </div>
                        </a>
                    </td>
                    @if (!$hidden)
                        <td>
                            <button class="btn btn-outline-danger rounded-pill btn-del" data-bs-toggle="modal"
                                data-bs-target="#modalDelete"
                                data-del="{{ route('calendarios.destroy', $calendario->id) }}">
                                <div class="th-icone">
                                    <i class="bi bi-trash"></i>
                                    <span>eliminar</span>
                                </div>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-outline-warning rounded-pill btn-up" type="button"
                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne"
                                data-up="{{ route('calendarios.update', $calendario->id) }}">
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

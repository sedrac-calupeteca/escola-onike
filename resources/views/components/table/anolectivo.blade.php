<div class="table-responsive">
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
                        <i class="bi bi-chat-left"></i>
                        <span>Descrição</span>
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
                        <i class="bi bi-archive"></i>
                        <span>Turma</span>
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
            @foreach ($anolectivos as $anolectivo)
                <tr>
                    <td>{{ $anolectivo->codigo }}</td>
                    <td>{{ $anolectivo->data_inicio }}</td>
                    <td>{{ $anolectivo->data_fim }}</td>
                    <td @isset($anolectivo->descricao) class="tj" @endisset >{{ $anolectivo->descricao ?? '---' }}</td>
                    <td class="tj">
                        @if (!$anolectivo->is_terminado)
                            <input class="form-check-input" type="checkbox" name="is_terminado" id="is_terminado_{{$loop->index}}"  checked disabled>
                            <label for="is_terminado_{{$loop->index}}">aberto</label>
                        @else
                            <input class="form-check-input" type="checkbox" name="is_terminado" id="is_terminado_{{$loop->index}}"  disabled>
                            <label for="is_terminado_{{$loop->index}}">fechado</label>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-outline-success btn-sm rounded-pill" href="{{route('ano-lectivos.turmas',$anolectivo->id)}}">
                            <i class="bi bi-plus"></i>
                            <span>adicionar</span>
                            (<span class="badge badge-primary text-dark">
                                {{ sizeof($anolectivo->turmas) }}
                            </span>)
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-outline-danger btn-sm rounded-pill btn-del" data-bs-toggle="modal"
                            data-bs-target="#modalDelete"
                            data-del="{{ route('ano-lectivos.destroy', $anolectivo->id) }}">
                            <i class="bi bi-trash"></i>
                            <span>eliminar</span>
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-outline-warning btn-sm rounded-pill btn-up" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                            aria-controls="flush-collapseOne"
                            data-up="{{ route('ano-lectivos.update', $anolectivo->id) }}">
                            <i class="bi bi-pencil-square"></i>
                            <span>editar</span>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

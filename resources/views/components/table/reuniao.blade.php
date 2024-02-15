<div class="table-responsive">
    <table class="table text-center">
        <thead>
            <tr>
                <th>
                    <div class="th-icone">
                        <i class="bi bi-file-word"></i>
                        <span>Titulo</span>
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
                <th colspan="2">
                    <div class="th-icone">
                        <i class="bi bi-person"></i>
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
            @foreach ($reunioes as $reuniao)
                <tr>
                    <td>{{ $reuniao->nome }}</td>
                    <td>{{ $reuniao->data_inicio }}</td>
                    <td>{{ $reuniao->data_fim }}</td>
                    <td @isset($anolectivo->descricao) class="tj" @endisset>{{ $reuniao->descricao ?? '---' }}</td>
                    <td>
                        <button class="btn btn-outline-primary btn-sm rounded-pill btn-up" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapseProf" aria-expanded="false"
                            aria-controls="flush-collapseProf" data-up="#" data-reuniao="{{ $reuniao->nome }}"
                            onclick="openProfPanel('{{ $reuniao->nome }}','{{ $reuniao->id }}')">
                            <div class="th-icone">
                                <i class="bi bi-plus"></i>
                                <span>adicionar</span>
                            </div>
                        </button>
                    </td>
                    <td>
                        <a class="btn btn-outline-success btn-sm rounded-pill"
                            href="{{ route('usuario.index', 'professores') }}?reuniao={{ $reuniao->id }}">
                            <div class="th-icone">
                                <i class="bi bi-list"></i>
                                <span>listar</span>
                                <span class="badge badge-primary text-dark">{{ sizeof($reuniao->professors) }}</span>
                            </div>
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-outline-danger btn-sm rounded-pill btn-del" data-bs-toggle="modal"
                            data-bs-target="#modalDelete" data-del="{{ route('reunioes.destroy', $reuniao->id) }}">
                            <div class="th-icone">
                                <i class="bi bi-trash"></i>
                                <span>eliminar</span>
                            </div>
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-outline-warning btn-sm rounded-pill btn-up" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                            aria-controls="flush-collapseOne" data-up="{{ route('reunioes.update', $reuniao->id) }}">
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

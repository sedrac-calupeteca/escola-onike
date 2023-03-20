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
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Atenção:!</strong> nesta barra de pesquisa apenas são procurados turma que já tenhem professores
                    adicionados.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="input-group mb-3">
                    @php $actual = anolectivo(); @endphp
                    <select class="form-control" name="ano_lectivo_id" id="choose-anolectivo" style="min-width: 25%;">
                        <option value="0">Todos</option>
                        @isset($anolectivos)
                            @foreach ($anolectivos as $anolectivo)
                                <option value="{{ $anolectivo->id }}" @if ($anolectivo->id == $actual->id) selected @endif>
                                    {{ $anolectivo->codigo }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                    <input type="text" class="form-control" placeholder="nona" id="search-turma"
                        style="width: 65%;" />
                    <span class="input-group-text" style="min-width: 10%;">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
                <div class="table-responsive" id="tab-turma-resp"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="simestre" class="form-label">
            <i class="bi bi-calendar-event"></i>
            <span>Simeste:</span>
            <span class="text-danger">*</span>
        </label>
        @php $simestres = simestres(); @endphp
        <select name="simestre" id="simestre" class="form-control">
            @foreach ($simestres as $key => $value)
                <option value="{{$key}}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label for="tipo" class="form-label" class="form-control">
            <i class="bi bi-file-earmark-ruled"></i>
            <span>Tipo de prova:</span>
            <span class="text-danger">*</span>
        </label>
        @php $tipos = tipoProvas(); @endphp        
        <select type="number" class="form-control" name="tipo" id="tipo">
            @foreach ($tipos as $key => $value)
                <option value="{{$key}}">{{ $value }}</option>
            @endforeach            
        </select>
    </div>
</div>
<button class="btn btn-outline-primary rounded-pill mt-3">
    <i class="bi bi-check-circle"></i>
    <span id="span-prova">cadastra</span>
</button>

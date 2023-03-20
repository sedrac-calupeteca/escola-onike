<div class="card-body">
    <div class="accordion accordion-flush" id="accordionFlushJoin">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingAnolectivo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseAnolectivo" aria-expanded="false"
                    aria-controls="flush-collapseAnolectivo">
                    <i class="bi bi-calendar-plus"></i>
                    <span>Ano lectivo</span>
                </button>
            </h2>
            <div id="flush-collapseAnolectivo" class="accordion-collapse collapse"
                aria-labelledby="flush-headingAnolectivo" data-bs-parent="#accordionFlushJoin" style="">
                @isset($anolectivo)
                    @include('components.form.anolectivo', [
                        'alunolectivo' => $anolectivo,
                        'inline' => true,
                        'require' => false,
                        'disabled' => true,
                    ])
                    <input type="hidden" name="ano_lectivo_id" value="{{ $anolectivo->id }}" />
                @else
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            Ano lectivo
                        </span>
                        <input type="text" class="form-control" placeholder="ex.: 2020/2021" id="search-anolectivo">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                    <div class="table-responsive" id="tab-anolectivo-resp"></div>
                @endisset
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingCurso">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseCurso" aria-expanded="false" aria-controls="flush-collapseCurso">
                    <i class="bi bi-easel"></i>
                    <span>Curso</span>
                </button>
            </h2>
            <div id="flush-collapseCurso" class="accordion-collapse collapse" aria-labelledby="flush-headingCurso"
                data-bs-parent="#accordionFlushJoin" style="">
                @isset($curso)
                    @include('components.form.curso', [
                        'curso' => $curso,
                        'inline' => true,
                        'require' => false,
                        'disabled' => true,
                    ])
                    <input type="hidden" name="curso_id" value="{{ $curso->id }}" />
                @else
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon2">
                            Curso
                        </span>
                        <input type="text" class="form-control" placeholder="Ciência da computação" id="search-curso">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                    <div class="table-responsive" id="tab-curso-resp"></div>
                @endisset
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="periodo" class="form-label">
            <i class="bi bi-brightness-high"></i>
            <span>Periodo:</span>
            <span class="text-danger">*</span>
        </label>
        <select name="periodo" id="periodo" class="form-control">
            <option value="REGULAR">Regular</option>
            <option value="NOTURNO">Noturno</option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="sala" class="form-label" class="form-control">
            <i class="bi bi-1-circle"></i>
            <span>Sala:</span>
            <span class="text-danger">*</span>
        </label>
        <input type="number" class="form-control" name="sala" id="sala" min="0" max="100" />
    </div>
</div>
<button class="btn btn-outline-primary rounded-pill mt-3">
    <i class="bi bi-check-circle"></i>
    <span id="span-turma">cadastra</span>
</button>

<div class="card-body">
    @php $hidden = isset($hidden_action) && $hidden_action; @endphp
    <div class="accordion accordion-flush" id="accordionFlushJoin">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingCalendario">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseCalendario" aria-expanded="false"
                    aria-controls="flush-collapseCalendario">
                    <i class="bi bi-calendar"></i>
                    <span>Calendário</span>
                </button>
            </h2>
            <div id="flush-collapseCalendario" class="accordion-collapse collapse"
                aria-labelledby="flush-headingCalendario" data-bs-parent="#accordionFlushJoin" style="">
                @include('components.form.calendario', [
                    'calendario' => $calendario,
                    'disabled' => true,
                    'inline' => true,
                ])
            </div>
        </div>
        @if (!$hidden)
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingProva">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseProva" aria-expanded="false" aria-controls="flush-collapseProva">
                        <i class="bi bi-tags"></i>
                        <span>Prova</span>
                    </button>
                </h2>
                <div id="flush-collapseProva" class="accordion-collapse collapse" aria-labelledby="flush-headingProva"
                    data-bs-parent="#accordionFlushJoin" style="">
                    <div class="input-group mb-3">
                        <select name="searchBy" id="searchBy" class="form-control" required>
                            <option value="nome_prof">Professor</option>
                            <option value="nome_disc">Disciplina</option>
                            <option value="nome_curs">Curso</option>
                        </select>
                        <input type="text" class="form-control" placeholder="" id="search-prova"
                            style="width: 65%;" />
                        <span class="input-group-text" style="min-width: 10%;">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                    <div class="table-responsive" id="tab-prova-resp"></div>
                </div>
            </div>
        @endif
    </div>
</div>
@if (!$hidden)
    <div class="row">
        <div class="col-md-4">
            <label for="data" class="form-label">
                <i class="bi bi-calendar-event"></i>
                <span>Data marcação:</span>
                <span class="text-danger">*</span>
            </label>
            <input type="date" name="data" id="data" class="form-control" required />
        </div>
        <div class="col-md-4">
            <label for="hora_comeco" class="form-label">
                <i class="bi bi-clock"></i>
                <span>Hora começo:</span>
                <span class="text-danger">*</span>
            </label>
            <input type="time" name="hora_comeco" id="hora_comeco" class="form-control" />
        </div>
        <div class="col-md-4">
            <label for="tipo" class="form-label" class="form-control">
                <i class="bi bi-clock-pill"></i>
                <span>Hora fim:</span>
                <span class="text-danger">*</span>
            </label>
            <input type="time" name="hora_fim" id="hora_fim" class="form-control" required />
        </div>
    </div>
    <button class="btn btn-outline-primary rounded-pill mt-3">
        <i class="bi bi-check-circle"></i>
        <span id="span-calendario-prova">cadastra</span>
    </button>
@endif

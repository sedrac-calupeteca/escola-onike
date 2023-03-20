<div class="row">
    <div class="col-md-4  @isset($inline) inline @endisset">
        <label for="codigo" class="form-label">
            <i class="bi bi-key"></i>
            <span>Codigo:</span>
            @if (!isset($require))
                <span class="text-danger">*</span>
            @endif
        </label>
        <input type="text" id="codigo" name="codigo" class="form-control" placeholder="2020/2021"
            value="{{ $anolectivo->codigo ?? old('codigo') }}" @isset($disabled) disabled @endisset />
    </div>
    <div class="col-md-4  @isset($inline) inline @endisset">
        <label for="data_inicio" class="form-label" class="form-control">
            <i class="bi bi-calendar-check"></i>
            <span>Data inicio:</span>
            @if (!isset($require))
                <span class="text-danger">*</span>
            @endif
        </label>
        <input type="date" id="data_inicio" name="data_inicio" class="form-control"
            value="{{ $anolectivo->data_inicio ?? old('data_inicio') }}"
            @isset($disabled) disabled @endisset />
    </div>
    <div class="col-md-4  @isset($inline) inline @endisset">
        <label for="data_fim" class="form-label" class="form-control">
            <i class="bi bi-calendar-x"></i>
            <span>Data fim:</span>
            @if (!isset($require))
                <span class="text-danger">*</span>
            @endif
        </label>
        <input type="date" id="data_fim" name="data_fim" class="form-control"
            value="{{ $anolectivo->data_fim ?? old('data_fim') }}"
            @isset($disabled) disabled @endisset />
    </div>
</div>
<div class="mt-1  @isset($inline) inline @endisset">
    <label for="descricao" class="form-label" class="form-control">
        <i class="bi bi-chat-left"></i>
        <span>descrição:</span>
        <small>(opcional)</small>
    </label>
    <textarea id="descricao" name="descricao" class="form-control" @isset($disabled) disabled @endisset>
        {{ $anolectivo->descricao ?? '' }}
    </textarea>
</div>
@if (!isset($inline))
    <button class="btn btn-outline-primary rounded-pill mt-3">
        <i class="bi bi-check-circle"></i>
        <span id="span-anolectivo">cadastra</span>
    </button>
@endif

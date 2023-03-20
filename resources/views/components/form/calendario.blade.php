<div class="row">
    <div class="col-md-6 @isset($inline) inline @endisset">
        <label for="ano_lectivo_id" class="form-label">
            <i class="bi bi-calendar"></i>
            <span>Ano lectivo:</span>
            <span class="text-danger">*</span>
        </label>
        <select name="ano_lectivo_id" id="ano_lectivo_id" class="form-control"
            @isset($disabled) disabled @endisset>
            @isset($anolectivos)
                @foreach ($anolectivos as $anolectivo)
                    <option value="{{ $anolectivo->id }}">{{ $anolectivo->codigo }}</option>
                @endforeach
            @else
                @if ($calendario)
                    <option value="{{$calendario->ano_lectivo_id}}">{{$calendario->ano_lectivo->codigo}}</option>
                @endif    
            @endisset
        </select>
    </div>
    <div class="col-md-6  @isset($inline) inline @endisset">
        <label for="codigo" class="form-label">
            <i class="bi bi-key"></i>
            <span>Codigo:</span>
            @if (!isset($require))
                <span class="text-danger">*</span>
            @endif
        </label>
        <input type="text" id="codigo" name="codigo" class="form-control" placeholder=""
            value="{{ $calendario->codigo ?? old('codigo') }}" @isset($disabled) disabled @endisset />
    </div>
</div>
<div class="row">
    <div class="col-md-6  @isset($inline) inline @endisset">
        <label for="data_inicio" class="form-label" class="form-control">
            <i class="bi bi-calendar-check"></i>
            <span>Data inicio:</span>
            @if (!isset($require))
                <span class="text-danger">*</span>
            @endif
        </label>
        <input type="date" id="data_inicio" name="data_inicio" class="form-control"
            value="{{ $calendario->data_inicio ?? old('data_inicio') }}"
            @isset($disabled) disabled @endisset />
    </div>
    <div class="col-md-6  @isset($inline) inline @endisset">
        <label for="data_fim" class="form-label" class="form-control">
            <i class="bi bi-calendar-x"></i>
            <span>Data fim:</span>
            @if (!isset($require))
                <span class="text-danger">*</span>
            @endif
        </label>
        <input type="date" id="data_fim" name="data_fim" class="form-control"
            value="{{ $calendario->data_fim ?? old('data_fim') }}"
            @isset($disabled) disabled @endisset />
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
        <select name="simestre" id="simestre" class="form-control"
            @isset($disabled) disabled @endisset>
            @foreach ($simestres as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label for="tipo" class="form-label" class="form-control" >
            <i class="bi bi-file-earmark-ruled"></i>
            <span>Tipo de prova:</span>
            <span class="text-danger">*</span>
        </label>
        @php $tipos = tipoProvas(); @endphp
        <select type="number" class="form-control" name="tipo" id="tipo"  @isset($disabled) disabled @endisset>
            @foreach ($tipos as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mt-1  @isset($inline) inline @endisset">
    <label for="descricao" class="form-label" class="form-control">
        <i class="bi bi-chat-left"></i>
        <span>descrição:</span>
        <small>(opcional)</small>
    </label>
    <textarea id="descricao" name="descricao" class="form-control" @isset($disabled) disabled @endisset>
        {{ $calendario->descricao ?? '' }}
    </textarea>
</div>
@if (!isset($inline))
    <button class="btn btn-outline-primary rounded-pill mt-3">
        <i class="bi bi-check-circle"></i>
        <span id="span-calendario">cadastra</span>
    </button>
@endif

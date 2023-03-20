<div class="row">
    <div class="col-md-6 @isset($inline) inline @endisset">
        <label for="nome" class="form-label">
            <i class="bi bi-key"></i>
            <span>Nome:</span>
            @if (!isset($require))
                <span class="text-danger">*</span>
            @endif
        </label>
        <input type="text" id="nome" name="nome" class="form-control" placeholder=""
            value="{{ $curso->nome ?? old('nome') }}" @isset($disabled) disabled @endisset />
    </div>
    <div class="col-md-6 @isset($inline) inline @endisset">
        <label for="is_fechado" class="form-label">
            <i class="bi bi-check"></i>
            <span>Situação:</span>
            @if (!isset($require))
                <span class="text-danger">*</span>
            @endif
        </label>
        <select id="is_fechado" name="is_fechado" class="form-control"
            @isset($disabled) disabled @endisset>
            <option value="1"
                @isset($curso) @if ($curso->is_fechado) selected @endif @endisset>Aberto
            </option>
            <option value="0"
                @isset($curso) @if (!$curso->is_fechado) selected @endif @endisset>Fechado
            </option>
        </select>
    </div>
</div>
<div class="row mt-1">
    <div class="col-md-6 @isset($inline) inline @endisset">
        <label for="num_classe" class="form-label">
            <i class="bi bi-collection"></i>
            <span>Classe:</span>
            @if (!isset($require))
                <span class="text-danger">*</span>
            @endif
        </label>
        @php $classes = ["7","8","9","10","11","12","13"]; @endphp
        <select id="num_classe" name="num_classe" class="form-control"
            @isset($disabled) disabled @endisset>
            @foreach ($classes as $class)
                <option value="{{ $class }}"
                    @isset($curso)   @if ($curso->num_classe == $class) selected @endif @endisset>
                    {{ $class }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 @isset($inline) inline @endisset">
        <label for="nivel" class="form-label">
            <i class="bi bi-mortarboard"></i>
            <span>Nível Academico:</span>
            @if (!isset($require)) <span class="text-danger">*</span> @endif
        </label>
        @php $nivels = ['PRIMARIO'=>'Primário','SECUNDARIO'=>'Secundário','TECNICO'=>'Técnico','MEDIO'=>'Médio']; @endphp
        <select id="nivel" name="nivel" class="form-control"
            @isset($disabled) disabled @endisset>
            @foreach ($nivels as $key => $value)
                <option value="{{ $key }}"
                    @isset($curso)   @if ($curso->nivel == $key) selected @endif @endisset>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="mt-1 @isset($inline) inline @endisset">
    <label for="descricao" class="form-label" class="form-control">
        <i class="bi bi-chat-left"></i>
        <span>descrição:</span>
        <small>(opcional)</small>
    </label>
    <textarea id="descricao" name="descricao" class="form-control" @isset($disabled) disabled @endisset>
        {{ $curso->descricao ?? old('descricao') }}
    </textarea>
</div>
@if (!isset($inline))
    <button class="btn btn-outline-primary rounded-pill mt-3">
        <i class="bi bi-check-circle"></i>
        <span id="span-curso">cadastra</span>
    </button>
@endif

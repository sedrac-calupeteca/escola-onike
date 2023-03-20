    <div class="@isset($inline) inline @endisset">
        <label for="nome" class="form-label">
            <i class="bi bi-key"></i>
            <span>Nome:</span>
            @if (!isset($require)) <span class="text-danger">*</span> @endif
        </label>
        <input type="text" id="nome" name="nome" class="form-control" placeholder=""
            value="{{ $disciplina->nome ?? old('nome') }}" @isset($disabled) disabled @endisset/>
    </div>
    <div class="mt-1 @isset($inline) inline @endisset">
        <label for="descricao" class="form-label" class="form-control">
            <i class="bi bi-chat-left"></i>
            <span>descrição:</span>
            <small>(opcional)</small>
        </label>
        <textarea id="descricao" name="descricao" class="form-control" @isset($disabled) disabled @endisset>
            {{ $disciplina->descricao ?? old('descricao') }}
        </textarea>
    </div>
    @if (!isset($inline))
        <button class="btn btn-outline-primary rounded-pill mt-3">
            <i class="bi bi-check-circle"></i>
            <span id="span-disciplina">cadastra</span>
        </button>
    @endisset

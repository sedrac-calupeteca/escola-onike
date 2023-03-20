<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form class="modal-content" action="#" method="POST" id="formDelete">
        @csrf
        @method('DELETE')
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="modalDeleteLabel">
            <span>Atenção!</span>
          </h5>
          <button type="button" class="" data-bs-dismiss="modal" aria-label="Close" style="background: none; border: none;">
            <span aria-hidden="true" class="text-white h3">x</span>
          </button>
        </div>
        <div class="modal-body">
          <span>
            Tens certeza que desejas realizar esta acção?
          </span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
            <span>Não, cancela</span>
          </button>
          <button type="submit" class="btn btn-primary">
            <span>Sim, confirmo</span>
          </button>
        </div>
      </form>
    </div>
  </div>